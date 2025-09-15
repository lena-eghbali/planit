<?php
/** footer.php – سه‌ستونه تمیز، سوشال از کاستومایزر، لینک‌ها و تماس کامل */
if ( ! defined('ABSPATH') ) exit;
?>

    </main>

    <footer class="mt-16 text-white">
      <div class="bg-white/5 backdrop-blur-sm">
        <!-- === ردیف اصلی فوتر: سه ستون === -->
        <div class="max-w-7xl mx-auto px-6 py-12 grid gap-10 md:grid-cols-3 items-start">

          <!-- ستون 1: درباره پلنیت + سوشال -->
          <div>
            <?php if (function_exists('the_custom_logo') && has_custom_logo()): ?>
              <div class="mb-3 w-12 h-12 overflow-hidden rounded-lg"><?php the_custom_logo(); ?></div>
            <?php else: ?>
              <div class="text-purple-200 font-extrabold text-xl mb-2"><?php bloginfo('name'); ?></div>
            <?php endif; ?>

            <p class="text-white/80 text-sm leading-7">
              پلنیت، همراه برنامه‌ریزی و رشد مهارت‌ها؛ ساده، منظم و با چاشنی انگیزه 🚀
            </p>

            <?php
            // سوشال از کاستومایزر 
            if (!function_exists('planit_social_svg')) {
              function planit_social_svg($name){
                $name = strtolower($name);
                if (str_contains($name,'insta')) return '<svg viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor"><path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm0 2a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H7zm11.5 2.5a1 1 0 110 2 1 1 0 010-2zM12 8a4 4 0 110 8 4 4 0 010-8z"/></svg>';
                if (str_contains($name,'link'))  return '<svg viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor"><path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zM4 13h7v7H4v-7zm9 0h7v7h-7v-7z"/></svg>';
                if (str_contains($name,'tele'))  return '<svg viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor"><path d="M9.4 15.8l-.3 4.2c.4 0 .6-.2 .8-.4l1.9-1.8 4 2.9c.7 .4 1.2 .2 1.4 -.7l2.5 -11c.2 -.9 -.3 -1.3 -1 -.9L3.7 11c-.9 .4 -.9 .9 -.2 1.1l4.6 1.4 10.7 -6.8 -9.4 9.1z"/></svg>';
                if (str_contains($name,'yout'))  return '<svg viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor"><path d="M22.54 11.23a.93.93 0 00-.66-.66L18.42 9.1c-.8-.21-1.3-.23-1.74-.23h-2.12a.94.94 0 00-.94.94V11a.88.88 0 00.12.56L14.7 13c-.15.4-.55.7-1 .7h-2.4a.92.92 0 00-.93.93V16a.93.93 0 00.93.93h2.32a.92.92 0 00.93-.93v-.53a.85.85 0 00.27-.47l.95-2.26a.93.93 0 00-.3-.92V9.1c.14-.3.14-.6-.2-.9.27.09.43.34.43.68V11a.9.9 0 00.9.9h2.12c.45 0 .95.02 1.74-.23L22.54 11.23a.93.93 0 00.66-.66z"/></svg>';
                return '<svg viewBox="0 0 24 24" class="w-4 h-4" fill="currentColor"><circle cx="12" cy="12" r="9"/></svg>';
              }
            }
            $soc = [
              'Instagram' => get_theme_mod('planit_social_instagram'),
              'LinkedIn'  => get_theme_mod('planit_social_linkedin'),
              'Telegram'  => get_theme_mod('planit_social_telegram'),
              'YouTube'   => get_theme_mod('planit_social_youtube'),
            ];
            $has_any = array_filter($soc);
            if ($has_any): ?>
              <ul class="mt-4 flex items-center gap-2">
                <?php foreach ($soc as $label => $url): if ($url): ?>
                  <li>
                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/15 hover:bg-white/30 text-white transition"
                       aria-label="<?php echo esc_attr($label); ?>">
                      <?php echo planit_social_svg($label); ?>
                      <span class="sr-only"><?php echo esc_html($label); ?></span>
                    </a>
                  </li>
                <?php endif; endforeach; ?>
              </ul>
            <?php endif; ?>
          </div><!-- ستون 2: بخش‌های سایت (لینک‌ها) -->
          <div>
            <h3 class="text-sm font-semibold text-white/90 mb-3">بخش‌های سایت</h3>
            <ul class="grid grid-cols-2 gap-2 text-sm text-white/85">
              <?php
              $pages = [
                ['خانه',            '/'],
                ['گیمیفای',         'gamify'],
                ['پلنر بساز',       'customizer'],
                ['دوره‌ها',         'workshops'],
                ['درباره پلنیت',    'about-planit'],
                ['ارتباط با پلنیت', 'contact'],
              ];
              foreach ($pages as $p) {
                [$title,$slug] = $p;
                $url = ($slug==='/') ? home_url('/') : ( get_permalink( get_page_by_path($slug) ) ?: home_url('/'.$slug.'/') );
                echo '<li><a class="hover:text-purple-300 transition" href="'.esc_url($url).'">'.esc_html($title).'</a></li>';
              }
              ?>
            </ul>
          </div>

          <!-- ستون 3: ارتباط با پلنیت (ایمیل، شماره، آدرس + دکمه فرم) -->
          <div>
            <h3 class="text-sm font-semibold text-white/90 mb-3">ارتباط با پلنیت</h3>
            <ul class="space-y-2 text-white/85 text-sm">
              <?php if ($mail = get_theme_mod('planit_contact_email')): ?>
                <li>ایمیل: <a class="hover:text-purple-500 transition" href="mailto:<?php echo esc_attr($mail); ?>"><?php echo esc_html($mail); ?></a></li>
              <?php endif; ?>
              <?php if ($tel = get_theme_mod('planit_contact_tel')): ?>
                <li>شماره پشتیبانی: <a class="hover:text-purple-300 transition" href="tel:<?php echo esc_attr($tel); ?>"><?php echo esc_html($tel); ?></a></li>
              <?php endif; ?>
              <?php if ($addr = get_theme_mod('planit_contact_address')): ?>
                <li>آدرس: <span><?php echo esc_html($addr); ?></span></li>
              <?php endif; ?>
            </ul>
            <a class="inline-flex items-center gap-2 mt-3 px-3 py-2 rounded-xl bg-white/10 hover:bg-white/15 border border-white/15 transition"
               href="<?php echo esc_url( home_url('/contact/') ); ?>">
              فرم تماس
            </a>
          </div>

        </div>

        <!-- خط باریک و کپی‌رایت -->
        <div class="h-[1px] w-32 mx-auto rounded-full" style="background:linear-gradient(90deg,rgba(255,255,255,.05),rgba(255,255,255,.5),rgba(255,255,255,.05));"></div>

        <div class="max-w-7xl mx-auto px-6 py-5 text-xs text-white/70 flex items-center justify-between">
          <span>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?></span>
          <span><?php bloginfo('description'); ?></span>
        </div>
      </div>
    </footer>

    <?php wp_footer(); ?>
  </body>
</html>