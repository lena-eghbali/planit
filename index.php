<?php
get_header();
?>
<main>
  <section class="bg-planit-grad text-white">
    <div class="max-w-6xl mx-auto px-6 py-12">

      <?php
        // ====== اینجا تیتر و زیرتیتر هدرِ صفحه‌ی بلاگ رو از محتوای همون "Posts page" در میارم ======
        $blog_page_id = (int) get_option('page_for_posts');
        $hero_title   = 'بلاگ پلنیت';
        $hero_sub     = '';

        if ( $blog_page_id ) {
          // محتوای برگه‌ی بلاگ (با فیلتر که گوتنبرگ/شورتکد اعمال بشه)
          $raw = apply_filters('the_content', get_post_field('post_content', $blog_page_id));

          // 1) اول تلاش می‌کنم custom-title و custom-subtitle رو از داخل محتوا پیدا کنم
          if (preg_match('/<p[^>]*class=("|\')(?:[^"\']*\s)?custom-title(?:\s[^"\']*)?\1[^>]*>(.*?)<\/p>/is', $raw, $m)) {
            $hero_title = wp_strip_all_tags($m[2]);
          } else {
            // 2) اگر custom-title نبود، اولین H1/H2 رو چک می‌کنم
            if (preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $raw, $m1)) {
              $hero_title = wp_strip_all_tags($m1[1]);
            } elseif (preg_match('/<h2[^>]*>(.*?)<\/h2>/is', $raw, $m2)) {
              $hero_title = wp_strip_all_tags($m2[1]);
            } else {
              // 3) در نهایت fallback: عنوان خود برگه‌ی بلاگ
              $hero_title = get_the_title($blog_page_id);
            }
          }

          // زیرتیتر
          if (preg_match('/<p[^>]*class=("|\')(?:[^"\']*\s)?custom-subtitle(?:\s[^"\']*)?\1[^>]*>(.*?)<\/p>/is', $raw, $ms)) {
            $hero_sub = wp_strip_all_tags($ms[2]);
          }
        }
      ?>

      <!-- هدر بلاگ: فقط چیزی که خودت تو ادیتور گذاشتی -->
      <h1 class="text-4xl md:text-5xl font-bold mb-2 text-center"><?php echo esc_html($hero_title); ?></h1>
      <?php if (!empty($hero_sub)): ?>
        <p class="text-center text-white/80 mb-8"><?php echo esc_html($hero_sub); ?></p>
      <?php else: ?>
        <div class="mb-8"></div>
      <?php endif; ?>

      <?php if (have_posts()): ?>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <?php while (have_posts()): the_post(); ?>

            <?php
              // عنوان کارت‌ها: همون عنوان پست
              $card_title = get_the_title();
              // خلاصه: اول از excerpt، اگه نبود از محتوا کوتاه‌شده
              $summary = get_the_excerpt();
              if (!$summary) {
                $summary = wp_trim_words( wp_strip_all_tags( get_the_content() ), 26, '…' );
              }
            ?>

            <article class="bg-white/10 p-6 rounded-2xl shadow-soft hover:bg-white/15 transition">
              <a href="<?php the_permalink(); ?>" class="block">
                <h2 class="text-2xl font-bold mb-2 text-white hover:text-purple-300 transition">
                  <?php echo esc_html($card_title); ?>
                </h2>
              </a>

              <div class="text-white/70 text-sm mb-4">
                <time datetime="<?php echo esc_attr(get_the_time('c')); ?>">
                  <?php echo esc_html(get_the_time(get_option('date_format'))); ?>
                </time>
              </div>

              <?php if ($summary): ?>
                <div class="text-white/80">
                  <?php echo esc_html($summary); ?>
                </div>
              <?php endif; ?>

              <a class="inline-block mt-4 text-purple-300 hover:text-purple-200 transition"
                 href="<?php the_permalink(); ?>">ادامه مطلب</a>
            </article>

          <?php endwhile; ?>
        </div>

        <!-- صفحه‌بندی -->
        <div class="mt-8 flex items-center justify-between">
          <div class="text-white/70"><?php previous_posts_link('→ نوشته‌های جدیدتر'); ?></div>
          <div class="text-white/70"><?php next_posts_link('نوشته‌های قدیمی‌تر ←'); ?></div>
        </div>

      <?php else: ?>
        <div class="bg-white/10 p-8 rounded-2xl shadow-soft text-center text-white/80">
          <h2 class="text-2xl font-bold mb-2">مطلبی پیدا نشد</h2>
          <p>متاسفانه هنوز مطلبی برای نمایش در این بخش وجود ندارد.</p>
        </div>
      <?php endif; ?></div>
  </section>
</main>
<?php
get_footer();
?>