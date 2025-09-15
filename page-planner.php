<?php
/* Template Name: Planner (To-Do) */
if ( ! defined('ABSPATH') ) exit;
get_header();

// یه کلید ساده واسه ذخیره روی مرورگر. اگه لاگین نباشه مهم نیست.
$user_id = get_current_user_id();
$ls_key  = 'planit_tasks_v1_' . ( $user_id ? $user_id : 'guest' );
?>
<main class="text-white bg-transparent" dir="rtl">
  <!-- تیتر صفحه -->
  <section class="relative py-8 md:py-10">
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>
    <div class="max-w-5xl mx-auto px-4 md:px-6">
      <h1 class="text-2xl md:text-4xl font-extrabold mb-2 md:mb-3"><?php the_title(); ?></h1>
      <?php if (has_excerpt()) : ?>
        <p class="text-white/80 text-sm md:text-base"><?php echo get_the_excerpt(); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- فرم اضافه کردن تسک -->
  <section class="relative">
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>
    <div class="max-w-5xl mx-auto px-4 md:px-6 pb-4 md:pb-6">
      <div class="rounded-2xl bg-white/10 border border-white/15 p-4 md:p-5 shadow-soft">
        <!-- اینجا فرم رو خیلی ساده چیدم که تو گوشی بهم نریزه -->
        <form id="todo-form" class="grid grid-cols-1 gap-3 md:grid-cols-5 md:items-end">
          <!-- عنوان کار -->
          <div class="md:col-span-2">
            <label class="block text-xs md:text-sm mb-1">عنوان کار</label>
            <input id="todo-text" type="text" placeholder="مثلا: تمرین ریاضی"
              class="w-full rounded-xl bg-white text-gray-800 px-3 py-2 outline-none focus:ring-2 ">
          </div>

          <!-- تاریخ -->
          <div>
            <label class="block text-xs md:text-sm mb-1">تاریخ</label>
            <input id="todo-date" type="date"
              class="w-full rounded-xl bg-white text-gray-800 px-3 py-2 outline-none focus:ring-2 ">
          </div>

          <!-- اولویت -->
          <div>
            <label class="block text-xs md:text-sm mb-1">اولویت</label>
            <select id="todo-priority"
              class="w-full rounded-xl bg-white text-gray-800 px-3 py-2 outline-none focus:ring-2 ">
              <option value="normal">معمولی</option>
              <option value="high">زیاد</option>
              <option value="low">کم</option>
            </select>
          </div>

          <!-- دسته -->
          <div>
            <label class="block text-xs md:text-sm mb-1">دسته</label>
            <input id="todo-cat" type="text" placeholder="درس/ورزش/..."
              class="w-full rounded-xl bg-white text-gray-800 px-3 py-2 outline-none focus:ring-2 ">
          </div>

          <!-- دکمه اضافه + سرچ و فیلتر -->
          <div class="md:col-span-5 flex flex-col gap-2 md:gap-3 md:flex-row md:items-center md:mt-1">
            <!-- تو گوشی پهن کردم که انگشت راحت بخوره -->
            <button id="btn-add" type="submit"
              class="w-full md:w-auto px-5 py-2 rounded-xl bg-white text-gray-800 font-semibold">+ اضافه کن</button>

            <div class="w-full md:w-auto md:ms-auto flex flex-col md:flex-row gap-2">
              <input id="todo-search" type="text" placeholder="جستجو"
                class="w-full md:w-48 rounded-xl bg-white text-gray-800 px-3 py-2 outline-none focus:ring-2 ">
              <select id="todo-filter"
                class="w-full md:w-40 rounded-xl bg-white text-gray-800 px-3 py-2 outline-none focus:ring-2 ">
                <option value="all">همه</option>
                <option value="active">باز</option>
                <option value="done">انجام‌شده</option>
                <option value="today">امروز</option>
              </select>
              <button id="btn-clear-done" type="button"
                class="w-full md:w-auto px-3 py-2 rounded-xl bg-white/10 border border-white/20">حذف انجام‌شده‌ها</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section><!-- لیست تسک‌ها (فاصله‌ها تو موبایل بیشتره که خفه نشه) -->
  <section class="relative pb-12">
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>
    <div class="max-w-5xl mx-auto px-4 md:px-6">
      <ul id="todo-list" class="space-y-2 md:space-y-3"></ul>
    </div>
  </section>
</main>

<script>

// اینجا یه کلید واسه ذخیره روی مرورگر
var LS_KEY = <?php echo json_encode($ls_key); ?>;

// آرایه کارها
var tasks = loadTasks();

// گرفتن المان‌ها
var listEl   = document.getElementById('todo-list');
var formEl   = document.getElementById('todo-form');
var textEl   = document.getElementById('todo-text');
var dateEl   = document.getElementById('todo-date');
var prioEl   = document.getElementById('todo-priority');
var catEl    = document.getElementById('todo-cat');
var filterEl = document.getElementById('todo-filter');
var searchEl = document.getElementById('todo-search');
var clearBtn = document.getElementById('btn-clear-done');

// اضافه کردن کار
formEl.addEventListener('submit', function(e){
  e.preventDefault();
  var t = (textEl.value || '').trim();
  if(!t){ return; } // خالی نذاره

  var item = {
    id: Date.now(),
    text: t,
    due: dateEl.value || '',
    prio: prioEl.value || 'normal',
    cat : (catEl.value || '').trim(),
    done: false,
    createdAt: Date.now()
  };

  // اول لیست بیاد
  tasks.unshift(item);
  saveTasks();
  renderList();

  // خالی کردن فیلدها
  textEl.value = '';
  dateEl.value = '';
  prioEl.value = 'normal';
  catEl.value  = '';
});

// پاک کردن انجام‌شده‌ها
clearBtn.addEventListener('click', function(){
  tasks = tasks.filter(function(x){ return !x.done; });
  saveTasks();
  renderList();
});

// فیلتر و سرچ
filterEl.addEventListener('change', renderList);
searchEl.addEventListener('input', renderList);

// ذخیره
function saveTasks(){
  try {
    localStorage.setItem(LS_KEY, JSON.stringify(tasks));
  } catch(e){}
}

// لود
function loadTasks(){
  try {
    var raw = localStorage.getItem(LS_KEY);
    var arr = raw ? JSON.parse(raw) : [];
    if(Array.isArray(arr)){ return arr; }
    return [];
  } catch(e){ return []; }
}

// چک امروز
function isToday(iso){
  if(!iso) return false;
  var d = new Date(iso);
  var n = new Date();
  return d.getFullYear()===n.getFullYear() && d.getMonth()===n.getMonth() && d.getDate()===n.getDate();
}

// رندر لیست 
function renderList(){
  var mode = filterEl.value;
  var q = (searchEl.value || '').trim();

  // فیلتر ساده
  var show = tasks.filter(function(i){
    var ok = true;
    if(mode==='active'){ ok = !i.done; }
    if(mode==='done'){ ok = i.done; }
    if(mode==='today'){ ok = isToday(i.due); }
    if(q){ ok = ok && (i.text.indexOf(q)>-1 || (i.cat||'').indexOf(q)>-1); }
    return ok;
  });

  // خروجی
  listEl.innerHTML = '';

  if(!show.length){
    var empty = document.createElement('li');
    empty.className = 'text-white/70 text-sm md:text-base';
    empty.textContent = 'فعلاً کاری اضافه نکردی...';
    listEl.appendChild(empty);
    return;
  }

  // ساخت آیتم‌ها
  for(var a=0; a<show.length; a++){
    var i = show[a];

    var li = document.createElement('li');
    li.className = 'rounded-2xl bg-white/10 border border-white/15 px-3 py-3 md:px-4 md:py-3 flex items-center gap-2 md:gap-3';

    // تیک
    var cb = document.createElement('input');
    cb.type = 'checkbox';
    cb.checked = !!i.done;
    cb.className = 'w-5 h-5 accent-purple-500';
    cb.addEventListener('change', (function(ii,ccb){
      return function(){
        ii.done = ccb.checked;
        saveTasks();
        renderList();
      };
    })(i, cb));

    // متن و متا
    var info = document.createElement('div');
    info.className = 'flex-1 overflow-hidden';

    var title = document.createElement('div');
    title.className = 'font-semibold break-words ' + (i.done ? 'line-through text-white/60' : '');
    title.textContent = i.text;var meta = document.createElement('div');
    meta.className = 'text-xs text-white/70 mt-1';
    var pr = (i.prio==='high'?'اولویت زیاد': (i.prio==='low'?'اولویت کم':'اولویت معمولی'));
    var parts = [];
    if(i.cat){ parts.push('دسته: '+i.cat); }
    parts.push(pr);
    if(i.due){ parts.push('موعد: '+i.due); }
    meta.textContent = parts.join(' · ');

    info.appendChild(title);
    info.appendChild(meta);

    var del = document.createElement('button');
    del.className = 'px-3 py-1 rounded-lg bg-white/10 border border-white/20 text-sm shrink-0';
    del.textContent = 'حذف';
    del.addEventListener('click', (function(ii){
      return function(){
        tasks = tasks.filter(function(x){ return x.id !== ii.id; });
        saveTasks();
        renderList();
      };
    })(i));

    li.appendChild(cb);
    li.appendChild(info);
    li.appendChild(del);
    listEl.appendChild(li);
  }
}

// اول صفحه رندر کنیم
renderList();
</script>

<?php get_footer(); ?>