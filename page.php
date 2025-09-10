<?php
// صفحه‌ی ساده‌ی برگه‌ها – بی‌دردسر
if ( ! defined('ABSPATH') ) exit;
get_header();
?>

<main>
  <section class="relative py-12 text-white overflow-hidden">
    <!-- این لایه ستاره‌هاست که با بقیه استایل‌های خودت ست می‌شه -->
    <div class="absolute inset-0 -z-10 bg-stars-only"></div>

    <div class="max-w-5xl mx-auto px-6">
      <?php while ( have_posts() ) : the_post(); ?>

        <?php
        // ===== تیتر دستیِ خودم =====
        // نکته: توی ادیتور، از "زمینه‌های دلخواه" دو فیلد بساز:
        // planit_custom_title   → تیتر دلخواه
        // planit_custom_sub     → زیرتیتر دلخواه (اختیاری)
        $manual_title = trim( (string) get_post_meta( get_the_ID(), 'planit_custom_title', true ) );
        $manual_sub   = trim( (string) get_post_meta( get_the_ID(), 'planit_custom_sub', true ) );

        // اگه تیتر دستی داشته باشم، همونو می‌زنم؛ وگرنه عنوان خود برگه
        $page_title = $manual_title !== '' ? $manual_title : get_the_title();
        ?>

        <header class="mb-6">
          <h1 class="text-4xl md:text-5xl font-extrabold text-center">
            <?php echo esc_html( $page_title ); ?>
          </h1>

          <?php if ( $manual_sub !== '' ) : ?>
            <p class="mt-2 text-white/80 text-center"><?php echo esc_html( $manual_sub ); ?></p>
          <?php endif; ?>
        </header>

        <article class="prose prose-invert max-w-none">
          <?php
          // محتوای خود برگه (هرچی داخل ادیتور نوشتی)
          the_content();
          ?>
        </article>

      <?php endwhile; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>