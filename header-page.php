<?php
// template-parts/header-page.php
if ( ! defined('ABSPATH') ) exit;

$pid = get_queried_object_id();

/* ۱) از متا بخون (هر دو کلید محتمل) */
$t = trim( (string) get_post_meta($pid, 'planit_title', true) );
$s = trim( (string) get_post_meta($pid, 'planit_subtitle', true) );
if ($t === '') $t = trim( (string) get_post_meta($pid, 'custom_title', true) );
if ($s === '') $s = trim( (string) get_post_meta($pid, 'custom_subtitle', true) );

/* ۲) اگر متا خالی بود، از داخل محتوا کلاس custom-title/custom-subtitle رو بگیر
      — الان دیگه هر تگی با این کلاس باشه می‌خونیم: <p> یا <h1>/<h2> یا ... */
if ($t === '' || $s === '') {
  $raw = (string) get_post_field('post_content', $pid);

  if ($t === '') {
    if (preg_match('/<([ph][12]?)\b[^>]*class="[^"]*\bcustom-title\b[^"]*"[^>]*>(.*?)<\/\1>/isu', $raw, $m)) {
      $t = wp_strip_all_tags($m[2]);
    } elseif (preg_match('/<[^>]*class="[^"]*\bcustom-title\b[^"]*"[^>]*>(.*?)<\/[^>]+>/isu', $raw, $m2)) {
      $t = wp_strip_all_tags($m2[1]);
    }
  }
  if ($s === '') {
    if (preg_match('/<([ph][12]?)\b[^>]*class="[^"]*\bcustom-subtitle\b[^"]*"[^>]*>(.*?)<\/\1>/isu', $raw, $n)) {
      $s = wp_strip_all_tags($n[2]);
    } elseif (preg_match('/<[^>]*class="[^"]*\bcustom-subtitle\b[^"]*"[^>]*>(.*?)<\/[^>]+>/isu', $raw, $n2)) {
      $s = wp_strip_all_tags($n2[1]);
    }
  }
}

/* ۳) فقط اگه یکی‌ش پر بود، چاپ کن (که UI تکون نخوره) */
if ($t === '' && $s === '') return;
?>
<div class="text-center">
  <?php if ($t !== ''): ?>
    <h1 class="custom-title-ui"><?php echo esc_html($t); ?></h1>
  <?php endif; ?>
  <?php if ($s !== ''): ?>
    <p class="custom-subtitle-ui"><?php echo esc_html($s); ?></p>
  <?php endif; ?>
</div>