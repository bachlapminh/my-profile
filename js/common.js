/**
 * common.js — Shared functionality across all portfolio pages
 */

// ═══════ Nav scroll effect ═══════
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 60);
}, { passive: true });

// ═══════ Mobile menu ═══════
const burger  = document.getElementById('burgerBtn');
const drawer  = document.getElementById('navDrawer');
const overlay = document.getElementById('navOverlay');
function openMenu()  {
  burger.classList.add('open');
  drawer.classList.add('open');
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeMenu() {
  burger.classList.remove('open');
  drawer.classList.remove('open');
  overlay.classList.remove('open');
  document.body.style.overflow = '';
}
burger.addEventListener('click', () =>
  drawer.classList.contains('open') ? closeMenu() : openMenu()
);
overlay.addEventListener('click', closeMenu);
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) closeMenu();
}, { passive: true });

// ═══════ Scroll reveal ═══════
const io = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) e.target.classList.add('visible');
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal, .j-item').forEach(el => io.observe(el));

// ═══════ Animated counters ═══════
const cio = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (!e.isIntersecting) return;
    const el = e.target;
    if (el.dataset.static) { cio.unobserve(el); return; }
    const target = +el.dataset.target;
    const suffix = el.dataset.suffix || '+';
    const duration = 1800, step = target / (duration / 16);
    let cur = 0;
    const tick = setInterval(() => {
      cur += step;
      if (cur >= target) { el.textContent = target + suffix; clearInterval(tick); }
      else el.textContent = Math.floor(cur);
    }, 16);
    cio.unobserve(el);
  });
}, { threshold: 0.5 });
document.querySelectorAll('.trust-num[data-target]').forEach(el => cio.observe(el));

// ═══════ Float panel ═══════
const floatPanel = document.getElementById('floatPanel');
if (floatPanel) {
  window.addEventListener('scroll', () => {
    floatPanel.classList.toggle('visible', window.scrollY > 300);
  }, { passive: true });
  // Single language toggle: show only the opposite language button
  const currentLang = window.LANG || 'en';
  floatPanel.querySelectorAll('.fp-lang-toggle').forEach(btn => {
    btn.style.display = (btn.dataset.showWhen === currentLang) ? '' : 'none';
  });
}

// ═══════ Reading progress bar ═══════
const readingBar = document.getElementById('readingProgress');
if (readingBar) {
  window.addEventListener('scroll', () => {
    const max = document.body.scrollHeight - window.innerHeight;
    readingBar.style.width = (window.scrollY / max * 100) + '%';
  }, { passive: true });
}

// ═══════ Sticky TOC Bar ═══════
const tocBar = document.getElementById('csTocBar');
const heroEl = document.getElementById('cs-hero-top');
if (tocBar && heroEl) {
  const tocIO = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (!e.isIntersecting) tocBar.classList.add('ready');
      else tocBar.classList.remove('ready');
    });
  }, { threshold: 0, rootMargin: '-80px 0px 0px 0px' });
  tocIO.observe(heroEl);

  const tocLinks = tocBar.querySelectorAll('.cs-toc-link[data-section]');
  const tocSections = Array.from(tocLinks).map(l => document.getElementById(l.dataset.section)).filter(Boolean);
  function updateToc() {
    const scrollY = window.scrollY;
    const offset = 120;
    let current = '';
    tocSections.forEach(s => { if (scrollY >= s.offsetTop - offset) current = s.id; });
    tocLinks.forEach(l => l.classList.toggle('active', l.dataset.section === current));
  }
  window.addEventListener('scroll', updateToc, { passive: true });
  updateToc();
}

// ═══════ Index-only: Active nav highlighting ═══════
const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');
if (navLinks.length > 0) {
  const trackedSections = ['about','projects','journey','skills','contact']
    .map(id => document.getElementById(id)).filter(Boolean);
  function updateActiveNav() {
    const scrollY = window.scrollY;
    let current = '';
    trackedSections.forEach(section => {
      if (scrollY >= section.offsetTop - 120) current = section.id;
    });
    navLinks.forEach(link => {
      link.classList.toggle('active', link.getAttribute('href') === '#' + current);
    });
  }
  window.addEventListener('scroll', updateActiveNav, { passive: true });
  updateActiveNav();
}

// ═══════ Silkroad-specific count-ups ═══════
function triggerCountUp() {
  document.querySelectorAll('.retention-pct[data-target]').forEach(el => {
    const target = parseFloat(el.dataset.target);
    let start = null;
    const duration = 1400;
    function step(ts) {
      if (!start) start = ts;
      const p = Math.min((ts - start) / duration, 1);
      const e = 1 - Math.pow(1 - p, 3);
      el.textContent = (e * target).toFixed(1) + '%';
      if (p < 1) requestAnimationFrame(step);
      else el.textContent = target.toFixed(1) + '%';
    }
    requestAnimationFrame(step);
  });
}
function triggerResultsCountUp() {
  document.querySelectorAll('.result-big[data-target]').forEach(el => {
    const target = parseInt(el.dataset.target);
    let start = null;
    const duration = 1200;
    function step(ts) {
      if (!start) start = ts;
      const p = Math.min((ts - start) / duration, 1);
      const e = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(e * target);
      if (p < 1) requestAnimationFrame(step);
      else el.textContent = target;
    }
    requestAnimationFrame(step);
  });
}
