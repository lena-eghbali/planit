<?php
if ( ! defined('ABSPATH') ) exit;
get_header();

/* 
  اینجا دیتاهای داینامیک رو از سفارشی‌سازی می‌گیرم
  چون میخوام همه‌چی قابل تغییر باشه از پنل وردپرس
*/
$title   = get_theme_mod('planit_title','Planit Your Creative Planner Adventure');
$tagline = get_theme_mod('planit_tagline','Not just a planner a journey to your goals.');
$left    = get_theme_mod('planit_left');
$right   = get_theme_mod('planit_right');
$rocket  = get_theme_mod('planit_rocket');

// CTA ها – سه تا دکمه سفید
$ctas = [];
$cta_def = [
  ['Customize Your Planner','/features#customize'],
  ['Gamify Your Progress','/features#gamify'],
  ['Learn Life Skills','/features#skills'],
];
for($i=1;$i<=3;$i++){
  $ctas[] = [
    'text' => get_theme_mod("planit_cta{$i}_text", $cta_def[$i-1][0]),
    'link' => get_theme_mod("planit_cta{$i}_link", $cta_def[$i-1][1]),
  ];
}

// گالری – اگه عکسی انتخاب کنم اینجا نشون میده
$gallery = [];
for($i=1;$i<=8;$i++){
  $u = get_theme_mod("planit_gallery_$i");
  if($u) $gallery[] = esc_url($u);
}
?>

<!-- ===== HERO (اینجا بخش اصلی صفحه اوله) ===== -->
<section id="hero-wrap" class="relative overflow-hidden text-center text-white py-16 md:py-20">
  <!-- اینجا ستاره‌های بک‌گراند رو گذاشتم (کلاسم رو تو input.css تعریف کردم) -->
  <div class="absolute inset-0 bg-setare z-0"></div>

  <!-- تیتر و تگ‌لاین -->
  <div class="relative z-20 px-6">
    <h1 class="text-4xl md:text-6xl font-extrabold"><?php echo esc_html($title); ?></h1>
    <p class="mt-4 text-lg md:text-2xl opacity-95"><?php echo esc_html($tagline); ?></p>
  </div>

  <!-- آدمک‌ها + موشک (ابر رو حذف کردم چون قشنگ نمی‌شد) -->
  <div class="relative mt-10 h-[360px] md:h-[440px]">
    <?php if ($rocket): ?>
      <!-- موشک رو اول نامرئی میذارم که وقتی سکشن اومد تو دید، با JS کلاس بگیره و حرکت کنه -->
      <img id="rocket" src="<?php echo esc_url($rocket); ?>" alt="rocket"
           class="absolute bottom-6 right-6 h-20 md:h-24 z-20 opacity-0">
    <?php endif; ?>

    <?php if ($left): ?>
      <!-- آدمک چپ – یه ذره از وسط فاصله دادم که تو هم نشن -->
      <img id="char-left" src="<?php echo esc_url($left); ?>" alt="char-left"
           class="absolute top-2 md:top-0 left-1/2 -translate-x-[68%] h-64 md:h-80 floaty z-30 pointer-events-none select-none">
    <?php endif; ?>

    <?php if ($right): ?>
      <!-- آدمک راست – همین منطق -->
      <img id="char-right" src="<?php echo esc_url($right); ?>" alt="char-right"
           class="absolute top-8 md:top-2 left-1/2 -translate-x-[32%] h-64 md:h-80 floaty z-30 pointer-events-none select-none">
    <?php endif; ?>
  </div>
</section>

<!-- ===== CTA ها (اینا رو داینامیک کردم و اندازه‌شون مثل کارت‌های شمارنده است) ===== -->
<section class="py-8">
  <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-6">
    <?php foreach($ctas as $c): if(!$c['text']) continue; ?>
      <a href="<?php echo esc_url($c['link']); ?>"
         class="block rounded-2xl bg-white/5 border border-white/10 p-6 text-center text-white
                hover:scale-[1.02] transition h-full flex flex-col items-center justify-center">
        <div class="text-2xl font-extrabold mb-1"><?php echo esc_html($c['text']); ?></div>
        <div class="text-white/60 text-sm">→ Tap to explore</div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ===== گالری (اگه عکس انتخاب شده باشه) ===== -->
<?php if(!empty($gallery)): ?>
<section class="max-w-6xl mx-auto px-6 py-12">
  <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">Planner Gallery</h2>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach($gallery as $i=>$src): ?>
      <figure class="rounded-lg overflow-hidden bg-white/10 border border-white/10">
        <img src="<?php echo $src; ?>" alt="gallery <?php echo $i+1; ?>" class="w-full h-40 md:h-48 object-cover">
      </figure>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?><!-- ===== شمارنده‌ها (اینا رو با JS مینیمال از 0 تا عدد هدف می‌برم) ===== -->
<section class="py-16 text-white text-center js-stats-section">
  <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-6">
    <?php for($i=1;$i<=3;$i++):
      // این پیش‌فرض‌ها رو گذاشتم که صفحه خالی نشه
      $dv = ($i==1?'12000+':($i==2?'92%':'1200000'));
      $dl = ($i==1?'Teen Planners':($i==2?'Satisfaction':'Tasks Logged'));
      $v  = get_theme_mod("planit_stat{$i}_value",$dv);
      $l  = get_theme_mod("planit_stat{$i}_label",$dl);
    ?>
      <div class="rounded-2xl bg-white/5 border border-white/10 p-6">
        <!-- این span با data-target کار می‌کنه و js مقدار رو انیمیت می‌کنه -->
        <div class="js-counter text-4xl font-extrabold" data-target="<?php echo esc_attr($v); ?>">0</div>
        <div class="mt-2 text-white/80"><?php echo esc_html($l); ?></div>
      </div>
    <?php endfor; ?>
  </div>
</section>

<?php get_footer(); ?>