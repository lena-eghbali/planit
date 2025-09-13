<<<<<<< HEAD
<?php
/* Template Name: Gamification (Planets) */
if ( ! defined('ABSPATH') ) exit;

get_header();

/* ——— تیتر و زیرتیتر که خودم دستی میذارم تو ویرایش برگه ——— */
$pid      = get_the_ID();
$title    = trim( (string) get_post_meta($pid, 'planit_title', true) );
$subtitle = trim( (string) get_post_meta($pid, 'planit_subtitle', true) );
if ($title === '') { $title = get_the_title($pid); } // اگه تیتر نذاشتم، همون عنوان برگه


/* ——— فاصله حلقه‌ها (می‌خوام خودم از کاستومایزر تنظیمش کنم) ——— */
$ringInsets = get_theme_mod('planit_ring_insets', '');
if (is_string($ringInsets) && $ringInsets !== '') {
  $ringInsets = array_map('intval', array_filter(array_map('trim', explode(',', $ringInsets))));
}
if (!is_array($ringInsets) || empty($ringInsets)) {
  // این پیشفرض خودمه که قشنگ‌تر بشه؛ اگه نخواستم، تو سفارشی‌ساز خودم عوضش می‌کنم
  $ringInsets = [60, 45, 25, 10, 0];
}
$perRing = 6; // هر حلقه چندتا نقطه جا بدیم (برای پخش تصادفی)

/* ——— سیاره‌ها از کاستومایزر (اسم/هدف/رنگ) ——— */
/* اینجا فقط همونایی که خودم واقعاً پر کردم میاد؛ بی‌خودی پیشفرض الکی نذاشتم که لو بره */
$planets      = [];
$planet_count = (int) get_theme_mod('planit_planet_count', 0);
if ($planet_count > 12) $planet_count = 12; // زیادیش شلوغ میشه

for ($i=1; $i<=$planet_count; $i++) {
  $name = trim( (string) get_theme_mod("planit_p{$i}_name", '') );
  $goal = (int) get_theme_mod("planit_p{$i}_goal", 0);
  $col  = trim( (string) get_theme_mod("planit_p{$i}_color", '') );

  // اگه اسم یا هدف خالی باشه، کلاً بیخیالش
  if ($name !== '' && $goal > 0) {
    $planets[] = [
      'name'  => $name,
      'goal'  => $goal,
      'color' => ($col !== '' ? $col : '#ffffff'),
    ];
  }
}

/* اگه هنوز چیزی تو کاستومایزر پر نکردم، صفحه خالی میاد ولی خطا نمی‌ده */
if (empty($planets) && current_user_can('edit_theme_options')) {
  echo '<div class="max-w-5xl mx-auto px-6 py-6 text-white/80 text-sm">هنوز هیچ سیاره‌ای تعریف نکردم. برم «نمایش ← سفارشی‌سازی ← گیمیفای – سیاره‌ها» اول تعداد رو زیاد کنم، بعد اسم/هدف/رنگ رو پر کنم.</div>';
}
?>
<!-- هدر صفحه (تیتر/زیرتیتر خودم) -->
<section class="relative py-14 text-white overflow-hidden">
  <!-- ستاره‌ها؛ فقط مطمئن شم این سکشن هم ستاره داره -->
  
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>
  
  <div class="relative max-w-5xl mx-auto px-6">
    <h1 class="text-4xl md:text-5xl font-extrabold mb-2 text-center"><?php echo esc_html($title); ?></h1>
    <?php if($subtitle !== ''): ?>
      <p class="text-white/80 text-center "><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
  </div>
  <div class="custom-content">
  <?php the_content(); ?>
</div>

</section>

<!-- مدار و کنترل‌ها -->
<section class="relative text-white overflow-hidden">
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>

  <div class="relative max-w-5xl mx-auto px-6 py-10">
    <!-- مدار -->
    <div id="orbit-wrap" class="relative mx-auto my-8 w-[320px] h-[320px] md:w-[420px] md:h-[420px]">

      <!-- حلقه‌ها (دوتا خط برای هر حلقه که شیک‌تر دیده شه) -->
      <div id="rings" class="absolute inset-0 spin-slow"
           data-insets='<?php echo wp_json_encode($ringInsets); ?>'
           data-per-ring="<?php echo (int)$perRing; ?>">

        <?php foreach ($ringInsets as $inset): ?>
          <div class="absolute rounded-full border ring-strong ring-glow" style="inset: <?php echo (int)$inset; ?>px;"></div>
          <div class="absolute rounded-full border ring-faint"  style="inset: <?php echo (int)$inset + 3; ?>px;"></div>
        <?php endforeach; ?>

        <?php foreach ($planets as $idx => $pl): ?>
          <div class="planet-dot absolute planet-dot-base dot-dim"
               data-planet-index="<?php echo $idx; ?>"
               data-color="<?php echo esc_attr($pl['color']); ?>">
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- پنل وضعیت الان -->
    <div class="rounded-2xl bg-white/5 border border-white/10 p-6 flex flex-col md:flex-row items-center justify-between gap-4"><div>
        <div class="text-lg">الان روی: <span id="now-planet" class="font-bold"></span></div>
        <div class="text-sm text-white/80 mt-1">
          پیشرفت: <span id="now-progress" class="font-bold"></span> / <span id="now-goal"></span> تسک
        </div>
      </div>
      <div class="flex items-center gap-3">
        <button id="btn-add" class="px-4 py-2 rounded-xl bg-white text-purple-700 font-semibold">+۱ تسک</button>
        <button id="btn-reset" class="px-3 py-2 rounded-xl bg-white/10 border border-white/20 text-white">ریست</button>
      </div>
    </div>

    <!-- کارت‌های خلاصه سیاره‌ها -->
    <?php if(!empty($planets)): ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
      <?php foreach ($planets as $i=>$pl): ?>
        <div class="rounded-2xl bg-white/5 border border-white/10 p-5">
          <div class="text-xl font-extrabold mb-1"><?php echo esc_html($pl['name']); ?></div>
          <div class="text-white/70 text-sm">هدف: <?php echo (int)$pl['goal']; ?> تسک</div>
          <div class="mt-2 text-xs text-white/70">
            رنگ:
            <span style="background:<?php echo esc_attr($pl['color']); ?>; width:14px; height:14px; display:inline-block; border-radius:9999px; vertical-align:middle;"></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- اگه محتوایی تو خود برگه نوشته باشم، پایین صفحه نشون بده (نه جای تیتر) -->
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <?php endwhile; endif; ?>

  </div>
</section>

<script>
/* ——— استیت محلی، هایلایت سیاره فعلی، چینش دات‌ها (همون منطق خودمه) ——— */
var PL  = <?php echo wp_json_encode($planets); ?>;
var KEY = 'planit_progress_v1';

function loadState(){
  try { return JSON.parse(localStorage.getItem(KEY)) || {progress:0, idx:0}; }
  catch(e){ return {progress:0, idx:0}; }
}
function saveState(st){ localStorage.setItem(KEY, JSON.stringify(st)); }
function calcIndex(progress){
  var idx = 0, sum = 0;
  for (var i=0;i<PL.length;i++){
    sum += (+PL[i].goal||0);
    if (progress < sum){ idx = i; break; }
    idx = Math.min(i+1, PL.length-1);
  }
  return idx;
}

document.addEventListener('DOMContentLoaded', function(){
  var st = loadState(); st.idx = calcIndex(st.progress);

  var wrap   = document.getElementById('orbit-wrap');
  var rings  = document.getElementById('rings');
  if (!rings || !wrap) return;

  var dots   = rings.querySelectorAll('.planet-dot');

  var insets = []; try { insets = JSON.parse(rings.getAttribute('data-insets')) || []; } catch(e){}
  var perRing = parseInt(rings.getAttribute('data-per-ring')||'6',10);
  var ringCount = insets.length;

  function setupDots(){
    var rect = wrap.getBoundingClientRect();
    var w=rect.width, h=rect.height, cx=w/2, cy=h/2, outer=Math.min(w,h)/2;
    dots.forEach(function(dot,i){
      var ringIndex = Math.floor(i/perRing);
      if(ringIndex > ringCount-1) ringIndex = ringCount-1;
      var inset = insets[ringIndex] || 0;
      var r = outer - inset - 8;

      // پخش تصادفی ساده بر اساس اندیس (که هر بار جای هر نقطه تقریباً ثابت بمونه)
      var seed=(i+1)*9301%233280, ang=(seed/233280)*Math.PI*2;
      var x=cx+Math.cos(ang)*r, y=cy+Math.sin(ang)*r;

      var col = dot.getAttribute('data-color')||'#fff';
      dot.style.background=col;
      dot.style.left=(x-8)+'px';
      dot.style.top=(y-8)+'px';
      dot.style.zIndex=30;
    });
  }

  function highlight(idx){
    var nowPlanet=document.getElementById('now-planet'),
        nowGoal  =document.getElementById('now-goal'),
        nowProg  =document.getElementById('now-progress');

    dots.forEach(function(d){ d.classList.remove('dot-active'); d.classList.add('dot-dim'); });
    var cur = rings.querySelector('.planet-dot[data-planet-index="'+idx+'"]');
    if(cur){ cur.classList.remove('dot-dim'); cur.classList.add('dot-active'); }if(nowPlanet&&nowGoal&&nowProg && PL[idx]){
      var target=0; for(var i=0;i<=idx;i++) target+=(+PL[i].goal||0);
      var prevSum=target-(+PL[idx].goal||0);
      nowPlanet.textContent=PL[idx].name||('سیاره '+(idx+1));
      nowGoal.textContent=(+PL[idx].goal||0);
      nowProg.textContent=Math.max(0, st.progress-prevSum);
    }
  }

  function render(){ setupDots(); highlight(st.idx); }

  var addBtn=document.getElementById('btn-add'),
      resetBtn=document.getElementById('btn-reset');

  if(addBtn){ addBtn.addEventListener('click', function(){
    st.progress+=1; st.idx=calcIndex(st.progress); saveState(st); render();
  });}
  if(resetBtn){ resetBtn.addEventListener('click', function(){
    st={progress:0, idx:0}; saveState(st); render();
  });}

  render();
  window.addEventListener('resize', render);
});
</script>

=======
<?php
/* Template Name: Gamification (Planets) */
if ( ! defined('ABSPATH') ) exit;

get_header();

/* ——— تیتر و زیرتیتر که خودم دستی میذارم تو ویرایش برگه ——— */
$pid      = get_the_ID();
$title    = trim( (string) get_post_meta($pid, 'planit_title', true) );
$subtitle = trim( (string) get_post_meta($pid, 'planit_subtitle', true) );
if ($title === '') { $title = get_the_title($pid); } // اگه تیتر نذاشتم، همون عنوان برگه


/* ——— فاصله حلقه‌ها (می‌خوام خودم از کاستومایزر تنظیمش کنم) ——— */
$ringInsets = get_theme_mod('planit_ring_insets', '');
if (is_string($ringInsets) && $ringInsets !== '') {
  $ringInsets = array_map('intval', array_filter(array_map('trim', explode(',', $ringInsets))));
}
if (!is_array($ringInsets) || empty($ringInsets)) {
  // این پیشفرض خودمه که قشنگ‌تر بشه؛ اگه نخواستم، تو سفارشی‌ساز خودم عوضش می‌کنم
  $ringInsets = [60, 45, 25, 10, 0];
}
$perRing = 6; // هر حلقه چندتا نقطه جا بدیم (برای پخش تصادفی)

/* ——— سیاره‌ها از کاستومایزر (اسم/هدف/رنگ) ——— */
/* اینجا فقط همونایی که خودم واقعاً پر کردم میاد؛ بی‌خودی پیشفرض الکی نذاشتم که لو بره */
$planets      = [];
$planet_count = (int) get_theme_mod('planit_planet_count', 0);
if ($planet_count > 12) $planet_count = 12; // زیادیش شلوغ میشه

for ($i=1; $i<=$planet_count; $i++) {
  $name = trim( (string) get_theme_mod("planit_p{$i}_name", '') );
  $goal = (int) get_theme_mod("planit_p{$i}_goal", 0);
  $col  = trim( (string) get_theme_mod("planit_p{$i}_color", '') );

  // اگه اسم یا هدف خالی باشه، کلاً بیخیالش
  if ($name !== '' && $goal > 0) {
    $planets[] = [
      'name'  => $name,
      'goal'  => $goal,
      'color' => ($col !== '' ? $col : '#ffffff'),
    ];
  }
}

/* اگه هنوز چیزی تو کاستومایزر پر نکردم، صفحه خالی میاد ولی خطا نمی‌ده */
if (empty($planets) && current_user_can('edit_theme_options')) {
  echo '<div class="max-w-5xl mx-auto px-6 py-6 text-white/80 text-sm">هنوز هیچ سیاره‌ای تعریف نکردم. برم «نمایش ← سفارشی‌سازی ← گیمیفای – سیاره‌ها» اول تعداد رو زیاد کنم، بعد اسم/هدف/رنگ رو پر کنم.</div>';
}
?>
<!-- هدر صفحه (تیتر/زیرتیتر خودم) -->
<section class="relative py-14 text-white overflow-hidden">
  <!-- ستاره‌ها؛ فقط مطمئن شم این سکشن هم ستاره داره -->
  
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>
  
  <div class="relative max-w-5xl mx-auto px-6">
    <h1 class="text-4xl md:text-5xl font-extrabold mb-2 text-center"><?php echo esc_html($title); ?></h1>
    <?php if($subtitle !== ''): ?>
      <p class="text-white/80 text-center "><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
  </div>
  <div class="custom-content">
  <?php the_content(); ?>
</div>

</section>

<!-- مدار و کنترل‌ها -->
<section class="relative text-white overflow-hidden">
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>

  <div class="relative max-w-5xl mx-auto px-6 py-10">
    <!-- مدار -->
    <div id="orbit-wrap" class="relative mx-auto my-8 w-[320px] h-[320px] md:w-[420px] md:h-[420px]">

      <!-- حلقه‌ها (دوتا خط برای هر حلقه که شیک‌تر دیده شه) -->
      <div id="rings" class="absolute inset-0 spin-slow"
           data-insets='<?php echo wp_json_encode($ringInsets); ?>'
           data-per-ring="<?php echo (int)$perRing; ?>">

        <?php foreach ($ringInsets as $inset): ?>
          <div class="absolute rounded-full border ring-strong ring-glow" style="inset: <?php echo (int)$inset; ?>px;"></div>
          <div class="absolute rounded-full border ring-faint"  style="inset: <?php echo (int)$inset + 3; ?>px;"></div>
        <?php endforeach; ?>

        <?php foreach ($planets as $idx => $pl): ?>
          <div class="planet-dot absolute planet-dot-base dot-dim"
               data-planet-index="<?php echo $idx; ?>"
               data-color="<?php echo esc_attr($pl['color']); ?>">
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- پنل وضعیت الان -->
    <div class="rounded-2xl bg-white/5 border border-white/10 p-6 flex flex-col md:flex-row items-center justify-between gap-4"><div>
        <div class="text-lg">الان روی: <span id="now-planet" class="font-bold"></span></div>
        <div class="text-sm text-white/80 mt-1">
          پیشرفت: <span id="now-progress" class="font-bold"></span> / <span id="now-goal"></span> تسک
        </div>
      </div>
      <div class="flex items-center gap-3">
        <button id="btn-add" class="px-4 py-2 rounded-xl bg-white text-purple-700 font-semibold">+۱ تسک</button>
        <button id="btn-reset" class="px-3 py-2 rounded-xl bg-white/10 border border-white/20 text-white">ریست</button>
      </div>
    </div>

    <!-- کارت‌های خلاصه سیاره‌ها -->
    <?php if(!empty($planets)): ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
      <?php foreach ($planets as $i=>$pl): ?>
        <div class="rounded-2xl bg-white/5 border border-white/10 p-5">
          <div class="text-xl font-extrabold mb-1"><?php echo esc_html($pl['name']); ?></div>
          <div class="text-white/70 text-sm">هدف: <?php echo (int)$pl['goal']; ?> تسک</div>
          <div class="mt-2 text-xs text-white/70">
            رنگ:
            <span style="background:<?php echo esc_attr($pl['color']); ?>; width:14px; height:14px; display:inline-block; border-radius:9999px; vertical-align:middle;"></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- اگه محتوایی تو خود برگه نوشته باشم، پایین صفحه نشون بده (نه جای تیتر) -->
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <?php endwhile; endif; ?>

  </div>
</section>

<script>
/* ——— استیت محلی، هایلایت سیاره فعلی، چینش دات‌ها (همون منطق خودمه) ——— */
var PL  = <?php echo wp_json_encode($planets); ?>;
var KEY = 'planit_progress_v1';

function loadState(){
  try { return JSON.parse(localStorage.getItem(KEY)) || {progress:0, idx:0}; }
  catch(e){ return {progress:0, idx:0}; }
}
function saveState(st){ localStorage.setItem(KEY, JSON.stringify(st)); }
function calcIndex(progress){
  var idx = 0, sum = 0;
  for (var i=0;i<PL.length;i++){
    sum += (+PL[i].goal||0);
    if (progress < sum){ idx = i; break; }
    idx = Math.min(i+1, PL.length-1);
  }
  return idx;
}

document.addEventListener('DOMContentLoaded', function(){
  var st = loadState(); st.idx = calcIndex(st.progress);

  var wrap   = document.getElementById('orbit-wrap');
  var rings  = document.getElementById('rings');
  if (!rings || !wrap) return;

  var dots   = rings.querySelectorAll('.planet-dot');

  var insets = []; try { insets = JSON.parse(rings.getAttribute('data-insets')) || []; } catch(e){}
  var perRing = parseInt(rings.getAttribute('data-per-ring')||'6',10);
  var ringCount = insets.length;

  function setupDots(){
    var rect = wrap.getBoundingClientRect();
    var w=rect.width, h=rect.height, cx=w/2, cy=h/2, outer=Math.min(w,h)/2;
    dots.forEach(function(dot,i){
      var ringIndex = Math.floor(i/perRing);
      if(ringIndex > ringCount-1) ringIndex = ringCount-1;
      var inset = insets[ringIndex] || 0;
      var r = outer - inset - 8;

      // پخش تصادفی ساده بر اساس اندیس (که هر بار جای هر نقطه تقریباً ثابت بمونه)
      var seed=(i+1)*9301%233280, ang=(seed/233280)*Math.PI*2;
      var x=cx+Math.cos(ang)*r, y=cy+Math.sin(ang)*r;

      var col = dot.getAttribute('data-color')||'#fff';
      dot.style.background=col;
      dot.style.left=(x-8)+'px';
      dot.style.top=(y-8)+'px';
      dot.style.zIndex=30;
    });
  }

  function highlight(idx){
    var nowPlanet=document.getElementById('now-planet'),
        nowGoal  =document.getElementById('now-goal'),
        nowProg  =document.getElementById('now-progress');

    dots.forEach(function(d){ d.classList.remove('dot-active'); d.classList.add('dot-dim'); });
    var cur = rings.querySelector('.planet-dot[data-planet-index="'+idx+'"]');
    if(cur){ cur.classList.remove('dot-dim'); cur.classList.add('dot-active'); }if(nowPlanet&&nowGoal&&nowProg && PL[idx]){
      var target=0; for(var i=0;i<=idx;i++) target+=(+PL[i].goal||0);
      var prevSum=target-(+PL[idx].goal||0);
      nowPlanet.textContent=PL[idx].name||('سیاره '+(idx+1));
      nowGoal.textContent=(+PL[idx].goal||0);
      nowProg.textContent=Math.max(0, st.progress-prevSum);
    }
  }

  function render(){ setupDots(); highlight(st.idx); }

  var addBtn=document.getElementById('btn-add'),
      resetBtn=document.getElementById('btn-reset');

  if(addBtn){ addBtn.addEventListener('click', function(){
    st.progress+=1; st.idx=calcIndex(st.progress); saveState(st); render();
  });}
  if(resetBtn){ resetBtn.addEventListener('click', function(){
    st={progress:0, idx:0}; saveState(st); render();
  });}

  render();
  window.addEventListener('resize', render);
});
</script>

>>>>>>> 5a496a83febc32bbd98db395553402a3fa3b07c5
<?php get_footer(); ?>