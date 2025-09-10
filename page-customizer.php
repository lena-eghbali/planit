<?php
/* Template Name: Planner Customizer */
if ( ! defined('ABSPATH') ) exit;

get_header();

// زیرتیتر از متاباکس (داینامیک)
$subtitle = get_post_meta(get_the_ID(), 'planit_subtitle', true);
?>

<!-- سکشن عنوان -->
<section class="relative py-14 text-white">
  <div class="relative max-w-5xl mx-auto px-6">
  <div class="absolute inset-0 -z-10 bg-stars-only"></div>

<div class="relative max-w-5xl mx-auto px-6">
  <h1 class="text-4xl md:text-5xl font-extrabold mb-2 text-center">
    <?php the_title(); ?>
  </h1>
</div>
    <?php if(!empty($subtitle)): ?>
      <p class="text-white/80"><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- بخش کاستومایزر -->
<section class="relative text-white">
  <div class="relative max-w-6xl mx-auto px-6 pb-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

      <!-- فرم تنظیمات -->
      <div class="rounded-2xl bg-white/5 border border-white/10 p-5">
        <h2 class="text-xl font-bold mb-4">تنظیمات پلنر</h2>

        <label class="block mb-2">سایز پلنر:</label>
        <select id="js-size" class="w-full text-gray-800 px-3 py-2 rounded mb-4">
          <option value="w-64 h-96">A5</option>
          <option value="w-80 h-[28rem]">A4</option>
        </select>

        <label class="block mb-2">رنگ جلد:</label>
        <select id="js-color" class="w-full text-gray-800 px-3 py-2 rounded mb-4">
          <option value="bg-purple-600">بنفش</option>
          <option value="bg-pink-500">صورتی</option>
          <option value="bg-blue-500">آبی</option>
          <option value="bg-green-500">سبز</option>
        </select>

        <label class="block mb-2">نوشته روی جلد:</label>
        <input id="js-quote" type="text" class="w-full text-gray-800 px-3 py-2 rounded mb-4" placeholder="مثلاً: Believe in yourself">

        <label class="block mb-2">فونت نوشته:</label>
        <select id="js-font" class="w-full text-gray-800 px-3 py-2 rounded mb-4">
          <option value="system-ui, -apple-system, Segoe UI, Arial">سیستمی/آریل</option>
          <option value="Tahoma, Verdana, Segoe UI">Tahoma</option>
          <option value="'Comic Sans MS', cursive, sans-serif">Comic Sans</option>
        </select>

        <label class="block mb-2">عکس روی جلد (اختیاری):</label>
        <input id="js-photo" type="file" accept="image/*" class="w-full mb-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-white file:text-gray-800">
        <p class="text-white/60 text-xs">* فقط پیش‌نمایشه؛ جایی آپلود نمی‌شه.</p>
      </div>

      <!-- پیش‌نمایش -->
      <div class="rounded-2xl bg-white/5 border border-white/10 p-5 flex items-center justify-center">
        <div id="js-preview" class="w-64 h-96 bg-purple-600 rounded-xl shadow-lg overflow-hidden relative">
          <!-- عکس کاور (اول مخفیه؛ وقتی عکس انتخاب شد میاد) -->
          <img id="js-coverimg" class="absolute inset-0 w-full h-full object-cover opacity-80 hidden" alt="cover" />
          <!-- متن روی جلد -->
          <div id="js-covertext" class="absolute inset-0 flex items-center justify-center px-4 text-center text-white font-bold">
            Planner
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php get_footer(); ?>