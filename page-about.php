<?php
/* Template Name: About Planit (درباره پلنیت) */
if ( ! defined('ABSPATH') ) exit;
get_header();
?>
<main class="text-white" dir="rtl">

  <style>
    /* ظرف کلی صفحه */
    .about-wrap{max-width:1100px;margin:0 auto;padding:28px 16px}

    /* تیترهای سراسری وسط‌چین */
    .abt-title{font-weight:900;font-size:clamp(26px,5vw,40px);letter-spacing:-.02em;text-align:center;margin:10px 0 16px}
    .abt-sub{opacity:.9;line-height:1.9;font-size:clamp(15px,2vw,18px);text-align:center;max-width:850px;margin:0 auto}
    .abt-hr{height:2px;width:90px;margin:12px auto;background:linear-gradient(90deg,rgba(255,255,255,.1),rgba(255,255,255,.6),rgba(255,255,255,.1));border-radius:999px}

    /* هِرو: تصویر + متن */
    .abt-hero{display:grid;gap:20px;align-items:center;margin-top:8px}
    @media(min-width:900px){.abt-hero{grid-template-columns:1.1fr .9fr}}
    .abt-thumb{border-radius:18px;overflow:hidden;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.06)}
    .abt-thumb img{display:block;width:100%;height:auto;/* بدون هیچ فیلتر/blur */}
    
    /* سکشن استاندارد */
    .abt-sec{padding:28px 0}
    .abt-sec h2{font-weight:900;font-size:clamp(20px,4vw,30px);text-align:center;margin:0 0 10px}
    .abt-sec p{opacity:.92;line-height:1.95}

    /* چرا پلنیت؟ سه کارت */
    .why{display:grid;gap:14px;margin-top:14px}
    @media(min-width:720px){.why{grid-template-columns:repeat(3,1fr)}}
    .why .card{border-radius:16px;padding:14px;background:linear-gradient(180deg,rgba(255,255,255,.08),rgba(255,255,255,.05));border:1px solid rgba(255,255,255,.12)}
    .why b{font-weight:800}

    /* تیم */
    .team{display:grid;gap:14px;margin-top:12px}
    @media(min-width:900px){.team{grid-template-columns:repeat(3,1fr)}}
    .member{border-radius:16px;padding:14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);text-align:center}
    .avatar{width:72px;height:72px;border-radius:50%;overflow:hidden;border:2px solid rgba(255,255,255,.2);margin:0 auto 10px}
    .member img{width:100%;height:100%;object-fit:cover}
    .member .name{font-weight:800}
    .member .role{opacity:.85;font-size:14px;margin-top:2px}
    .member .bio{opacity:.9;line-height:1.8;font-size:14px;margin-top:8px}

    /* تایم‌لاین سبک */
    .timeline{max-width:820px;margin:0 auto;display:grid;gap:14px;margin-top:8px}
    .step{position:relative;padding-right:26px}
    .step:before{content:"";position:absolute;right:6px;top:.55em;width:8px;height:8px;border-radius:50%;background:#a78bfa;box-shadow:0 0 0 4px rgba(167,139,250,.18)}
    .step:after{content:"";position:absolute;right:9px;top:1.6em;bottom:-10px;width:2px;background:linear-gradient(#a78bfa,transparent)}
    .step:last-child:after{display:none}
    .step b{font-weight:800}
    .step p{margin:.35rem 0 0;opacity:.9;line-height:1.85}

    /* ویدیو در انتها */
    .abt-video{max-width:920px;margin:0 auto}
    .abt-video .frame{position:relative;padding-top:56.25%;border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.06)}
    .abt-video .frame iframe,
    .abt-video .frame video{position:absolute;inset:0;width:100%;height:100%}
  </style>

  <!-- هِرو -->
  <section class="abt-sec">
    <div class="about-wrap">
      <h1 class="abt-title"><?php echo esc_html( get_the_title() ); ?></h1>
      <div class="abt-hr"></div>
      <p class="abt-sub">
        پلنیت یک برنامه‌ریز صمیمی و مینیماله؛ کمک می‌کنه با قدم‌های کوچک و پیوسته، به هدف‌های بزرگ برسی.
        «وضوح»، «انگیزه» و «پیشرفت قابل‌سنجش» هسته‌ی تجربه‌ی پلنیت‌اند.
      </p>

      <div class="abt-hero" style="margin-top:18px">
        <div class="abt-thumb">
          <!-- تصویر هِرو: URL دلخواهت -->
          <img src="http://planit.hodecode.ir/wp-content/uploads/2025/09/%D8%A7%D9%85-%D9%88%DB%8C-%D9%BE%DB%8C-300x169.png" alt="Planit About">
        </div><div>
          <h2 style="text-align:center">ماموریت و چشم‌انداز</h2>
          <p class="abt-sub" style="margin-top:6px">
            ماموریت ما تبدیل برنامه‌ریزی به تجربه‌ای لذت‌بخش و قابل‌پیگیریه؛
            جایی که هر روز کمی بهتر از دیروز باشی. چشم‌اندازمون ساختن جامعه‌ای از
            یادگیرنده‌های مستقل و باانگیزه‌ست که با ابزارهای ساده، کارهای بزرگ می‌کنن.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- چرا پلنیت؟ -->
  <section class="abt-sec">
    <div class="about-wrap">
      <h2>چرا پلنیت؟</h2>
      <div class="abt-hr"></div>
      <div class="why">
        <div class="card"><b>ساده و شفاف:</b> هر تسک سر جای خودش؛ بدون شلوغی و حواس‌پرتی.</div>
        <div class="card"><b>انگیزه‌ی پایدار:</b> با امتیازها و مسیرهای کوچک، حرکت رو حفظ می‌کنی.</div>
        <div class="card"><b>همراه قابل‌اتکا:</b> مزاحم نیستیم؛ کنارتیم تا پیش بروی.</div>
      </div>
    </div>
  </section>

  <!-- تیم پلنیت -->
  <section class="abt-sec">
    <div class="about-wrap">
      <h2>تیم پلنیت</h2>
      <div class="abt-hr"></div>
      <div class="team">
        <div class="member">
          <div class="avatar"><img src="http://planit.hodecode.ir/wp-content/uploads/2025/09/photo1757920524-296x300.jpeg" alt=""></div>
          <div class="name">لِنا</div>
          <div class="role">Front-end</div>
          <div class="bio">جزئیات + Tailwind؛ عاشق UI تمیز.</div>
        </div>
        <div class="member">
          <div class="avatar"><img src="http://planit.hodecode.ir/wp-content/uploads/2025/09/photo1757920524-1-300x300.jpeg" alt=""></div>
          <div class="name">مبینا</div>
          <div class="role">Front-end</div>
          <div class="bio">تمرین، چالش و رشد مستمر.</div>
        </div>
        <div class="member">
          <div class="avatar"><img src="http://planit.hodecode.ir/wp-content/uploads/2025/09/photo1757920564-300x300.jpeg" alt=""></div>
          <div class="name">ChatGPT</div>
          <div class="role">یار و یاور ما</div>
          <div class="bio">ایده، دیباگ، متن؛ همیشه آماده‌ی کمک.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- چطور رشد کردیم؟ (تایم‌لاین) -->
  <section class="abt-sec">
    <div class="about-wrap">
      <h2>چطور رشد کردیم؟</h2>
      <div class="abt-hr"></div>
      <div class="timeline">
        <div class="step">
          <b>از کجا شروع شد؟</b>
          <p>ایده‌ی یک برنامه‌ریز با حس بازی؛ نه یک چک‌لیست خشک.</p>
        </div>
        <div class="step">
          <b>نسخه‌ی اول</b>
          <p>تسک‌ها، امتیازها و مسیر سیاره‌ها شکل گرفت.</p>
        </div>
        <div class="step">
          <b>بازخوردها</b>
          <p>با نظرهای شما، تجربه‌ی کاربری ساده‌تر و روان‌تر شد.</p>
        </div>
        <div class="step">
          <b>امروز</b>
          <p>تمرکز روی ثبات و امکاناتی که واقعاً به درد می‌خورن.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ویدیو به‌جای گالری -->
  <section class="abt-sec">
    <div class="about-wrap">
      <h2>چند لحظه از مسیر</h2>
      <div class="abt-hr"></div>
      <div class="abt-video">
        <div class="frame">

       
          <!-- نمونه فایل خودت: -->
          <video controls poster="" preload="metadata">
            <source src="http://planit.hodecode.ir/wp-content/uploads/2025/08/2147483648_-210278.mp4" type="video/mp4">
            مرورگر شما از ویدیو پشتیبانی نمی‌کند.
          </video>
        </div>
      </div>
    </div>
  </section>

</main>
<?php get_footer(); ?>