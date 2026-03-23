/**
 * i18n.js — Minh Bach Portfolio
 * Loads lang JSON, injects into [data-i18n] elements.
 * Lang preference stored in localStorage (key: "lang").
 * Switch lang via ?lang=vi or ?lang=en in URL.
 */

(function () {
  // ─── 1. Resolve current language ───────────────────────────────────────────
  const urlParams = new URLSearchParams(window.location.search);
  const urlLang   = urlParams.get('lang');
  const VALID     = ['en', 'vi'];

  let lang;
  if (urlLang && VALID.includes(urlLang)) {
    lang = urlLang;
    localStorage.setItem('lang', lang);
    // Clean the URL without reloading (optional, keeps URLs tidy)
    const cleanUrl = window.location.pathname + window.location.hash;
    window.history.replaceState({}, '', cleanUrl);
  } else {
    lang = localStorage.getItem('lang') || 'en';
  }

  // Expose globally so other scripts can read current lang
  window.LANG = lang;

  // ─── 2. Set <html lang=""> immediately ────────────────────────────────────
  document.documentElement.lang = lang;

  // ─── 3. Helper: resolve nested key (e.g. "hero.title") ───────────────────
  function getKey(obj, key) {
    return key.split('.').reduce((o, k) => (o && o[k] !== undefined ? o[k] : null), obj);
  }

  // ─── 4. Apply translations to DOM ─────────────────────────────────────────
  function applyTranslations(data) {
    // [data-i18n] — innerHTML (supports HTML tags)
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.dataset.i18n;
      const val = getKey(data, key);
      if (val !== null) el.innerHTML = val;
    });

    // [data-i18n-text] — textContent only (safe fallback)
    document.querySelectorAll('[data-i18n-text]').forEach(el => {
      const key = el.dataset.i18nText;
      const val = getKey(data, key);
      if (val !== null) el.textContent = val;
    });

    // [data-i18n-placeholder] — placeholder attr
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
      const key = el.dataset.i18nPlaceholder;
      const val = getKey(data, key);
      if (val !== null) el.placeholder = val;
    });

    // [data-i18n-title] — title attr
    document.querySelectorAll('[data-i18n-title]').forEach(el => {
      const key = el.dataset.i18nTitle;
      const val = getKey(data, key);
      if (val !== null) el.title = val;
    });

    // Update lang switcher buttons active state
    document.querySelectorAll('[data-lang-btn]').forEach(btn => {
      btn.classList.toggle('active', btn.dataset.langBtn === lang);
    });
  }

  // ─── 5. Load lang JSON ────────────────────────────────────────────────────
  // Determine base path (works whether at root or in subdir)
  const base = (function() {
    const scripts = document.querySelectorAll('script[src*="i18n"]');
    if (scripts.length) {
      const src = scripts[scripts.length - 1].src;
      return src.substring(0, src.indexOf('/js/i18n.js'));
    }
    return '';
  })();

  fetch(`${base}/lang/${lang}.json?v=${Date.now()}`)
    .then(r => {
      if (!r.ok) throw new Error(`Lang file not found: ${lang}.json`);
      return r.json();
    })
    .then(data => {
      window.LANG_DATA = data;
      applyTranslations(data);
      // Dispatch event so other scripts can hook in after translations are applied
      document.dispatchEvent(new CustomEvent('i18n:ready', { detail: { lang, data } }));
    })
    .catch(err => {
      console.warn('[i18n]', err.message);
      // Fallback to en if requested lang fails
      if (lang !== 'en') {
        fetch(`${base}/lang/en.json`)
          .then(r => r.json())
          .then(data => { window.LANG_DATA = data; applyTranslations(data); });
      }
    });

  // ─── 6. Lang switch helper (callable from HTML onclick) ──────────────────
  window.switchLang = function (newLang) {
    if (!VALID.includes(newLang)) return;
    localStorage.setItem('lang', newLang);
    window.location.href = window.location.pathname + '?lang=' + newLang + window.location.hash;
  };
})();
