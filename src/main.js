document.addEventListener('DOMContentLoaded', function(){
  /* === Counter (از 0 تا مقصد، با پسوند) === */
  const counters = document.querySelectorAll('.js-counter');
  const statsSection = document.querySelector('.js-stats-section');
  let countersStarted = false;

  function animateCounter(el){
    const raw = (el.dataset.target || '0').toString().trim();
    const targetNum = parseInt(raw.replace(/[^\d]/g,''),10) || 0;
    const suffix = raw.replace(targetNum.toString(), '');
    const dur = 1200; // 1.2s
    const t0 = performance.now();
    function tick(t){
      const p = Math.min(1,(t - t0)/dur);
      const val = Math.round(targetNum * p);
      el.textContent = (p < 1) ? val : (targetNum + suffix);
      if(p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  if(statsSection && counters.length){
    const ob1 = new IntersectionObserver((ents)=>{
      ents.forEach(e=>{
        if(e.isIntersecting && !countersStarted){
          countersStarted = true;
          counters.forEach(animateCounter);
          ob1.disconnect();
        }
      });
    },{threshold:0.35});
    ob1.observe(statsSection);
  }

  /* === Rocket: وقتی هیرو دیده شد حرکت کنه === */
  const hero = document.getElementById('hero-wrap');
  const rocket = document.getElementById('rocket');
  if(hero && rocket){
    const ob2 = new IntersectionObserver((ents)=>{
      ents.forEach(e=>{
        if(e.isIntersecting){
          rocket.classList.remove('opacity-0');
          rocket.classList.add('rocket-go');
          ob2.disconnect();
        }
      });
    },{threshold:0.2});
    ob2.observe(hero);
  }

  /* === Customizer خیلی ساده: سایز + رنگ + متن + فونت + عکس === */
  const elSize   = document.getElementById('js-size');
  const elColor  = document.getElementById('js-color');
  const elQuote  = document.getElementById('js-quote');
  const elFont   = document.getElementById('js-font');
  const elPhoto  = document.getElementById('js-photo');
  const preview  = document.getElementById('js-preview');
  const coverImg = document.getElementById('js-coverimg');
  const coverTxt = document.getElementById('js-covertext');

  function updatePreview(){
    if(!preview) return;
    // کلاس‌های سایز+رنگ
    const sizeCls  = elSize ? elSize.value : 'w-64 h-96';
    const colorCls = elColor ? elColor.value : 'bg-purple-600';
    preview.className = sizeCls + ' ' + colorCls + ' rounded-xl shadow-lg overflow-hidden relative';

    // متن
    if (coverTxt){
      const q = (elQuote && elQuote.value.trim()) ? elQuote.value.trim() : 'Planner';
      coverTxt.textContent = q;
      // فونت
      if (elFont && elFont.value) {
        coverTxt.style.fontFamily = elFont.value;
      }
    }
  }

  // عکس
  function handlePhotoChange(e){
    if(!coverImg) return;
    const f = e.target.files && e.target.files[0];
    if(!f){
      coverImg.src = '';
      coverImg.classList.add('hidden');
      return;
    }
    const url = URL.createObjectURL(f);
    coverImg.src = url;
    coverImg.classList.remove('hidden');
  }

  if (elSize)  elSize.addEventListener('change', updatePreview);
  if (elColor) elColor.addEventListener('change', updatePreview);
  if (elQuote) elQuote.addEventListener('input',  updatePreview);
  if (elFont)  elFont.addEventListener('change', updatePreview);
  if (elPhoto) elPhoto.addEventListener('change', handlePhotoChange);

  // اولین رندر
  if (preview) updatePreview();

  /* === Gamify: چینش مینیمال نقطه‌ها (اگه صفحه‌اش بود) === */
  const wrap  = document.getElementById('orbit-wrap');
  const rings = document.getElementById('rings');
  if (wrap && rings){
    const dots = rings.querySelectorAll('.planet-dot');

    function getInsets(){
      try { return JSON.parse(rings.getAttribute('data-insets')) || []; }
      catch(e){ return []; }
    }
    const insets = getInsets();
    const perRing = parseInt(rings.getAttribute('data-per-ring') || '6', 10);
    const ringCount = insets.length;function layoutDots(){
      const rect = wrap.getBoundingClientRect();
      const w = rect.width, h = rect.height;
      const cx = w/2, cy = h/2;
      const outer = Math.min(w,h)/2;

      dots.forEach(function(dot, i){
        let ringIndex = Math.floor(i / perRing);
        if (ringIndex > ringCount - 1) ringIndex = ringCount - 1;

        const inset = insets[ringIndex] || 0;
        const r = outer - inset - 8;

        const seed = (i+1) * 9301 % 233280;
        const ang  = (seed / 233280) * Math.PI * 2;

        const x = cx + Math.cos(ang) * r;
        const y = cy + Math.sin(ang) * r;

        const col = dot.getAttribute('data-color') || '#fff';
        dot.style.background = col;
        dot.style.left = (x - 8) + 'px';
        dot.style.top  = (y - 8) + 'px';
        dot.style.zIndex = 30;
      });
    }

    layoutDots();
    window.addEventListener('resize', layoutDots);
  }
});