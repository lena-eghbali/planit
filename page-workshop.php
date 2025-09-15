<?php
/* Template Name: Workshops (Planit) */
if ( ! defined('ABSPATH') ) exit;
get_header();
?>
<main class="text-white" dir="rtl">

  <section class="relative py-12">
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>
    <div class="max-w-5xl mx-auto px-6">
      <header class="text-center mb-10">
        <h1 class="text-3xl md:text-5xl font-extrabold mb-2"><?php the_title(); ?></h1>
        <?php if (has_excerpt()): ?>
          <p class="text-white/80 leading-8 max-w-2xl mx-auto"><?php echo get_the_excerpt(); ?></p>
        <?php endif; ?>
      </header>

      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        <!-- کارت 1 -->
        <article class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-soft hover:bg-white/15 transition">
          <h3 class="text-xl font-bold mb-2">برنامه‌ریزی شخصی 101</h3>
          <p class="text-white/75 text-sm leading-7 mb-4">روتین‌سازی و چیدن پلن روزانه به ساده‌ترین شکل.</p>
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
            <span class="text-white/70">۹۰ دقیقه</span>
            <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="px-3 py-2 rounded-xl bg-white text-purple-700 font-semibold text-center sm:w-auto w-full">ثبت‌نام</a>
          </div>
        </article>

        <!-- کارت 2 -->
        <article class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-soft hover:bg-white/15 transition">
          <h3 class="text-xl font-bold mb-2">مدیریت زمان (دانش‌آموز/دانشجو)</h3>
          <p class="text-white/75 text-sm leading-7 mb-4">بلوک‌بندی، ددلاین واقعی و تکنیک ۲۵ دقیقه‌ای.</p>
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
            <span class="text-white/70">۲ ساعت</span>
            <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="px-3 py-2 rounded-xl bg-white text-purple-700 font-semibold text-center sm:w-auto w-full">ثبت‌نام</a>
          </div>
        </article>

        <!-- کارت 3 -->
        <article class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-soft hover:bg-white/15 transition">
          <h3 class="text-xl font-bold mb-2">گیمیفیکیشن برای عادت‌ها</h3>
          <p class="text-white/75 text-sm leading-7 mb-4">بج، استریک و امتیاز برای حفظ انگیزه.</p>
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
            <span class="text-white/70">۲ ساعت</span>
            <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="px-3 py-2 rounded-xl bg-white text-purple-700 font-semibold text-center sm:w-auto w-full">ثبت‌نام</a>
          </div>
        </article>

        <!-- کارت 4 -->
        <article class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-soft hover:bg-white/15 transition">
          <h3 class="text-xl font-bold mb-2">طراحی پلنر (UI دستی)</h3>
          <p class="text-white/75 text-sm leading-7 mb-4">جلد، رنگ، شبکه‌بندی صفحات — ساده و قشنگ.</p>
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
            <span class="text-white/70">۹۰ دقیقه</span>
            <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="px-3 py-2 rounded-xl bg-white text-purple-700 font-semibold text-center sm:w-auto w-full">ثبت‌نام</a>
          </div>
        </article>

        <!-- کارت 5 -->
        <article class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-soft hover:bg-white/15 transition">
          <h3 class="text-xl font-bold mb-2">بهره‌وری دیجیتال</h3>
          <p class="text-white/75 text-sm leading-7 mb-4">هماهنگ‌کردن ابزارهای آنلاین با پلنر کاغذی.</p><div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
            <span class="text-white/70">۹۰ دقیقه</span>
            <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="px-3 py-2 rounded-xl bg-white text-purple-700 font-semibold text-center sm:w-auto w-full">ثبت‌نام</a>
          </div>
        </article>

        <!-- کارت 6 -->
        <article class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-soft hover:bg-white/15 transition">
          <h3 class="text-xl font-bold mb-2">هدف‌گذاری گروهی</h3>
          <p class="text-white/75 text-sm leading-7 mb-4">تقسیم کار و پیگیری شفاف برای تیم‌های کوچک.</p>
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm">
            <span class="text-white/70">۲ ساعت</span>
            <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="px-3 py-2 rounded-xl bg-white text-purple-700 font-semibold text-center sm:w-auto w-full">رزرو تیمی</a>
          </div>
        </article>

      </div>
      <!-- /grid -->

      <!-- نکته: اگر خواستی CTA کلی هم پایین بگذاری -->
      <!--
      <div class="text-center mt-10">
        <a href="<?php echo esc_url( home_url('/contact') ); ?>"
           class="inline-block px-5 py-3 rounded-2xl bg-white text-purple-700 font-bold">
          هماهنگی ورکشاپ اختصاصی
        </a>
      </div>
      -->
    </div>
  </section>
</main>
<?php get_footer(); ?>