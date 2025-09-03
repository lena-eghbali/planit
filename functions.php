<?php
// خب اینجا یه چک کوچولو که اگه کسی مستقیم اومد فایل رو باز کنه، جلوشو بگیریم
if ( ! defined('ABSPATH') ) exit;

/* 
  اینجا اومدم تنظیمات پایه قالب رو فعال کردم
  راستش اولش دقیق یادم نبود چیارو باید روشن کنم ولی با سرچ فهمیدم
  title-tag و thumbnail و logo و اینا رو زدم که بعداً تو بخش‌ها بدردم بخوره
*/
add_action('after_setup_theme', function(){
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');
  add_theme_support('html5', ['search-form','gallery','caption']);

  // اینجوری لوکیشن منوها درست میشه، که تو هدر و فوتر بتونم از فهرست وردپرس استفاده کنم
  register_nav_menus([
    'primary' => 'Main Menu',
    'footer'  => 'Footer Menu',
    'social'  => 'Social Links'
  ]);
});

/*
  این قسمت برای لود کردن خروجی تیلویند و فایل js خودمه
  اولش مسیرها قاطی بود و نمیومد، بعد فهمیدم باید file_exists و filemtime بذارم که کش مرورگر اذیت نکنه
*/
add_action('wp_enqueue_scripts', function(){
  $dir = get_template_directory();
  $uri = get_template_directory_uri();

  if ( file_exists($dir.'/src/output.css') ){
    wp_enqueue_style('planit-style', $uri.'/src/output.css', [], filemtime($dir.'/src/output.css'));
  }
  if ( file_exists($dir.'/src/main.js') ){
    wp_enqueue_script('planit-main', $uri.'/src/main.js', [], filemtime($dir.'/src/main.js'), true);
  }
});

/*
  اینجا رفتم سراغ سفارشی‌سازی وردپرس
  چون میخوام همه‌چی داینامیک باشه، مثلا عنوان هوم، تگ‌لاین، عکس‌های هیرو، CTAها، گالری، شمارنده‌ها
  اول بلد نبودم چجوری کنترل عکس بذارم، ولی با WP_Customize_Image_Control مشکل حل شد
*/
add_action('customize_register', function($c){

  // عنوان و تگ‌لاین برای صفحه اصلی (هوم)
  $c->add_section('planit_header',['title'=>'Header (Title/Tagline)']);
  $c->add_setting('planit_title',['default'=>'Planit – Your Creative Planner Adventure','sanitize_callback'=>'wp_kses_post']);
  $c->add_control('planit_title',['label'=>'عنوان صفحه اصلی','section'=>'planit_header','type'=>'text']);
  $c->add_setting('planit_tagline',['default'=>'Not just a planner – a journey to your goals.','sanitize_callback'=>'wp_kses_post']);
  $c->add_control('planit_tagline',['label'=>'تگ‌لاین زیر عنوان','section'=>'planit_header','type'=>'text']);

  // عکس‌های هیرو (آدمک چپ/راست + موشک) - ابر رو فعلاً نذاشتم چون خوشگل درنیومد
  $c->add_section('planit_hero',['title'=>'Hero Images']);
  foreach (['left'=>'عکس آدمک چپ','right'=>'عکس آدمک راست','rocket'=>'موشک'] as $k=>$lab){
    $c->add_setting("planit_$k");
    $c->add_control(new WP_Customize_Image_Control($c,"planit_$k",['label'=>$lab,'section'=>'planit_hero']));
  }

  // دکمه‌های CTA پایین هیرو – داینامیکش کردم که بعداً متن و لینک رو خودم عوض کنم
  $c->add_section('planit_cta',['title'=>'CTA Buttons (3 ta)']);
  $def_cta = [
    ['Customize Your Planner','/features#customize'],
    ['Gamify Your Progress','/features#gamify'],
    ['Learn Life Skills','/features#skills'],
  ];
  for($i=1;$i<=3;$i++){
    $c->add_setting("planit_cta{$i}_text",['default'=>$def_cta[$i-1][0],'sanitize_callback'=>'sanitize_text_field']);
    $c->add_control("planit_cta{$i}_text",['label'=>"متن دکمه $i",'section'=>'planit_cta','type'=>'text']);
    $c->add_setting("planit_cta{$i}_link",['default'=>$def_cta[$i-1][1],'sanitize_callback'=>'esc_url_raw']);
    $c->add_control("planit_cta{$i}_link",['label'=>"لینک دکمه $i",'section'=>'planit_cta','type'=>'url']);
  }

  // گالری پلنرها – تا 8 تا عکس گذاشتم که دستی انتخاب کنم
  $c->add_section('planit_gallery',['title'=>'Planner Gallery (aks ha)']);
  for($i=1;$i<=8;$i++){
    $c->add_setting("planit_gallery_$i");
    $c->add_control(new WP_Customize_Image_Control($c,"planit_gallery_$i",['label'=>"عکس $i",'section'=>'planit_gallery']));
  }

  // شمارنده‌ها – اینا رو هم داینامیک گذاشتم چون میخوام از سفارشی‌سازی عدد و لیبل رو تغییر بدم
  $c->add_section('planit_stats',['title'=>'Stats (Counters)']);for($i=1;$i<=3;$i++){
    $defV = ($i==1?'12000+':($i==2?'92%':'1200000'));
    $defL = ($i==1?'Teen Planners':($i==2?'Satisfaction':'Tasks Logged'));
    $c->add_setting("planit_stat{$i}_value",['default'=>$defV,'sanitize_callback'=>'sanitize_text_field']);
    $c->add_control("planit_stat{$i}_value",['label'=>"عدد $i (مثل 12000+ یا 92%)",'section'=>'planit_stats','type'=>'text']);
    $c->add_setting("planit_stat{$i}_label",['default'=>$defL,'sanitize_callback'=>'sanitize_text_field']);
    $c->add_control("planit_stat{$i}_label",['label'=>"متن $i",'section'=>'planit_stats','type'=>'text']);
  }

  // سوشال‌های فوتر – اگه بخوام بعداً لینک اینستا/تلگرام/لینکدین رو بذارم
  $c->add_section('planit_footer',['title'=>'Footer Social']);
  foreach (['insta'=>'Instagram','telegram'=>'Telegram','linkedin'=>'LinkedIn'] as $k=>$lab){
    $c->add_setting("planit_$k",['sanitize_callback'=>'esc_url_raw']);
    $c->add_control("planit_$k",['label'=>$lab.' URL','section'=>'planit_footer','type'=>'url']);
  }

});