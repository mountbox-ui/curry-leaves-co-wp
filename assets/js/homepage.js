/**
 * Luxury homepage interactions — Curry Leaves Co
 */
(function () {
  'use strict';

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    initLoader();
    initMouseGlow();
    initNav();
    initMobileMenu();
    initHeroSlider();
    initReveal();
    initFilterTabs();
    initCarousels();
    initGallery();
    initCountdown();
    initSmoothScroll();
    initParallax();
    initParticles();
    initBackToTop();
    initCounters();
  });

  function initLoader() {
    const loader = document.querySelector('.page-loader');
    if (!loader) return;
    document.body.style.overflow = 'hidden';
    const hide = () => {
      loader.classList.add('loaded');
      document.body.style.overflow = '';
    };
    window.addEventListener('load', () => setTimeout(hide, 600));
    setTimeout(hide, 2800);
  }

  function initMouseGlow() {
    const glow = document.querySelector('.mouse-glow');
    if (!glow || prefersReduced || !window.matchMedia('(hover: hover)').matches) return;
    let raf;
    document.addEventListener('mousemove', (e) => {
      cancelAnimationFrame(raf);
      raf = requestAnimationFrame(() => {
        glow.style.left = e.clientX + 'px';
        glow.style.top = e.clientY + 'px';
      });
    }, { passive: true });
  }

  function initNav() {
    const nav = document.querySelector('.luxury-nav');
    if (!nav) return;
    const onScroll = () => nav.classList.toggle('scrolled', window.pageYOffset > 60);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  function initMobileMenu() {
    const btn = document.getElementById('hamburger');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu) return;
    const toggle = () => {
      const open = btn.classList.toggle('active');
      menu.classList.toggle('open', open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.style.overflow = open ? 'hidden' : '';
    };
    btn.addEventListener('click', toggle);
    menu.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => {
      btn.classList.remove('active');
      menu.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }));
  }

  function initHeroSlider() {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    if (slides.length < 2) return;

    let current = 0;
    let timer;

    const go = (index) => {
      slides[current].classList.remove('active');
      if (dots[current]) dots[current].classList.remove('active');
      current = (index + slides.length) % slides.length;
      slides[current].classList.add('active');
      if (dots[current]) dots[current].classList.add('active');
    };

    const next = () => go(current + 1);
    const start = () => {
      clearInterval(timer);
      if (!prefersReduced) timer = setInterval(next, 6000);
    };

    dots.forEach((dot, i) => dot.addEventListener('click', () => { go(i); start(); }));
    start();
  }

  function initReveal() {
    const els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
    if (!els.length || prefersReduced) {
      els.forEach((el) => el.classList.add('revealed'));
      return;
    }
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    els.forEach((el) => io.observe(el));
  }

  function initFilterTabs() {
    const tabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('#dishes-grid .dish-card');
    if (!tabs.length || !cards.length) return;

    tabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        tabs.forEach((t) => t.classList.remove('active'));
        tab.classList.add('active');
        const filter = tab.dataset.filter;
        cards.forEach((card) => {
          const categories = card.dataset.category ? card.dataset.category.split(' ') : [];
          const show = filter === 'all' || categories.includes(filter);
          card.style.display = show ? '' : 'none';
          if (show) {
            card.style.animation = 'none';
            card.offsetHeight;
            card.style.animation = '';
          }
        });
      });
    });
  }

  function initCarousels() {
    setupCarousel('top-dishes-carousel', '.carousel-prev', '.carousel-next', true);
    setupCarousel('veg-dishes-carousel', '.carousel-prev', '.carousel-next', false);
    setupCarousel('favorite-dishes-carousel', '.carousel-prev', '.carousel-next', false);
    setupTestimonialSlider();
  }

  function setupCarousel(trackId, prevSel, nextSel, auto) {
    const track = document.getElementById(trackId);
    if (!track) return;
    const container = track.closest('.carousel-container');
    const prev = container?.querySelector(prevSel);
    const next = container?.querySelector(nextSel);
    const cards = track.querySelectorAll('.carousel-card');
    if (cards.length < 2) return;

    let index = 0;
    let intervalId;
    const cardWidth = () => cards[0].offsetWidth + 24;

    const stopAutoScroll = () => {
      if (intervalId) {
        clearInterval(intervalId);
        intervalId = null;
      }
    };

    const scrollTo = (i) => {
      index = (i + cards.length) % cards.length;
      track.scrollTo({ left: index * cardWidth(), behavior: prefersReduced ? 'auto' : 'smooth' });
    };

    prev?.addEventListener('click', () => {
      stopAutoScroll();
      scrollTo(index - 1);
    });

    next?.addEventListener('click', () => {
      stopAutoScroll();
      scrollTo(index + 1);
    });

    cards.forEach((card) => {
      card.addEventListener('click', stopAutoScroll);
    });

    track.addEventListener('pointerdown', stopAutoScroll);
    track.scrollTo({ left: 0, behavior: 'auto' });

    if (auto && !prefersReduced) {
      intervalId = setInterval(() => scrollTo(index + 1), 5000);
    }
  }

  function setupTestimonialSlider() {
    const track = document.getElementById('testimonials-track');
    if (!track) return;
    const cards = track.querySelectorAll('.testimonial-card');
    if (cards.length < 2) return;
    let i = 0;
    const show = (n) => {
      i = (n + cards.length) % cards.length;
      track.style.transform = `translateX(-${i * 100}%)`;
    };
    document.querySelector('.testimonial-prev')?.addEventListener('click', () => show(i - 1));
    document.querySelector('.testimonial-next')?.addEventListener('click', () => show(i + 1));
    if (!prefersReduced) setInterval(() => show(i + 1), 7000);
  }

  function initGallery() {
    const lightbox = document.getElementById('lightbox');
    if (!lightbox) return;
    const img = lightbox.querySelector('img');
    const close = () => lightbox.classList.remove('active');

    document.querySelectorAll('.gallery-item').forEach((item) => {
      item.addEventListener('click', () => {
        const src = item.dataset.src || item.querySelector('img')?.src;
        if (!src || !img) return;
        img.src = src;
        img.alt = item.getAttribute('aria-label') || '';
        lightbox.classList.add('active');
      });
    });

    lightbox.querySelector('.lightbox-close')?.addEventListener('click', close);
    lightbox.addEventListener('click', (e) => { if (e.target === lightbox) close(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
  }

  function initCountdown() {
    const wrap = document.getElementById('offer-countdown');
    if (!wrap) return;
    const end = new Date();
    end.setDate(end.getDate() + 7);
    end.setHours(23, 59, 59, 0);

    const tick = () => {
      const diff = Math.max(0, end - Date.now());
      const d = Math.floor(diff / 86400000);
      const h = Math.floor((diff % 86400000) / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);
      const s = Math.floor((diff % 60000) / 1000);
      const map = { days: d, hours: h, mins: m, secs: s };
      wrap.querySelectorAll('.countdown-value').forEach((el) => {
        const u = el.dataset.unit;
        if (map[u] !== undefined) el.textContent = String(map[u]).padStart(2, '0');
      });
    };
    tick();
    setInterval(tick, 1000);
  }

  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener('click', (e) => {
        const id = anchor.getAttribute('href');
        if (!id || id === '#') return;
        const target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        const navH = document.querySelector('.luxury-nav')?.offsetHeight || 0;
        const top = target.getBoundingClientRect().top + window.pageYOffset - navH;
        window.scrollTo({ top, behavior: prefersReduced ? 'auto' : 'smooth' });
      });
    });
  }

  function initParallax() {
    if (prefersReduced) return;
    const items = document.querySelectorAll('.parallax-img');
    if (!items.length) return;

    const update = () => {
      items.forEach((el) => {
        const speed = parseFloat(el.dataset.speed || '0.12');
        const rect = el.getBoundingClientRect();
        if (rect.bottom < 0 || rect.top > window.innerHeight) return;

        const offset = (rect.top - window.innerHeight * 0.35) * speed;
        const target = el.querySelector('img') || el;
        target.style.transform = `translate3d(0, ${offset}px, 0) scale(1.03)`;
      });
    };

    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  function initParticles() {
    const container = document.querySelector('.hero-particles');
    if (!container || prefersReduced) return;
    for (let i = 0; i < 18; i++) {
      const p = document.createElement('span');
      p.className = 'particle';
      p.style.left = Math.random() * 100 + '%';
      p.style.animationDelay = Math.random() * 5 + 's';
      p.style.animationDuration = 4 + Math.random() * 6 + 's';
      container.appendChild(p);
    }
  }

  function initBackToTop() {
    document.querySelector('.back-to-top')?.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: prefersReduced ? 'auto' : 'smooth' });
    });
  }

  function initCounters() {
    const nums = document.querySelectorAll('.stat-number[data-count]');
    if (!nums.length || prefersReduced) return;
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          const el = entry.target;
          const end = parseInt(el.dataset.count, 10);
          if (!end) return;
          let start = 0;
          const suffix = el.textContent.replace(/[0-9]/g, '');
          const step = Math.ceil(end / 40);
          const timer = setInterval(() => {
            start += step;
            if (start >= end) {
              el.textContent = end + suffix;
              clearInterval(timer);
            } else {
              el.textContent = start + suffix;
            }
          }, 40);
          io.unobserve(el);
        });
      },
      { threshold: 0.5 }
    );
    nums.forEach((n) => io.observe(n));
  }
})();
