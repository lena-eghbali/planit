<?php
/* Template Name: Workshops */
if ( ! defined('ABSPATH') ) exit;
get_header();

// — تیتر و زیرتیتر (اگه خواستی زیرتیتر دستی بدی)
$subtitle = get_post_meta(get_the_ID(), 'planit_subtitle', true);
?>

<section class="relative py-14 text-white overflow-hidden">
  <!-- ستاره‌ها فقط توی این سکشن -->
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>

  <div class="max-w-6xl mx-auto px-6">
    <!-- تیتر اصلی صفحه -->
    <h1 class="text-4xl md:text-5xl font-extrabold mb-3 text-center"><?php the_title(); ?></h1>
    <?php if($subtitle): ?>
      <p class="text-center text-white/80 max-w-2xl mx-auto"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
  </div>
</section>

<?php
// — اینجا می‌گم بچه‌های همین برگه رو بیار (یعنی ورکشاپ‌ها)
$q = new WP_Query([
  'post_type'   => 'page',
  'post_parent' => get_the_ID(),
  'orderby'     => 'menu_order',
  'order'       => 'ASC',
  'posts_per_page' => -1,
]);
?>

<section class="relative text-white overflow-hidden">
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>

  <div class="max-w-6xl mx-auto px-6 pb-16">
    <?php if ( $q->have_posts() ): ?>
      <!-- کارت‌ها تو گرید مرتب -->
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php while ( $q->have_posts() ): $q->the_post(); ?>
          <article class="rounded-2xl bg-white/10 border border-white/10 p-6 shadow-soft hover:bg-white/15 transition">
            <h2 class="text-2xl font-extrabold mb-2"><?php the_title(); ?></h2>
            <p class="text-white/80 text-sm mb-4"><?php echo get_the_excerpt(); ?></p>
            <div class="flex items-center justify-between text-sm">
              <span class="text-white/70">
                <?php echo get_post_meta(get_the_ID(), 'work_time', true) ? esc_html(get_post_meta(get_the_ID(), 'work_time', true)) : '۲ ساعت آنلاین'; ?>
              </span>
              <a href="<?php the_permalink(); ?>" class="px-3 py-2 rounded-xl bg-white text-purple-700 font-semibold">بیشتر</a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else: ?>
      <!-- اگه هنوز ورکشاپ نساختم -->
      <div class="rounded-2xl bg-white/10 border border-white/10 p-8 text-center">
        <p class="text-white/80">فعلاً هیچ ورکشاپی اضافه نکردم. برگه‌های فرزندِ «Workshops» رو بسازم، اینجا خودش میاد.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>