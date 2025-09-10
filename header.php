<?php if ( ! defined('ABSPATH') ) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gradient-to-b from-[#3a0ca3] via-[#2b0a77] to-[#190742] min-h-screen'); ?>>
<?php wp_body_open(); ?>

<header class="bg-white/15 backdrop-blur-sm text-white  top-0 z-50 border-b border-black/10 ">
  <div class="max-w-7xl mx-auto flex items-center justify-between py-3 px-4 ">
    <div class="flex items-center gap-3">
      <?php if (has_custom_logo()) the_custom_logo(); ?>
      <a class="text-xl font-bold text-wite" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    </div>
    <nav class="hidden md:block">
      <?php wp_nav_menu(['theme_location'=>'primary','container'=>false,'menu_class'=>'flex items-center gap-10  align-middle ml-55','fallback_cb'=>false]); ?>
    </nav>
    <button id="planit-burger" class="md:hidden p-2 border rounded-lg" aria-label="menu">☰</button>
  </div>
  <div id="planit-mobile" class="md:hidden hidden border-t">
    <?php wp_nav_menu(['theme_location'=>'primary','container'=>false,'menu_class'=>'flex flex-col gap-3 p-4','fallback_cb'=>false]); ?>
  </div>
</header>

<script>
  (function(){
    var b=document.getElementById('planit-burger'), m=document.getElementById('planit-mobile');
    if(b&&m) b.addEventListener('click',()=>m.classList.toggle('hidden'));
  })();
</script>