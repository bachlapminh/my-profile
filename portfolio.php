<?php
session_start();

// ═══════ Language handler ═══════
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'vi'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
$currentLang = $_SESSION['lang'] ?? 'en';
require_once __DIR__ . '/lang/' . $currentLang . '.php';

// Helper: echo with key
function t($key) {
    global $lang;
    return $lang[$key] ?? $key;
}
$otherLang = ($currentLang === 'en') ? 'vi' : 'en';
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minh Bach — Game Designer & Product Owner</title>
  <meta name="description" content="<?= htmlspecialchars(strip_tags(t('hero_desc'))) ?>">
  <meta property="og:title" content="Minh Bach — Game Designer & Product Owner">
  <meta property="og:description" content="<?= htmlspecialchars(t('hero_tagline')) ?>">
  <meta property="og:type" content="website">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- ═══════ NAV ═══════ -->
  <nav id="navbar">
    <div class="nav-left">
      <a class="nav-logo" href="index.php">MB<span class="nav-logo-dot">.</span></a>
      <!-- Language flags in nav -->
      <div class="nav-flags">
        <a href="portfolio.php?lang=vi" class="nav-flag<?= $currentLang === 'vi' ? ' active' : '' ?>" title="Tiếng Việt">
          <span class="flag-mini flag-mini-vi"></span>
        </a>
        <a href="portfolio.php?lang=en" class="nav-flag<?= $currentLang === 'en' ? ' active' : '' ?>" title="English">
          <span class="flag-mini flag-mini-en"></span>
        </a>
      </div>
    </div>
    <ul class="nav-links">
      <li><a href="#about"><?= t('nav_about') ?></a></li>
      <li><a href="#projects"><?= t('nav_projects') ?></a></li>
      <li><a href="#thinking"><?= t('nav_thinking') ?></a></li>
      <li><a href="#journey"><?= t('nav_journey') ?></a></li>
      <li><a href="#skills"><?= t('nav_skills') ?></a></li>
      <li><a href="#contact" class="nav-cta"><?= t('nav_cta') ?></a></li>
    </ul>
    <button class="nav-burger" id="burgerBtn" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
  </nav>
  <div class="nav-overlay" id="navOverlay"></div>
  <nav class="nav-drawer" id="navDrawer">
    <div class="drawer-flags">
      <a href="portfolio.php?lang=vi" class="nav-flag<?= $currentLang === 'vi' ? ' active' : '' ?>">
        <span class="flag-mini flag-mini-vi"></span> VI
      </a>
      <a href="portfolio.php?lang=en" class="nav-flag<?= $currentLang === 'en' ? ' active' : '' ?>">
        <span class="flag-mini flag-mini-en"></span> EN
      </a>
    </div>
    <a href="#about"    onclick="closeMenu()"><?= t('nav_about') ?></a>
    <a href="#projects" onclick="closeMenu()"><?= t('nav_projects') ?></a>
    <a href="#thinking" onclick="closeMenu()"><?= t('nav_thinking') ?></a>
    <a href="#journey"  onclick="closeMenu()"><?= t('nav_journey') ?></a>
    <a href="#skills"   onclick="closeMenu()"><?= t('nav_skills') ?></a>
    <a href="#contact"  onclick="closeMenu()"><?= t('nav_cta') ?></a>
  </nav>

  <!-- ═══════ HERO ═══════ -->
  <section id="hero">
    <div class="hero-glow"></div>
    <div class="hero-content">
      <div class="hero-text">
        <div class="hero-eyebrow">
          <span class="hero-eyebrow-line"></span>
          <?= t('hero_eyebrow') ?>
        </div>
        <h1 class="hero-name"><?= t('hero_name_1') ?><br><span class="accent"><?= t('hero_name_2') ?></span></h1>
        <p class="hero-tagline"><?= t('hero_tagline') ?></p>
        <p class="hero-desc"><?= t('hero_desc') ?></p>
        <div class="hero-cta">
          <a href="#projects" class="btn btn-primary"><?= t('hero_cta_work') ?></a>
          <a href="#contact"  class="btn btn-ghost"><?= t('hero_cta_connect') ?></a>
        </div>
      </div>
      <div class="hero-avatar-wrap">
        <img src="images/avatar.png" alt="Minh Bach — Game Designer" class="hero-avatar">
        <div class="hero-avatar-ring"></div>
        <div class="hero-avatar-tag">HCM<br>VN</div>
      </div>
    </div>
    <div class="hero-scroll">
      <span class="scroll-line"></span> <?= t('hero_scroll') ?>
    </div>
  </section>

  <!-- ═══════ ABOUT / POSITIONING ═══════ -->
  <section id="about">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span><?= t('about_label') ?></div>
      <h2 class="section-title"><?= t('about_title_1') ?><br><em><?= t('about_title_2') ?></em></h2>
      <p class="about-intro reveal"><?= t('about_intro') ?></p>
      <div class="value-cards">
        <div class="value-card reveal">
          <div class="value-icon">⚙️</div>
          <h3><?= t('about_card1_title') ?></h3>
          <p><?= t('about_card1_desc') ?></p>
        </div>
        <div class="value-card reveal" style="transition-delay:0.1s">
          <div class="value-icon">📊</div>
          <h3><?= t('about_card2_title') ?></h3>
          <p><?= t('about_card2_desc') ?></p>
        </div>
        <div class="value-card reveal" style="transition-delay:0.2s">
          <div class="value-icon">🎯</div>
          <h3><?= t('about_card3_title') ?></h3>
          <p><?= t('about_card3_desc') ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ FEATURED PROJECTS ═══════ -->
  <section id="projects">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span><?= t('proj_label') ?></div>
      <h2 class="section-title reveal"><?= t('proj_title_1') ?> <em><?= t('proj_title_2') ?></em></h2>
      <p class="section-intro reveal"><?= t('proj_intro') ?></p>
      <div class="projects-grid">

        <!-- PROJECT 1: Silkroad -->
        <article class="project-card project-card--featured reveal">
          <img src="images/silkroadonline.png" alt="Silkroad Online Origin Mobile" class="project-banner">
          <div class="project-body">
            <div class="project-meta">
              <span class="project-tag"><?= t('proj_sr_tag1') ?></span>
              <span class="project-tag"><?= t('proj_sr_tag2') ?></span>
              <span class="project-tag tag-role"><?= t('proj_sr_tag3') ?></span>
            </div>
            <h3 class="project-title"><?= t('proj_sr_title') ?></h3>
            <p class="project-impact"><?= t('proj_sr_impact') ?></p>
            <p class="project-desc"><?= t('proj_sr_desc') ?></p>
            <div class="project-stats">
              <div class="project-stat"><span class="stat-badge">🏆</span><span><?= t('proj_sr_stat1') ?></span></div>
              <div class="project-stat"><span class="stat-badge">🎨</span><span><?= t('proj_sr_stat2') ?></span></div>
              <div class="project-stat"><span class="stat-badge">🎮</span><span><?= t('proj_sr_stat3') ?></span></div>
            </div>
            <div class="chips">
              <span class="chip"><?= t('chip_product_ownership') ?></span>
              <span class="chip"><?= t('chip_mmorpg') ?></span>
              <span class="chip"><?= t('chip_mobile_adapt') ?></span>
              <span class="chip"><?= t('chip_team_lead') ?></span>
              <span class="chip"><?= t('chip_combat_sys') ?></span>
              <span class="chip"><?= t('chip_reverse_eng') ?></span>
            </div>
            <a href="#" class="project-link"><?= t('proj_sr_link') ?> <span class="arrow">→</span></a>
          </div>
        </article>

        <!-- PROJECT 2: Yulgang -->
        <article class="project-card reveal" style="transition-delay:0.15s">
          <img src="images/yulgangonline.png" alt="Yulgang Online" class="project-banner">
          <div class="project-body">
            <div class="project-meta">
              <span class="project-tag"><?= t('proj_yg_tag1') ?></span>
              <span class="project-tag"><?= t('proj_yg_tag2') ?></span>
              <span class="project-tag tag-role"><?= t('proj_yg_tag3') ?></span>
            </div>
            <h3 class="project-title"><?= t('proj_yg_title') ?></h3>
            <p class="project-impact"><?= t('proj_yg_impact') ?></p>
            <p class="project-desc"><?= t('proj_yg_desc') ?></p>
            <div class="project-stats">
              <div class="project-stat"><span class="stat-badge">👥</span><span><?= t('proj_yg_stat1') ?></span></div>
              <div class="project-stat"><span class="stat-badge">📈</span><span><?= t('proj_yg_stat2') ?></span></div>
            </div>
            <div class="chips">
              <span class="chip"><?= t('chip_game_design') ?></span>
              <span class="chip"><?= t('chip_live_ops') ?></span>
              <span class="chip"><?= t('chip_economy') ?></span>
              <span class="chip"><?= t('chip_community') ?></span>
              <span class="chip"><?= t('chip_full_po') ?></span>
            </div>
            <a href="yulgang.php" class="project-link"><?= t('proj_yg_link') ?> <span class="arrow">→</span></a>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- ═══════ DESIGN THINKING ═══════ -->
  <section id="thinking">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span><?= t('think_label') ?></div>
      <h2 class="section-title reveal"><?= t('think_title_1') ?><br><em><?= t('think_title_2') ?></em></h2>
      <div class="thinking-grid">
        <div class="thinking-text reveal">
          <p class="thinking-lead"><?= t('think_lead') ?></p>
          <p><?= t('think_p1') ?></p>
          <p><?= t('think_p2') ?></p>
          <blockquote class="thinking-quote"><?= t('think_quote') ?></blockquote>
        </div>
        <div class="thinking-visual reveal" style="transition-delay:0.15s">
          <!--
            PLACEHOLDER: Design Artifact
            Gợi ý: Game Loop Diagram / Economy Flow Chart / System Map / Skill Tree
            Blur nhẹ nếu NDA
          -->
          <div class="ph thinking-artifact">
            <div class="ph-icon">📐</div>
            <div class="ph-title">Design Artifact</div>
            <div class="ph-hint">Game Loop Diagram / Economy Flow Chart /<br>System Map / Skill Tree / Balance Sheet<br>Blur nhẹ nếu NDA</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ JOURNEY + TRUST SIGNALS ═══════ -->
  <section id="journey">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span><?= t('journey_label') ?></div>
      <h2 class="section-title reveal"><?= t('journey_title_1') ?><br><em><?= t('journey_title_2') ?></em></h2>
      <p class="section-intro reveal"><?= t('journey_intro') ?></p>

      <div class="journey-timeline">

        <!-- 2017 -->
        <div class="j-item reveal">
          <div class="j-marker"><div class="j-dot"></div><div class="j-line"></div></div>
          <div class="j-content">
            <div class="j-header">
              <span class="j-year"><?= t('j1_year') ?></span>
              <div class="ph j-logo-ph"></div>
              <span class="j-company"><?= t('j1_company') ?></span>
            </div>
            <h3 class="j-title"><?= t('j1_title') ?></h3>
            <p class="j-desc"><?= t('j1_desc') ?></p>
            <div class="j-lesson">
              <span class="j-lesson-label"><?= t('j1_insight_label') ?></span>
              <?= t('j1_insight') ?>
            </div>
          </div>
        </div>

        <!-- 2018-2019 -->
        <div class="j-item reveal">
          <div class="j-marker"><div class="j-dot"></div><div class="j-line"></div></div>
          <div class="j-content">
            <div class="j-header">
              <span class="j-year"><?= t('j2_year') ?></span>
              <div class="ph j-logo-ph"></div>
              <span class="j-company"><?= t('j2_company') ?></span>
            </div>
            <h3 class="j-title"><?= t('j2_title') ?></h3>
            <p class="j-desc"><?= t('j2_desc') ?></p>
            <div class="j-achievements">
              <span class="j-badge">780 CCU</span>
              <span class="j-badge">RR7 65%</span>
              <span class="j-badge accent"><?= ($currentLang === 'vi') ? 'Thay đổi tư duy người chơi' : 'Shifted player mindset' ?></span>
            </div>
          </div>
        </div>

        <!-- 2020 -->
        <div class="j-item reveal">
          <div class="j-marker"><div class="j-dot"></div><div class="j-line"></div></div>
          <div class="j-content">
            <div class="j-header">
              <span class="j-year"><?= t('j3_year') ?></span>
              <div class="ph j-logo-ph"></div>
              <span class="j-company"><?= t('j3_company') ?></span>
            </div>
            <h3 class="j-title"><?= t('j3_title') ?></h3>
            <p class="j-desc"><?= t('j3_desc') ?></p>
            <div class="j-achievements">
              <span class="j-badge accent"><?= t('j3_badge1') ?></span>
              <span class="j-badge"><?= t('j3_badge2') ?></span>
              <span class="j-badge"><?= t('j3_badge3') ?></span>
              <span class="j-badge gold"><?= t('j3_badge4') ?></span>
            </div>
            <div class="j-achievement-photo">
              <img src="images/employeeOTY.png" alt="SohaGame Employee of the Year 2020" class="j-photo">
              <span class="j-photo-caption"><?= ($currentLang === 'vi') ? 'Vinh danh cá nhân xuất sắc & Team dự án — SohaGame 2020' : 'Outstanding Employee & Project Team Award — SohaGame 2020' ?></span>
            </div>
          </div>
        </div>

        <!-- 2021-2022 -->
        <div class="j-item reveal">
          <div class="j-marker"><div class="j-dot"></div><div class="j-line"></div></div>
          <div class="j-content">
            <div class="j-header">
              <span class="j-year"><?= t('j4_year') ?></span>
              <div class="ph j-logo-ph"></div>
              <span class="j-company"><?= t('j4_company') ?></span>
            </div>
            <h3 class="j-title"><?= t('j4_title') ?></h3>
            <p class="j-desc"><?= t('j4_desc') ?></p>
            <div class="j-achievements">
              <span class="j-badge gold"><?= t('j4_badge1') ?></span>
            </div>
          </div>
        </div>

        <!-- 2025 -->
        <div class="j-item j-item--current reveal">
          <div class="j-marker"><div class="j-dot j-dot--active"></div></div>
          <div class="j-content">
            <div class="j-header">
              <span class="j-year"><?= t('j5_year') ?></span>
              <div class="ph j-logo-ph"></div>
              <span class="j-company"><?= t('j5_company') ?></span>
            </div>
            <h3 class="j-title"><?= t('j5_title') ?></h3>
            <p class="j-desc"><?= t('j5_desc') ?></p>
            <div class="j-achievements">
              <span class="j-badge gold"><?= t('j5_badge1') ?></span>
              <span class="j-badge gold"><?= t('j5_badge2') ?></span>
              <span class="j-badge gold"><?= t('j5_badge3') ?></span>
            </div>
            <div class="j-achievement-photo">
              <img src="images/hattrick.png" alt="Vietnam Game Awards 2025 — Triple Win" class="j-photo">
              <span class="j-photo-caption"><?= ($currentLang === 'vi') ? '🏆 Hattrick Vietnam Game Awards 2025 — Game of the Year, Best Gameplay, Best Graphic Design' : '🏆 Vietnam Game Awards 2025 Triple Win — Game of the Year, Best Gameplay, Best Graphic Design' ?></span>
            </div>
          </div>
        </div>

      </div>

      <!-- Trust Signal Stats -->
      <div class="trust-stats reveal">
        <div class="trust-stat">
          <div class="trust-num" data-target="8">0</div>
          <div class="trust-label"><?= t('trust_years') ?></div>
        </div>
        <div class="trust-stat">
          <div class="trust-num" data-target="5">0</div>
          <div class="trust-label"><?= t('trust_companies') ?></div>
        </div>
        <div class="trust-stat">
          <div class="trust-num" data-target="780">0</div>
          <div class="trust-label"><?= t('trust_ccu') ?></div>
        </div>
        <div class="trust-stat">
          <div class="trust-num" data-target="3">0</div>
          <div class="trust-label"><?= t('trust_awards') ?></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ SKILLS & METHODS ═══════ -->
  <section id="skills">
    <div class="wrap">
      <div class="section-label"><span class="label-line"></span><?= t('skills_label') ?></div>
      <h2 class="section-title reveal"><?= t('skills_title_1') ?> <em><?= t('skills_title_2') ?></em></h2>
      <p class="section-intro reveal"><?= t('skills_intro') ?></p>
      <div class="skills-grid">
        <div class="skill-group reveal">
          <h3 class="skill-group-title">🎮 <?= t('skills_design') ?></h3>
          <div class="skill-tags">
            <span class="skill-tag">Gameplay Systems</span>
            <span class="skill-tag">Economy Design</span>
            <span class="skill-tag">Combat Balance</span>
            <span class="skill-tag">Content Design</span>
            <span class="skill-tag">UX/UI Wireframing</span>
            <span class="skill-tag">Progression Systems</span>
            <span class="skill-tag">Reward Design</span>
            <span class="skill-tag">Quest Design</span>
          </div>
        </div>
        <div class="skill-group reveal" style="transition-delay:0.1s">
          <h3 class="skill-group-title">📊 <?= t('skills_methods') ?></h3>
          <div class="skill-tags">
            <span class="skill-tag">Data Analysis</span>
            <span class="skill-tag">A/B Testing</span>
            <span class="skill-tag">Player Segmentation</span>
            <span class="skill-tag">Live-Ops Planning</span>
            <span class="skill-tag">Competitive Analysis</span>
            <span class="skill-tag">Post-Launch Tuning</span>
          </div>
        </div>
        <div class="skill-group reveal" style="transition-delay:0.2s">
          <h3 class="skill-group-title">🛠️ <?= t('skills_tools') ?></h3>
          <div class="skill-tags">
            <span class="skill-tag">Excel / Sheets (Advanced)</span>
            <span class="skill-tag">Figma</span>
            <span class="skill-tag">Miro</span>
            <span class="skill-tag">Confluence</span>
            <span class="skill-tag">JIRA</span>
            <span class="skill-tag">SQL</span>
          </div>
        </div>
        <div class="skill-group reveal" style="transition-delay:0.3s">
          <h3 class="skill-group-title">🌐 <?= t('skills_domains') ?></h3>
          <div class="skill-tags">
            <span class="skill-tag">MMORPG</span>
            <span class="skill-tag">RPG Mobile</span>
            <span class="skill-tag">PC-to-Mobile Adaptation</span>
            <span class="skill-tag">F2P Monetization</span>
            <span class="skill-tag">Private Server Management</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ COLLABORATION / SERVICES ═══════ -->
  <section id="collab">
    <div class="wrap">
      <div class="section-label" style="justify-content:center"><span class="label-line"></span><?= t('collab_label') ?></div>
      <h2 class="section-title reveal" style="text-align:center"><?= t('collab_title_1') ?><br><em><?= t('collab_title_2') ?></em></h2>
      <p class="collab-intro reveal"><?= t('collab_intro') ?></p>
      <div class="collab-grid">
        <div class="collab-card reveal">
          <div class="collab-icon">🎮</div>
          <h3><?= t('collab_c1_title') ?></h3>
          <p><?= t('collab_c1_desc') ?></p>
        </div>
        <div class="collab-card reveal" style="transition-delay:0.1s">
          <div class="collab-icon">⚖️</div>
          <h3><?= t('collab_c2_title') ?></h3>
          <p><?= t('collab_c2_desc') ?></p>
        </div>
        <div class="collab-card reveal" style="transition-delay:0.2s">
          <div class="collab-icon">📱</div>
          <h3><?= t('collab_c3_title') ?></h3>
          <p><?= t('collab_c3_desc') ?></p>
        </div>
        <div class="collab-card reveal" style="transition-delay:0.3s">
          <div class="collab-icon">🗺️</div>
          <h3><?= t('collab_c4_title') ?></h3>
          <p><?= t('collab_c4_desc') ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ CONTACT ═══════ -->
  <section id="contact">
    <div class="wrap">
      <div class="contact-inner reveal">
        <h2 class="contact-title"><?= t('contact_title_1') ?><br><?= t('contact_title_2') ?> <em><?= t('contact_title_3') ?></em>?</h2>
        <p class="contact-sub"><?= t('contact_sub') ?></p>
        <div class="contact-row">
          <a href="mailto:bachlapminh140395@gmail.com" class="btn btn-primary"><?= t('contact_email') ?></a>
          <a href="https://www.linkedin.com/in/minhbachlap" target="_blank" class="btn btn-ghost"><?= t('contact_linkedin') ?></a>
          <a href="https://zalo.me/0908992408" target="_blank" class="btn btn-ghost"><?= t('contact_zalo') ?></a>
          <a href="#" class="btn btn-ghost"><?= t('contact_cv') ?></a>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ FOOTER ═══════ -->
  <footer>
    <span><?= t('footer_copy') ?></span>
    <span><?= t('footer_tagline') ?></span>
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
    document.querySelectorAll('.reveal, .j-item').forEach(el => io.observe(el));

    // ═══════ Animated counters ═══════
    const cio = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (!e.isIntersecting) return;
        const el = e.target, target = +el.dataset.target;
        const duration = 1800, step = target / (duration / 16);
        let cur = 0;
        const tick = setInterval(() => {
          cur += step;
          if (cur >= target) { el.textContent = target + '+'; clearInterval(tick); }
          else el.textContent = Math.floor(cur);
        }, 16);
        cio.unobserve(el);
      });
    }, { threshold: 0.5 });
    document.querySelectorAll('.trust-num[data-target]').forEach(el => cio.observe(el));

    // ═══════ Active nav highlighting ═══════
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');
    const navObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          navLinks.forEach(link => {
            link.classList.toggle('active',
              link.getAttribute('href') === '#' + entry.target.id
            );
          });
        }
      });
    }, { threshold: 0.3, rootMargin: '-80px 0px -50% 0px' });
    sections.forEach(section => navObserver.observe(section));
  </script>
</body>
</html>
