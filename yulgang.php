<?php
session_start();
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'vi'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$currentLang = $_SESSION['lang'] ?? 'en';
// Case study page — English-primary, hardcoded content
// Nav lang switcher still works for switching context
$otherLang = ($currentLang === 'en') ? 'vi' : 'en';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yulgang Private Server — Minh Bach, Game Designer</title>
  <meta name="description" content="How I redesigned Yulgang's core systems and reshaped an entire player community — 780 CCU, 65% Day-7 retention, as a solo designer.">
  <meta property="og:title" content="Yulgang Private Server — Case Study by Minh Bach">
  <meta property="og:description" content="780 CCU. 65% Day-7 Retention. Two systems later adopted by the official game. A solo game design project.">
  <meta property="og:type" content="article">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* ════════ READING PROGRESS BAR ════════ */
    #readingProgress {
      position: fixed;
      top: 0; left: 0;
      height: 2px;
      width: 0%;
      background: var(--gold);
      z-index: 9999;
      transition: width 0.1s linear;
    }

    /* ════════ PAGE HERO (case study) ════════ */
    .cs-hero {
      min-height: 55vh;
      display: flex;
      align-items: flex-end;
      padding: 7rem var(--px) 3rem;
      position: relative;
      overflow: hidden;
      background: linear-gradient(160deg, var(--bg) 0%, var(--bg2) 60%, var(--bg) 100%);
    }
    .cs-hero-glow {
      position: absolute;
      inset: 0;
      pointer-events: none;
    }
    .cs-hero-glow::before {
      content: '';
      position: absolute;
      top: -10%; right: -20%;
      width: 65vw; height: 65vw;
      max-width: 750px; max-height: 750px;
      border-radius: 50%;
      background: radial-gradient(circle,
        rgba(242,201,76,0.07) 0%,
        rgba(74,137,200,0.03) 40%,
        transparent 70%
      );
    }
    .cs-hero-glow::after {
      content: '';
      position: absolute;
      bottom: -20%; left: -10%;
      width: 50vw; height: 50vw;
      max-width: 500px; max-height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle,
        rgba(74,137,200,0.05) 0%,
        transparent 60%
      );
    }
    .cs-hero-content {
      max-width: var(--max-w);
      margin: 0 auto;
      width: 100%;
      position: relative;
    }

    /* Breadcrumb */
    .cs-breadcrumb {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 0.75rem;
      font-family: var(--f-mono);
      font-size: 0.65rem;
      letter-spacing: 0.08em;
      color: var(--text3);
      margin-bottom: 2rem;
      opacity: 0;
      animation: fadeUp 0.7s var(--ease) 0.1s forwards;
    }
    .cs-breadcrumb a {
      color: var(--text3);
      transition: color 0.2s;
    }
    .cs-breadcrumb a:hover { color: var(--gold); }
    .cs-breadcrumb .bc-gold { color: var(--gold); }
    .cs-breadcrumb .bc-sep { margin: 0 0.5rem; opacity: 0.4; }
    .cs-reading-time {
      font-family: var(--f-mono);
      font-size: 0.6rem;
      color: var(--text3);
      letter-spacing: 0.08em;
    }

    /* Eyebrow */
    .cs-eyebrow {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-family: var(--f-mono);
      font-size: 0.65rem;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 1.25rem;
      opacity: 0;
      animation: fadeUp 0.7s var(--ease) 0.2s forwards;
    }
    .cs-eyebrow-line {
      display: block;
      width: 2.5rem; height: 1px;
      background: var(--gold);
    }

    /* Title */
    .cs-title {
      font-family: var(--f-display);
      font-size: clamp(2.5rem, 6vw, 4.5rem);
      font-weight: 700;
      line-height: 0.95;
      letter-spacing: -0.02em;
      color: var(--text);
      margin-bottom: 1rem;
      opacity: 0;
      animation: fadeUp 0.7s var(--ease) 0.35s forwards;
    }
    .cs-subtitle {
      font-family: var(--f-display);
      font-size: clamp(1rem, 2vw, 1.25rem);
      font-weight: 500;
      font-style: italic;
      color: var(--gold);
      margin-bottom: 2.5rem;
      opacity: 0;
      animation: fadeUp 0.7s var(--ease) 0.5s forwards;
    }

    /* Impact stats row */
    .cs-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.25rem;
      opacity: 0;
      animation: fadeUp 0.7s var(--ease) 0.65s forwards;
    }
    .cs-stat {
      text-align: center;
      padding: 1.5rem 1rem;
      border: 1px solid var(--border);
      border-radius: 10px;
      background: var(--bg3);
      transition: border-color 0.3s, transform 0.3s var(--ease);
    }
    .cs-stat:hover {
      border-color: var(--border2);
      transform: translateY(-3px);
    }

    /* Scroll indicator */
    .cs-scroll {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-family: var(--f-mono);
      font-size: 0.58rem;
      letter-spacing: 0.15em;
      text-transform: uppercase;
      color: var(--text3);
      margin-top: 3rem;
      opacity: 0;
      animation: fadeUp 0.7s var(--ease) 0.9s forwards;
    }
    .cs-scroll .scroll-line {
      width: 2.5rem; height: 1px;
      background: var(--text3);
      transform-origin: left;
      animation: scrollPulse 2.5s ease-in-out infinite;
    }

    /* ════════ CONTEXT — 2 col ════════ */
    .cs-context-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr;
      gap: 3rem;
      align-items: start;
    }
    .cs-context-text p {
      font-size: 0.95rem;
      color: var(--text2);
      line-height: 1.85;
      margin-bottom: 1.25rem;
    }

    /* Role evolution card */
    .role-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 1.75rem;
    }
    .role-card-title {
      font-family: var(--f-mono);
      font-size: 0.65rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--text3);
      margin-bottom: 1.25rem;
    }
    .role-timeline {
      position: relative;
      padding-left: 1.5rem;
      border-left: 2px solid var(--border2);
    }
    .role-item {
      position: relative;
      padding: 0.65rem 0;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .role-item::before {
      content: '';
      position: absolute;
      left: -1.85rem;
      width: 8px; height: 8px;
      border-radius: 50%;
      background: var(--bg3);
      border: 2px solid var(--border2);
    }
    .role-item.role-highlight::before {
      background: var(--gold);
      border-color: var(--gold);
      box-shadow: 0 0 8px rgba(242,201,76,0.4);
    }
    .role-year {
      font-family: var(--f-mono);
      font-size: 0.6rem;
      color: var(--text3);
      letter-spacing: 0.08em;
      flex-shrink: 0;
      width: 2.5rem;
    }
    .role-highlight .role-year { color: var(--gold); }

    /* ════════ CHALLENGE — 2 equal cols ════════ */
    .cs-challenge-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    /* ════════ PHASE CARDS ════════ */
    .cs-phase-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      margin-bottom: 2rem;
    }
    .phase-card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: clamp(1.5rem, 3vw, 2rem);
      transition: border-color 0.3s, transform 0.3s var(--ease), box-shadow 0.3s;
    }
    .phase-card:hover {
      border-color: var(--border2);
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(0,0,0,0.3);
    }
    .phase-eyebrow {
      font-family: var(--f-mono);
      font-size: 0.6rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      margin-bottom: 0.85rem;
    }
    .phase-eyebrow.gold { color: var(--gold); }
    .phase-eyebrow.muted { color: var(--text3); }
    .phase-card h3 {
      font-family: var(--f-display);
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 0.85rem;
      line-height: 1.3;
    }
    .phase-card > p {
      font-size: 0.88rem;
      color: var(--text2);
      line-height: 1.75;
      margin-bottom: 1.25rem;
    }

    /* ════════ DESIGN DECISION CARDS ════════ */
    .dd-card {
      background: var(--bg3);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: clamp(1.5rem, 3vw, 2.5rem);
      margin-bottom: 2rem;
      transition: border-color 0.3s, box-shadow 0.3s;
    }
    .dd-card:hover {
      border-color: var(--border2);
      box-shadow: 0 12px 48px rgba(0,0,0,0.25);
    }
    .dd-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 0.75rem;
      margin-bottom: 1.25rem;
    }
    .dd-title {
      font-family: var(--f-display);
      font-size: clamp(1.15rem, 2.5vw, 1.5rem);
      font-weight: 700;
      color: var(--text);
      line-height: 1.2;
      margin-bottom: 1.5rem;
    }

    /* ════════ STORY BLOCK (new component) ════════ */
    .story-block {
      display: flex;
      flex-direction: column;
      gap: 0;
    }
    .story-step {
      display: grid;
      grid-template-columns: 6rem 1fr;
      gap: 1.25rem;
      padding: 1.4rem 0;
      border-bottom: 1px solid var(--border);
    }
    .story-step:last-child { border-bottom: none; }
    .story-step-label {
      font-family: var(--f-mono);
      font-size: 0.6rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--text3);
      padding-top: 0.15rem;
      line-height: 1.5;
    }
    .story-step-label span {
      display: block;
      color: var(--gold);
      font-size: 0.7rem;
      margin-bottom: 0.2rem;
    }
    .story-step-content {
      font-size: 0.92rem;
      color: var(--text2);
      line-height: 1.8;
    }
    .story-step-content strong { color: var(--text); font-weight: 500; }

    /* ════════ CALLOUT BLOCK (new component) ════════ */
    .callout {
      border-left: 2px solid var(--gold);
      background: rgba(242,201,76,0.05);
      padding: 1.1rem 1.4rem;
      border-radius: 0 8px 8px 0;
      margin: 1.75rem 0;
    }
    .callout p {
      font-size: 0.92rem;
      color: var(--text2);
      line-height: 1.75;
      margin: 0;
    }
    .callout strong { color: var(--gold); font-weight: 600; }
    .callout--blue {
      border-left-color: var(--blue-dk);
      background: rgba(74,137,200,0.06);
    }

    /* ════════ SECONDARY SYSTEMS (3-col) ════════ */
    .cs-secondary-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.25rem;
    }

    /* ════════ RESULTS SECTION ════════ */
    .cs-results-text {
      font-size: 1.05rem;
      font-weight: 400;
      color: var(--text2);
      max-width: 640px;
      line-height: 1.85;
      margin-top: 2.5rem;
    }
    .cs-results-text strong {
      color: var(--text);
      font-weight: 500;
    }

    /* ════════ NEXT PROJECT NAV ════════ */
    .cs-next {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      align-items: center;
    }
    .cs-next-back {
      display: flex;
      align-items: center;
    }
    .cs-next-card {
      background: var(--bg3);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: clamp(1.5rem, 3vw, 2rem);
      transition: border-color 0.3s, transform 0.3s var(--ease), box-shadow 0.3s;
    }
    .cs-next-card:hover {
      border-color: var(--border2);
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(0,0,0,0.3);
    }
    .cs-next-label {
      font-family: var(--f-mono);
      font-size: 0.6rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--text3);
      margin-bottom: 0.65rem;
    }
    .cs-next-title {
      font-family: var(--f-display);
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--text);
      margin-bottom: 0.5rem;
      line-height: 1.25;
    }
    .cs-next-desc {
      font-size: 0.85rem;
      color: var(--text2);
      line-height: 1.6;
      margin-bottom: 1rem;
    }
    .cs-next-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 0.4rem;
      margin-bottom: 1.25rem;
    }

    /* ════════ RESPONSIVE (case study specifics) ════════ */
    @media (max-width: 900px) {
      .cs-hero { min-height: auto; padding-top: 6rem; }
      .cs-stats { grid-template-columns: repeat(2, 1fr); }
      .cs-context-grid { grid-template-columns: 1fr; }
      .cs-challenge-grid { grid-template-columns: 1fr; }
      .cs-phase-grid { grid-template-columns: 1fr; }
      .cs-secondary-grid { grid-template-columns: 1fr; }
      .cs-next { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
      .cs-hero { padding-top: 5.5rem; }
      .cs-stats { grid-template-columns: repeat(2, 1fr); gap: 0.85rem; }
      .cs-title { font-size: clamp(2rem, 10vw, 3rem); }
      .story-step {
        grid-template-columns: 1fr;
        gap: 0.4rem;
      }
      .story-step-label { padding-bottom: 0.25rem; }
      .cs-breadcrumb { font-size: 0.55rem; }
    }
  </style>
</head>
<body>

  <!-- ═══════ READING PROGRESS BAR ═══════ -->
  <div id="readingProgress"></div>

  <!-- ═══════ NAV ═══════ -->
  <nav id="navbar">
    <div class="nav-left">
      <a class="nav-logo" href="index.php">MB<span class="nav-logo-dot">.</span></a>
      <!-- Language flags in nav -->
      <div class="nav-flags">
        <a href="yulgang.php?lang=vi" class="nav-flag<?= $currentLang === 'vi' ? ' active' : '' ?>" title="Tiếng Việt">
          <span class="flag-mini flag-mini-vi"></span>
        </a>
        <a href="yulgang.php?lang=en" class="nav-flag<?= $currentLang === 'en' ? ' active' : '' ?>" title="English">
          <span class="flag-mini flag-mini-en"></span>
        </a>
      </div>
    </div>
    <ul class="nav-links">
      <li><a href="portfolio.php#about">About</a></li>
      <li><a href="portfolio.php#projects">Projects</a></li>
      <li><a href="portfolio.php#thinking">Thinking</a></li>
      <li><a href="portfolio.php#journey">Journey</a></li>
      <li><a href="portfolio.php#skills">Skills</a></li>
      <li><a href="portfolio.php#contact" class="nav-cta">Let's Talk</a></li>
    </ul>
    <button class="nav-burger" id="burgerBtn" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
  </nav>
  <div class="nav-overlay" id="navOverlay"></div>
  <nav class="nav-drawer" id="navDrawer">
    <div class="drawer-flags">
      <a href="yulgang.php?lang=vi" class="nav-flag<?= $currentLang === 'vi' ? ' active' : '' ?>">
        <span class="flag-mini flag-mini-vi"></span> VI
      </a>
      <a href="yulgang.php?lang=en" class="nav-flag<?= $currentLang === 'en' ? ' active' : '' ?>">
        <span class="flag-mini flag-mini-en"></span> EN
      </a>
    </div>
    <a href="portfolio.php#about"    onclick="closeMenu()">About</a>
    <a href="portfolio.php#projects" onclick="closeMenu()">Projects</a>
    <a href="portfolio.php#thinking" onclick="closeMenu()">Thinking</a>
    <a href="portfolio.php#journey"  onclick="closeMenu()">Journey</a>
    <a href="portfolio.php#skills"   onclick="closeMenu()">Skills</a>
    <a href="portfolio.php#contact"  onclick="closeMenu()">Let's Talk</a>
  </nav>

  <!-- ═══════ PAGE HERO ═══════ -->
  <section class="cs-hero">
    <div class="cs-hero-glow"></div>
    <div class="cs-hero-content">

      <!-- Breadcrumb -->
      <div class="cs-breadcrumb">
        <div>
          <a href="portfolio.php">← Back</a>
          <span class="bc-sep">/</span>
          <a href="portfolio.php#projects" class="bc-gold">Projects</a>
          <span class="bc-sep">/</span>
          <span>Yulgang Private Server</span>
        </div>
        <span class="cs-reading-time">~5 min read</span>
      </div>

      <!-- Eyebrow -->
      <div class="cs-eyebrow">
        <span class="cs-eyebrow-line"></span>
        MMORPG · Game Design · Solo Designer · 2017–2018
      </div>

      <!-- Title -->
      <h1 class="cs-title">Yulgang Private Server</h1>
      <p class="cs-subtitle">Reshape the culture. Rewrite the game.</p>

      <!-- Impact stats -->
      <div class="cs-stats">
        <div class="cs-stat">
          <div class="trust-num" data-target="780">0</div>
          <div class="trust-label">Peak CCU<br>from zero</div>
        </div>
        <div class="cs-stat">
          <div class="trust-num" data-target="65" data-suffix="%">0</div>
          <div class="trust-label">Day-7 Ret.<br>Rate</div>
        </div>
        <div class="cs-stat">
          <div class="trust-num" data-static="2×">2×</div>
          <div class="trust-label">Industry first<br>systems</div>
        </div>
      </div>

      <!-- Scroll indicator -->
      <div class="cs-scroll">
        <span class="scroll-line"></span> Scroll to read
      </div>
    </div>
  </section>

  <!-- ═══════ CONTEXT ═══════ -->
  <section id="context" style="background:var(--bg); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span>BACKGROUND</div>
      <div class="cs-context-grid">
        <div class="cs-context-text">
          <h2 class="section-title reveal">A game I played.<br><em>A game I rebuilt.</em></h2>
          <p class="reveal">Yulgang is a long-standing MMORPG developed by MGame, operated in Vietnam by VTC. Yulgang Private refers to unofficial, community-run servers built on Yulgang's original source code — each with its own design philosophy and operational strategy.</p>
          <p class="reveal">I entered the Yulgang private scene in 2017 as a dedicated player. By 2018, I had moved through QA/QC into an official partner role — and ultimately took full ownership of game design and product decisions.</p>
        </div>
        <div class="reveal" style="transition-delay:0.15s">
          <div class="role-card">
            <div class="role-card-title">My Roles</div>
            <div class="role-timeline">
              <div class="role-item">
                <span class="role-year">2017</span>
                <span class="j-badge">Player & Observer</span>
              </div>
              <div class="role-item">
                <span class="role-year">2017</span>
                <span class="j-badge">QA / QC</span>
              </div>
              <div class="role-item">
                <span class="role-year">2018</span>
                <span class="j-badge accent">Partner — Event & Ops</span>
              </div>
              <div class="role-item role-highlight">
                <span class="role-year">2018</span>
                <span class="j-badge gold">Game Designer + PO</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ THE CHALLENGE ═══════ -->
  <section id="challenge" style="background:var(--bg2); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span>THE CHALLENGE</div>
      <h2 class="section-title reveal">A stagnant culture.<br><em>A blank slate.</em></h2>
      <div class="cs-challenge-grid">
        <div class="value-card reveal">
          <div class="value-icon">⚠️</div>
          <h3>A Scene Frozen in Convention</h3>
          <p>When I arrived, every Yulgang private server followed the same formula — same systems, same events, same player loops. Innovation was absent. The result was rapid churn and a community increasingly bored of a game they still loved.</p>
        </div>
        <div class="value-card reveal" style="transition-delay:0.1s">
          <div class="value-icon">🧪</div>
          <h3>Design as Laboratory</h3>
          <p>I carried two core principles into this work: challenge outdated gaming mindsets, and treat each iteration as an A/B test. This meant doing what others didn't dare — and being willing to fail publicly, and loudly, before finding what worked.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ TWO PHASES ═══════ -->
  <section id="phases" style="background:var(--bg); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span>MY APPROACH</div>
      <h2 class="section-title reveal">Two phases.<br><em>Two kinds of learning.</em></h2>
      <p class="section-intro reveal">Each phase represented a fundamentally different design philosophy — and together, they shaped how I think about game design today.</p>
      <div class="cs-phase-grid">
        <div class="phase-card reveal">
          <div class="phase-eyebrow gold">PHASE 01</div>
          <h3>The Burn-Through Server</h3>
          <p>My early servers focused on recalibrating ratios, stats, and in-game values to create a more engaging experience than the original. Incremental. Precise. Player-tested.</p>
          <div class="j-lesson">
            <span class="j-lesson-label">📖 Learned:</span>
            How to read what players need — not just what they say they want.
          </div>
        </div>
        <div class="phase-card reveal" style="transition-delay:0.15s">
          <div class="phase-eyebrow muted">PHASE 02</div>
          <h3>The Experimental Server</h3>
          <p>Radical experimentation — modifying Yulgang's core to embed ideas from Phong Thần, Võ Lâm, Kiếm Thế, MU, and Laplace M. This phase was about creating new experiences, not improving existing ones.</p>
          <div class="j-lesson">
            <span class="j-lesson-label">📖 Learned:</span>
            How to create player experiences that didn't exist yet — and get a community to follow.
          </div>
        </div>
      </div>
      <a href="https://docs.google.com/spreadsheets/" target="_blank" class="btn btn-ghost" style="font-size:0.75rem; padding:0.65rem 1.25rem">↗ View planning comparison (Phase 1 vs Phase 2)</a>
    </div>
  </section>

  <!-- ═══════ KEY DESIGN DECISIONS ═══════ -->
  <section id="decisions" style="background:var(--bg2); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span>DESIGN DECISIONS</div>
      <h2 class="section-title reveal">Three systems.<br><em>Three design problems solved.</em></h2>
      <p class="section-intro reveal">Not a feature list — a set of observations turned into design.</p>

      <!-- SYSTEM 1 — Circulatory Quest -->
      <div class="dd-card reveal">
        <div class="dd-header">
          <span class="project-tag">01 / CIRCULATORY QUEST SYSTEM</span>
          <span class="j-badge">Signature Design</span>
        </div>
        <h3 class="dd-title">Turning a Developer's Mistake Into a Core System</h3>
        <div class="story-block">
          <div class="story-step">
            <div class="story-step-label"><span>01</span>THE MOMENT</div>
            <div class="story-step-content">Most private servers disabled the quest system entirely. Low experience rewards made it seem worthless. Then a developer accidentally left it active during a test window.</div>
          </div>
          <div class="story-step">
            <div class="story-step-label"><span>02</span>THE INSIGHT</div>
            <div class="story-step-content"><strong>While others saw a bug, I saw a structure.</strong> Not for main quests — but for cyclical, repeatable loops. The kind that create daily habits, not one-time progress.</div>
          </div>
          <div class="story-step">
            <div class="story-step-label"><span>03</span>THE SOLUTION</div>
            <div class="story-step-content">I refocused the reward structure: removed experience gains, introduced power-enhancing buffs with long-term value — designed to avoid resource inflation while keeping players returning daily.</div>
          </div>
        </div>
        <div class="callout">
          <p>This is the clearest example of what I believe game design is: <strong>not inventing from scratch, but seeing what's already there — and understanding it better than anyone else in the room.</strong></p>
        </div>
      </div>

      <!-- SYSTEM 2 — Dungeon Resource -->
      <div class="dd-card reveal">
        <div class="dd-header">
          <span class="project-tag">02 / DUNGEON RESOURCE DISTRIBUTION</span>
          <span class="j-badge gold">Industry Influence</span>
        </div>
        <h3 class="dd-title">Killing Auto-Bot Culture With Structure</h3>
        <div class="story-block">
          <div class="story-step">
            <div class="story-step-label"><span>01</span>THE PROBLEM</div>
            <div class="story-step-content">Players had defaulted to passive auto-botting — the path of least resistance in a resource-abundant environment. Active engagement was low. Community interaction was absent.</div>
          </div>
          <div class="story-step">
            <div class="story-step-label"><span>02</span>THE SOLUTION</div>
            <div class="story-step-content">I tightened the open-world resource supply and redistributed it into dungeons — requiring active participation, time investment, and strategic decision-making. Extra dungeon entries became a monetization lever.</div>
          </div>
          <div class="story-step">
            <div class="story-step-label"><span>03</span>THE RESULT</div>
            <div class="story-step-content">Players shifted from passive to active. Community interaction increased as dungeons became shared content. The dungeon model became the default resource strategy.</div>
          </div>
        </div>
        <div class="callout">
          <p>📊 <strong>From 2023, an estimated 80% of Vietnamese private servers adopted dungeon-based resource distribution.</strong> This server set the pattern.</p>
        </div>
      </div>

      <!-- SYSTEM 3 — Celestial-Demonic -->
      <div class="dd-card reveal">
        <div class="dd-header">
          <span class="project-tag">03 / CELESTIAL-DEMONIC WEAPONS</span>
          <span class="j-badge gold">Ahead of Official</span>
        </div>
        <h3 class="dd-title">Designing the Future — Before the Official Game Did</h3>
        <div class="story-block">
          <div class="story-step">
            <div class="story-step-label"><span>01</span>THE INSIGHT</div>
            <div class="story-step-content">Players weren't just farming for power — they were farming for <strong>the story of discovery</strong>. The feeling of finding something rare, something others hadn't reached. Status through progression, not just stats.</div>
          </div>
          <div class="story-step">
            <div class="story-step-label"><span>02</span>THE SOLUTION</div>
            <div class="story-step-content">I designed a weapon tier requiring level 160 — a hard wall that forced players to fully max their progression before unlocking special material farming. The ultimate weapon form became a community status symbol and a long-term goal.</div>
          </div>
        </div>
        <div class="callout">
          <p>🏆 <strong>In 2021 — three years after this server — Yulgang Official introduced a similar level-160 upgrade system.</strong> The private server had designed ahead of the official game.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ SECONDARY SYSTEMS ═══════ -->
  <section id="other-systems" style="background:var(--bg); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span>OTHER SYSTEMS</div>
      <h2 class="section-title reveal">Supporting systems.<br><em>Depth through detail.</em></h2>
      <div class="cs-secondary-grid">
        <div class="value-card reveal">
          <div class="value-icon">🎭</div>
          <h3>Custom Costume System</h3>
          <p>Expanded the original 4-slot costume system into a richer stat diversity — from basic attributes to unique character-specific abilities.</p>
        </div>
        <div class="value-card reveal" style="transition-delay:0.1s">
          <div class="value-icon">🏯</div>
          <h3>Guild Territory System</h3>
          <p>Introduced territorial upgrades, time-limited member buffs, and resource sinks — transforming guilds from labels into ecosystems with strategic depth.</p>
        </div>
        <div class="value-card reveal" style="transition-delay:0.2s">
          <div class="value-icon">🔄</div>
          <h3>Rebirth System</h3>
          <p>First server in Vietnam to implement rebirth. Built accompanying activities to gather materials, extending endgame and creating fresh progression loops.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ RESULTS ═══════ -->
  <section id="results" style="background:var(--bg2); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span>RESULTS</div>
      <h2 class="section-title reveal">Numbers that<br><em>meant something.</em></h2>
      <div class="trust-stats reveal">
        <div class="trust-stat">
          <div class="trust-num" data-target="780">0</div>
          <div class="trust-label">Peak CCU<br>from zero</div>
        </div>
        <div class="trust-stat">
          <div class="trust-num" data-target="65" data-suffix="%">0</div>
          <div class="trust-label">Day-7 Ret.<br>Rate</div>
        </div>
        <div class="trust-stat">
          <div class="trust-num" data-target="2">0</div>
          <div class="trust-label">Industry<br>firsts</div>
        </div>
        <div class="trust-stat">
          <div class="trust-num" data-target="3" data-suffix="+">0</div>
          <div class="trust-label">Years active<br>community</div>
        </div>
      </div>
      <p class="cs-results-text reveal">Beyond the numbers, the most meaningful result was cultural: I successfully shifted the traditionally conservative Yulgang player base toward accepting new systems and a fundamentally different vision of what the game could be.<br><br><strong>For a community known for resisting change — that was the hardest metric to move.</strong></p>
    </div>
  </section>

  <!-- ═══════ REFLECTION ═══════ -->
  <section id="reflection" style="background:var(--bg); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span>WHAT I LEARNED</div>
      <h2 class="section-title reveal">Three lessons.<br><em>Still designing with them.</em></h2>
      <div class="value-cards">
        <div class="value-card reveal">
          <div class="value-icon">👁️</div>
          <h3>Design is observation before invention.</h3>
          <p>The Circulatory Quest didn't come from a design sprint. It came from watching a mistake and seeing what others missed. The best insight I've had came from paying attention.</p>
        </div>
        <div class="value-card reveal" style="transition-delay:0.1s">
          <div class="value-icon">📊</div>
          <h3>Player behavior is the most honest spec.</h3>
          <p>No document predicts how players will actually interact with a system. The Dungeon redesign worked because I watched auto-botting long enough to understand the root cause — not just the symptom.</p>
        </div>
        <div class="value-card reveal" style="transition-delay:0.2s">
          <div class="value-icon">⏩</div>
          <h3>Being early is a design strategy.</h3>
          <p>Both the Celestial-Demonic system and the Dungeon model were adopted later by the broader community. That wasn't luck — it was designing toward where the game needed to go, before the market agreed.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ NEXT PROJECT NAV ═══════ -->
  <section id="next-project" style="background:var(--bg2); border-top:1px solid var(--border)">
    <div class="wrap">
      <div class="cs-next">
        <div class="cs-next-back reveal">
          <a href="portfolio.php#projects" class="btn btn-ghost">← Back to All Projects</a>
        </div>
        <div class="cs-next-card reveal" style="transition-delay:0.1s">
          <div class="cs-next-label">NEXT PROJECT</div>
          <div class="cs-next-title">Silkroad Online Origin Mobile</div>
          <div class="cs-next-desc">17 months. One mobile MMORPG. Three awards.</div>
          <div class="cs-next-badges">
            <span class="j-badge gold">🏆 Best Gameplay</span>
            <span class="j-badge gold">🏆 Best Graphics</span>
            <span class="j-badge gold">🏆 Game of the Year</span>
          </div>
          <a href="silkroad.php" class="btn btn-primary">Read Case Study <span>→</span></a>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ FOOTER ═══════ -->
  <footer>
    <span>© 2025 Minh Bach</span>
    <span>Game Designer · Product Owner · Ho Chi Minh City, Vietnam</span>
  </footer>

  <script>
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
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));

    // ═══════ Animated counters ═══════
    const cio = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (!e.isIntersecting) return;
        const el = e.target;
        // Skip static entries (like "2×")
        if (el.dataset.static) { cio.unobserve(el); return; }
        const target = +el.dataset.target;
        const suffix = el.dataset.suffix || '+';
        const duration = 1800, step = target / (duration / 16);
        let cur = 0;
        const tick = setInterval(() => {
          cur += step;
          if (cur >= target) {
            el.textContent = target + suffix;
            clearInterval(tick);
          } else {
            el.textContent = Math.floor(cur);
          }
        }, 16);
        cio.unobserve(el);
      });
    }, { threshold: 0.5 });
    document.querySelectorAll('.trust-num[data-target]').forEach(el => cio.observe(el));

    // ═══════ Reading progress bar ═══════
    const progressBar = document.getElementById('readingProgress');
    if (progressBar) {
      window.addEventListener('scroll', () => {
        const doc = document.documentElement;
        const scrolled = doc.scrollTop / (doc.scrollHeight - doc.clientHeight);
        progressBar.style.width = (scrolled * 100) + '%';
      }, { passive: true });
    }
  </script>
</body>
</html>
