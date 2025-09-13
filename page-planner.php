<?php
/* Template Name: Planner (To-Do) */
if ( ! defined('ABSPATH') ) exit;
get_header();

// یه کلید برای localStorage بر اساس یوزر (اگه لاگین نباشه صفر میشه)
$user_id = get_current_user_id();
$ls_key  = 'planit_tasks_v1_' . ( $user_id ? $user_id : 'guest' );
?>
<main class="text-white bg-transparent">
  <!-- هدر ساده‌ی صفحه؛ همون استایل‌های خودت رو تغییر نمیدم -->
  <section class="relative py-10">
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>
    <div class="max-w-5xl mx-auto px-6">
      <h1 class="text-3xl md:text-5xl font-extrabold mb-3"><?php the_title(); ?></h1>
      <?php if (has_excerpt()) : ?>
        <p class="text-white/80"><?php echo get_the_excerpt(); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <!-- کارت فرم اضافه کردن تسک -->
  <section class="relative">
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>
    <div class="max-w-5xl mx-auto px-6 pb-6">
      <div class="rounded-2xl bg-white/10 border border-white/15 p-5 shadow-soft">
        <!-- فرم خیلی ساده: عنوان، تاریخ، اولویت، دسته -->
        <form id="todo-form" class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
          <div class="md:col-span-2">
            <label class="block text-sm mb-1">عنوان کار</label>
            <input id="todo-text" type="text" placeholder="مثلا: تمرین ریاضی"
              class="w-full rounded-xl bg-white/10 border border-white/20 px-3 py-2 outline-none focus:border-white/40 text-gray-900">
          </div>

          <div>
            <label class="block text-sm mb-1">تاریخ</label>
            <input id="todo-date" type="date"
              class="w-full rounded-xl bg-white/10 border border-white/20 px-3 py-2 outline-none focus:border-white/40  ">
          </div>

          <div>
            <label class="block text-sm mb-1">اولویت</label>
            <select id="todo-priority"
              class="w-full rounded-xl bg-white/10 border border-white/20 px-3 py-2 outline-none focus:border-white/40  text-gray-900">
              <option value="normal">معمولی</option>
              <option value="high">زیاد</option>
              <option value="low">کم</option>
            </select>
          </div>

          <div>
            <label class="block text-sm mb-1">دسته</label>
            <input id="todo-cat" type="text" placeholder="درس/ورزش/..."
              class="w-full rounded-xl bg-white/10 border border-white/20 px-3 py-2 outline-none focus:border-white/40">
          </div>

          <div class="md:col-span-5 flex items-center gap-3">
            <button id="btn-add" type="submit"
              class="px-5 py-2 rounded-xl bg-white text-purple-700 font-semibold">+ اضافه کن</button>

            <div class="ms-auto flex items-center gap-2">
              <input id="todo-search" type="text" placeholder="جستجو"
                class="rounded-xl bg-white/10 border border-white/20 px-3 py-2 outline-none focus:border-white/40">
              <select id="todo-filter" class="rounded-xl bg-white/10 border border-white/20 px-3 py-2  text-gray-900">
                <option value="all">همه</option>
                <option value="active">باز</option>
                <option value="done">انجام‌شده</option>
                <option value="today">امروز</option>
              </select>
              <button id="btn-clear-done" type="button"
                class="px-3 py-2 rounded-xl bg-white/10 border border-white/20">حذف انجام‌شده‌ها</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- لیست تسک‌ها -->
  <section class="relative pb-12">
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>
    <div class="max-w-5xl mx-auto px-6">
      <ul id="todo-list" class="space-y-3"></ul>

      <!-- Export / Import خیلی ساده -->
      <div class="mt-8 rounded-2xl bg-white/5 border border-white/10 p-4"><div class="flex flex-wrap items-center gap-3">
          <button id="btn-export" class="px-4 py-2 rounded-xl bg-white text-purple-700 font-semibold">Export JSON</button>
          <label class="px-4 py-2 rounded-xl bg-white/10 border border-white/20 cursor-pointer">
            Import JSON
            <input id="import-file" type="file" accept="application/json" class="hidden">
          </label>
          <span class="text-white/60 text-sm">ذخیره‌سازی لوکال: فقط روی همین مرورگر</span>
        </div>
      </div>
    </div>
  </section>
</main>

<script>
// ====== todo: کد ساده، حداقل JS، لوکال استوریج ======
(function(){
  // کلید استوریج بر اساس یوزر
  var LS_KEY = <?php echo json_encode($ls_key); ?>;

  // اینجا دیتای خام
  var tasks = load();

  // کوئری‌ها
  var $list   = document.getElementById('todo-list');
  var $form   = document.getElementById('todo-form');
  var $text   = document.getElementById('todo-text');
  var $date   = document.getElementById('todo-date');
  var $prio   = document.getElementById('todo-priority');
  var $cat    = document.getElementById('todo-cat');
  var $filter = document.getElementById('todo-filter');
  var $search = document.getElementById('todo-search');

  // رویدادها
  $form.addEventListener('submit', function(e){
    e.preventDefault();
    var t = ($text.value || '').trim();
    if(!t) return;
    var item = {
      id: Date.now(),
      text: t,
      due: $date.value || '',
      prio: $prio.value || 'normal',
      cat : ($cat.value || '').trim(),
      done: false,
      createdAt: Date.now()
    };
    tasks.unshift(item);
    save(); render();
    // پاک کردن فیلدها
    $text.value=''; $date.value=''; $prio.value='normal'; $cat.value='';
  });

  document.getElementById('btn-clear-done').addEventListener('click', function(){
    tasks = tasks.filter(function(i){ return !i.done; });
    save(); render();
  });

  document.getElementById('btn-export').addEventListener('click', function(){
    var blob = new Blob([JSON.stringify(tasks,null,2)], {type:'application/json'});
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'planit-tasks.json';
    a.click();
    URL.revokeObjectURL(a.href);
  });

  document.getElementById('import-file').addEventListener('change', function(e){
    var f = e.target.files[0]; if(!f) return;
    var r = new FileReader();
    r.onload = function(){
      try {
        var arr = JSON.parse(r.result || '[]');
        if(Array.isArray(arr)){ tasks = arr; save(); render(); }
      } catch(_) {}
    };
    r.readAsText(f);
    e.target.value = '';
  });

  $filter.addEventListener('change', render);
  $search.addEventListener('input', render);

  function save(){
    localStorage.setItem(LS_KEY, JSON.stringify(tasks));
  }
  function load(){
    try {
      var raw = localStorage.getItem(LS_KEY);
      var arr = raw ? JSON.parse(raw) : [];
      return Array.isArray(arr) ? arr : [];
    } catch(_) { return []; }
  }

  function isToday(iso){
    if(!iso) return false;
    var d = new Date(iso);
    var n = new Date();
    return d.getFullYear()===n.getFullYear() && d.getMonth()===n.getMonth() && d.getDate()===n.getDate();
  }

  function render(){
    // فیلتر و سرچ
    var mode = $filter.value;
    var q = ($search.value || '').trim();
    var list = tasks.filter(function(i){
      var ok = true;
      if(mode==='active') ok = !i.done;
      if(mode==='done')   ok = i.done;
      if(mode==='today')  ok = isToday(i.due);
      if(q) ok = ok && (i.text.indexOf(q)>-1 || (i.cat||'').indexOf(q)>-1);
      return ok;
    });


  }

  render();
})();
</script>

<?php get_footer(); ?>
<pre>





</pre>