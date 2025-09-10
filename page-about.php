<?php
/* Template Name: About Planit */
if ( ! defined('ABSPATH') ) exit;
get_header();

$subtitle = get_post_meta(get_the_ID(), 'planit_subtitle', true);
?>

<section class="relative py-14 text-white overflow-hidden">
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>

  <div class="max-w-5xl mx-auto px-6">
    <h1 class="text-4xl md:text-5xl font-extrabold mb-3 text-center"><?php the_title(); ?></h1>
    <?php if($subtitle): ?>
      <p class="text-center text-white/80 max-w-2xl mx-auto"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="relative text-white overflow-hidden">
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>

  <div class="max-w-5xl mx-auto px-6 pb-16">
    <!-- متن معرفی کوتاه -->
    <div class="rounded-2xl bg-white/10 border border-white/10 p-6 mb-8">
      <p class="text-white/85 leading-8">
        پلنیت فقط یه پلنر نیست؛ یه دوست ردیف برای هدف‌چیدن و پیشرفت کردنه. اینجا همه‌چی رو طوری ساختیم که
        هم خوشگل باشه، هم ساده، هم به درد بخوره. از استیکر و تم گرفته تا گیمیفای و تست‌های مهارتی.
      </p>
    </div>

    <!-- سه تا فیچر جمع‌وجور -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div class="rounded-2xl bg-white/10 border border-white/10 p-6">
        <div class="text-3xl mb-3">✨</div>
        <h3 class="text-xl font-extrabold mb-1">خلاقیت</h3>
        <p class="text-white/75 text-sm leading-7">پس‌زمینه، استیکر، نقل‌قول—هر چی دوست داری بچین.</p>
      </div>

      <div class="rounded-2xl bg-white/10 border border-white/10 p-6">
        <div class="text-3xl mb-3">🧭</div>
        <h3 class="text-xl font-extrabold mb-1">سازماندهی</h3>
        <p class="text-white/75 text-sm leading-7">تسک‌ها، ریمایندر، پیگیری پیشرفت—جمع و جور و تمیز.</p>
      </div>

      <div class="rounded-2xl bg-white/10 border border-white/10 p-6">
        <div class="text-3xl mb-3">🚀</div>
        <h3 class="text-xl font-extrabold mb-1">رشد</h3>
        <p class="text-white/75 text-sm leading-7">گیمیفای، نشان‌ها، و چالش‌های فان تا از مسیر انگیزه بگیری.</p>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>