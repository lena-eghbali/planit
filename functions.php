<?php
if ( ! defined('ABSPATH') ) exit;

/* 
   اینجا تنظیمات پایه قالبه
    */
add_action('after_setup_theme', function () {
  // اینا رو کلاس یادمون داده بود روشن کنیم
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');

  // منوها رو اینجا معرفی می‌کنم که از سفارشی‌سازی قابل انتخاب باشن
  register_nav_menus([
    'primary' => 'Main Menu',
    'footer'  => 'Footer Menu',
  ]);
});

/* 
   اینجا فایل‌های css/js رو میارم
 */
add_action('wp_enqueue_scripts', function () {
  // استایل اصلی که از تیلویند بیلد شده (همون output.css)
  $css = get_template_directory() . '/src/output.css';
  wp_enqueue_style(
    'planit-style',
    get_template_directory_uri() . '/src/output.css',
    [],
    file_exists($css) ? filemtime($css) : null
  );

  $js = get_template_directory() . '/src/main.js';
  if ( file_exists($js) ) {
    wp_enqueue_script(
      'planit-main',
      get_template_directory_uri() . '/src/main.js',
      [],
      filemtime($js),
      true
    );
  }
});

/* 
   سفارشی‌سازی (Customizer)  همون چیزایی که کلاس یاد گرقتیم
   */
add_action('customize_register', function($c){

  /* --- سکشن هیرو صفحه اصلی (عنوان/زیرعنوان) --- */
  $c->add_section('planit_hero', [
    'title'       => 'هیرو صفحه اصلی',
    'description' => 'اینجا تیتر و زیرتیتر هوم‌پیج رو می‌ذارم',
    'priority'    => 10,
  ]);

  // عنوان هیرو
  $c->add_setting('planit_title', ['default' => 'Planit – Your Creative Planner Adventure']);
  $c->add_control('planit_title', [
    'label'   => 'تیتر بزرگ',
    'section' => 'planit_hero',
    'type'    => 'text',
  ]);

  // زیرعنوان هیرو
  $c->add_setting('planit_tagline', ['default' => 'Not just a planner – a journey to your goals']);
  $c->add_control('planit_tagline', [
    'label'   => 'زیرتیتر',
    'section' => 'planit_hero',
    'type'    => 'text',
  ]);

  /*  سه تا دکمه CTA پایین هیرو  */
  $c->add_section('planit_cta', [
    'title'       => 'CTA های هوم‌پیج',
    'description' => 'اینجا متن و لینک سه تا دکمه رو می‌نویسم',
    'priority'    => 11,
  ]);

  // یه آرایه پیشفرض ساده که خالی نمونه
  $cta_def = [
    ['Customize Your Planner', '/features#customize'],
    ['Gamify Your Progress',   '/features#gamify'  ],
    ['Learn Life Skills',      '/features#skills'  ],
  ];

  for($i=1; $i<=3; $i++){
    $c->add_setting("planit_cta{$i}_text", ['default' => $cta_def[$i-1][0]]);
    $c->add_control("planit_cta{$i}_text", [
      'label'   => "متن دکمه {$i}",
      'section' => 'planit_cta',
      'type'    => 'text',
    ]);

    $c->add_setting("planit_cta{$i}_link", ['default' => $cta_def[$i-1][1]]);
    $c->add_control("planit_cta{$i}_link", [
      'label'   => "لینک دکمه {$i}",
      'section' => 'planit_cta',
      'type'    => 'text',
    ]);
  }

  /*  شمارنده‌ها (۳ تا) – عدد + لیبل  */
  $c->add_section('planit_stats', [
    'title'       => 'شمارنده‌ها',
    'description' => 'اینا همون عددای پایین هوم‌پیجن',
    'priority'    => 12,
  ]);

  // پیشفرض‌ها که صفحه خالی نباشه
  $stat_def = [
    ['120000', 'Tasks Logged'],
    ['92%',    'Satisfaction'],
    ['+12000', 'Teen Planners'],
  ];

  for($i=1; $i<=3; $i++){
    $c->add_setting("planit_stat{$i}_value", ['default' => $stat_def[$i-1][0]]);
    $c->add_control("planit_stat{$i}_value", [
      'label'   => "عدد شمارنده {$i}",
      'section' => 'planit_stats',
      'type'    => 'text',
    ]);

    $c->add_setting("planit_stat{$i}_label", ['default' => $stat_def[$i-1][1]]);
    $c->add_control("planit_stat{$i}_label", [
      'label'   => "عنوان شمارنده {$i}",
      'section' => 'planit_stats',
      'type'    => 'text',
    ]);
  }/*  سوشال مدیا برای فوتر  */
  $c->add_section('planit_social', [
    'title'       => 'سوشال مدیا (فوتر)',
    'description' => 'اینجا لینک‌هارو می‌ذارم: اینستا / لینکدین / تلگرام',
    'priority'    => 13,
  ]);

  $c->add_setting('planit_social_instagram', ['default' => '']);
  $c->add_control('planit_social_instagram', [
    'label'   => 'Instagram URL',
    'section' => 'planit_social',
    'type'    => 'url',
  ]);

  $c->add_setting('planit_social_linkedin', ['default' => '']);
  $c->add_control('planit_social_linkedin', [
    'label'   => 'LinkedIn URL',
    'section' => 'planit_social',
    'type'    => 'url',
  ]);

  $c->add_setting('planit_social_telegram', ['default' => '']);
  $c->add_control('planit_social_telegram', [
    'label'   => 'Telegram URL',
    'section' => 'planit_social',
    'type'    => 'url',
  ]);

});

/* 
   زیرتیتر برگه‌هام)
    */
add_action('add_meta_boxes', function(){
  add_meta_box(
    'planit_subtitle_box',
    'زیرتیتر صفحه',
    function($post){
      $val = get_post_meta($post->ID, 'planit_subtitle', true);
      echo '<input type="text" name="planit_subtitle" value="'.esc_attr($val).'" style="width:100%;padding:.5rem" placeholder="یه توضیح کوتاه زیر عنوان...">';
    },
    'page', // فقط برای برگه‌ها
    'normal',
    'high'
  );
});

add_action('save_post_page', function($post_id){
  if( isset($_POST['planit_subtitle']) ){
    update_post_meta($post_id, 'planit_subtitle', sanitize_text_field($_POST['planit_subtitle']));
  }
});

/* 
   هِلپرهای ساده برای قالب
   */

function planit_get_ctas(){
  $out = [];
  for($i=1;$i<=3;$i++){
    $txt = get_theme_mod("planit_cta{$i}_text", '');
    $lnk = get_theme_mod("planit_cta{$i}_link", '#');
    if($txt){
      $out[] = ['text'=>$txt, 'link'=>$lnk];
    }
  }
  return $out;
}

// این تابع شمارنده‌ها رو میده (عدد + لیبل)
function planit_get_stats(){
  $out = [];
  for($i=1;$i<=3;$i++){
    $val = get_theme_mod("planit_stat{$i}_value", '');
    $lab = get_theme_mod("planit_stat{$i}_label", '');
    if($val || $lab){
      $out[] = ['value'=>$val, 'label'=>$lab];
    }
  }
  return $out;
}

// این تابع لینک‌های سوشال فوتر رو میده
function planit_get_socials(){
  return [
    'instagram' => get_theme_mod('planit_social_instagram', ''),
    'linkedin'  => get_theme_mod('planit_social_linkedin',  ''),
    'telegram'  => get_theme_mod('planit_social_telegram',  ''),
  ];
}
/* =========================
   گیمیفای – تنظیمات سیاره‌ها (بدون هیچ پیشفرض)
   از اول هیچی نشون نده؛ فقط وقتی تعداد زیاد شد، فرم‌ها باز شن
   ========================= */
add_action('customize_register', function($c){

  // سکشن گیمیفای
  $c->add_section('planit_gamify', [
    'title'       => 'گیمیفای – سیاره‌ها',
    'description' => 'اول تعداد سیاره‌ها رو بزن، بعد فرم هر کدوم ظاهر میشه',
    'priority'    => 20,
  ]);

  // تعداد سیاره‌ها (از 0 شروع؛ یعنی هیچی)
  $c->add_setting('planit_planet_count', ['default' => 0]);
  $c->add_control('planit_planet_count', [
    'label'       => 'تعداد سیاره‌ها',
    'section'     => 'planit_gamify',
    'type'        => 'number',
    'input_attrs' => ['min'=>0,'max'=>12,'step'=>1],
  ]);

  // یه هلپر کوچیک: فقط وقتی i <= count باشه، کنترل‌ها نمایش داده بشن
  $active_if_needed = function($i){
    return function() use ($i){
      return (int) get_theme_mod('planit_planet_count', 0) >= (int) $i;
    };
  };

  // فواصل حلقه‌ها (خالی می‌ذارم؛ اگه خواستی خودت بنویس)
  $c->add_setting('planit_ring_insets', ['default' => '']);
  $c->add_control('planit_ring_insets', [
    'label'       => 'فاصله حلقه‌ها (px, با کاما) — اختیاری',
    'description' => 'مثلاً: 60,45,25,10,0 (اگه خالی بذاری از پیشفرض فایل صفحه استفاده میشه)',
    'section'     => 'planit_gamify',
    'type'        => 'text',
  ]);

  // فرم‌های سیاره‌ها: از 1 تا 12 ولی «فقط وقتی» count به اون عدد رسید نمایش بده
  for($i=1; $i<=12; $i++){
    // اسم
    $c->add_setting("planit_p{$i}_name", ['default' => '']);
    $c->add_control("planit_p{$i}_name", [
      'label'           => "اسم سیاره {$i}",
      'section'         => 'planit_gamify',
      'type'            => 'text',
      'active_callback' => $active_if_needed($i),
    ]);

    // هدف (چند تسک تا رد شدن از این سیاره)
    $c->add_setting("planit_p{$i}_goal", ['default' => '']);
    $c->add_control("planit_p{$i}_goal", [
      'label'           => "هدف (تعداد تسک) {$i}",
      'section'         => 'planit_gamify',
      'type'            => 'number',
      'input_attrs'     => ['min'=>0,'step'=>1],
      'active_callback' => $active_if_needed($i),
    ]);

    // رنگ
    $c->add_setting("planit_p{$i}_color", ['default' => '']);
    if ( class_exists('WP_Customize_Color_Control') ){
      $ctrl = new WP_Customize_Color_Control($c, "planit_p{$i}_color", [
        'label'           => "رنگ {$i}",
        'section'         => 'planit_gamify',
        'active_callback' => $active_if_needed($i),
      ]);
      $c->add_control($ctrl);
    } else {
      $c->add_control("planit_p{$i}_color", [
        'label'           => "رنگ {$i} (hex)",
        'section'         => 'planit_gamify',
        'type'            => 'text',
        'active_callback' => $active_if_needed($i),
      ]);
    }
  }
});
// عنوان پیش‌فرض برگه‌ها رو قایم می‌کنم که فقط تیتر دستی خودم دیده بشه
add_action('wp_enqueue_scripts', function(){
  // هندل استایل اصلی خودت رو بگذار (اگر planit-style نیست، همونو جایگزین کن)
  $handle = 'planit-style';
  $css = '.entry-title, h1.entry-title, .wp-block-post-title {display:none !important;}';
  wp_add_inline_style($handle, $css);
});
