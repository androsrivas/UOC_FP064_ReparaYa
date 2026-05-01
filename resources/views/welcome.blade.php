<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa — Gestió professional d'avaries</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue-50: #E6F1FB;
            --blue-400: #378ADD;
            --blue-600: #185FA5;
            --blue-800: #0C447C;
            --blue-900: #042C53;
            --teal-50: #E1F5EE;
            --teal-400: #1D9E75;
            --teal-600: #0F6E56;
            --coral-50: #FAECE7;
            --coral-400: #D85A30;
            --gray-50: #F1EFE8;
            --gray-100: #D3D1C7;
            --gray-400: #888780;
            --gray-800: #444441;
            --gray-900: #2C2C2A;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #fff;
            color: var(--gray-900);
            overflow-x: hidden;
        }

        h1, h2, h3 {
            font-family: 'DM Serif Display', serif;
        }

        /* ── NAVBAR ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            height: 64px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(8px);
            border-bottom: 0.5px solid var(--gray-100);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--blue-900);
            text-decoration: none;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--blue-600);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-links a {
            font-size: 14px;
            color: var(--gray-400);
            text-decoration: none;
            transition: color .2s;
        }

        .nav-links a:hover { color: var(--blue-600); }

        .nav-cta {
            display: flex;
            gap: 10px;
        }

        .btn-outline {
            padding: 8px 18px;
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-800);
            text-decoration: none;
            transition: all .2s;
            background: white;
        }

        .btn-outline:hover {
            border-color: var(--blue-400);
            color: var(--blue-600);
        }

        .btn-primary {
            padding: 8px 18px;
            background: var(--blue-600);
            border: 1px solid var(--blue-600);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: white;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-primary:hover { background: var(--blue-800); border-color: var(--blue-800); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            padding: 120px 5% 80px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -200px; right: -200px;
            width: 700px; height: 700px;
            background: radial-gradient(circle, var(--blue-50) 0%, transparent 70%);
            z-index: 0;
        }

        .hero-content { position: relative; z-index: 1; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: var(--teal-50);
            border: 1px solid #9FE1CB;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: var(--teal-600);
            margin-bottom: 24px;
        }

        .hero-badge span { width: 6px; height: 6px; background: var(--teal-400); border-radius: 50%; display: inline-block; }

        .hero h1 {
            font-size: clamp(40px, 5vw, 60px);
            line-height: 1.1;
            color: var(--blue-900);
            margin-bottom: 20px;
        }

        .hero h1 em {
            font-style: italic;
            color: var(--blue-600);
        }

        .hero p {
            font-size: 17px;
            line-height: 1.7;
            color: var(--gray-400);
            max-width: 480px;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            padding: 14px 28px;
            background: var(--blue-600);
            color: white;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            border: 1px solid var(--blue-600);
        }

        .btn-hero-primary:hover { background: var(--blue-800); border-color: var(--blue-800); transform: translateY(-1px); }

        .btn-hero-secondary {
            padding: 14px 28px;
            background: white;
            color: var(--blue-600);
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            border: 1px solid var(--gray-100);
        }

        .btn-hero-secondary:hover { border-color: var(--blue-400); transform: translateY(-1px); }

        /* ── HERO VISUAL ── */
        .hero-visual {
            position: relative;
            z-index: 1;
        }

        .dashboard-card {
            background: white;
            border: 0.5px solid var(--gray-100);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 60px rgba(4,44,83,0.08);
        }

        .dash-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .dash-title { font-size: 14px; font-weight: 500; color: var(--gray-800); font-family: 'DM Sans', sans-serif; }
        .dash-badge { font-size: 11px; padding: 3px 8px; background: var(--teal-50); color: var(--teal-600); border-radius: 6px; font-weight: 500; }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-mini {
            background: var(--gray-50);
            border-radius: 10px;
            padding: 12px;
        }

        .stat-mini .num { font-size: 22px; font-family: 'DM Serif Display', serif; color: var(--blue-900); line-height: 1; margin-bottom: 4px; }
        .stat-mini .lbl { font-size: 11px; color: var(--gray-400); }

        .incident-list { display: flex; flex-direction: column; gap: 8px; }

        .incident-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 0.5px solid var(--gray-50);
            border-radius: 10px;
        }

        .inc-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .inc-info { flex: 1; }
        .inc-name { font-size: 13px; font-weight: 500; color: var(--gray-800); }
        .inc-addr { font-size: 11px; color: var(--gray-400); margin-top: 1px; }
        .inc-tag { font-size: 10px; padding: 2px 7px; border-radius: 5px; font-weight: 500; }

        .floating-card {
            position: absolute;
            background: white;
            border: 0.5px solid var(--gray-100);
            border-radius: 12px;
            padding: 12px 16px;
            box-shadow: 0 10px 30px rgba(4,44,83,0.1);
            font-size: 12px;
        }

        .fc-bottom {
            bottom: -24px;
            left: -32px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .fc-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px; }

        /* ── STATS STRIP ── */
        .stats-strip {
            background: var(--blue-900);
            padding: 48px 5%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            text-align: center;
        }

        .stat-big .num {
            font-family: 'DM Serif Display', serif;
            font-size: 42px;
            color: white;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-big .lbl {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
        }

        /* ── SERVICES ── */
        .section {
            padding: 96px 5%;
        }

        .section-label {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--blue-400);
            margin-bottom: 12px;
        }

        .section-title {
            font-size: clamp(28px, 3.5vw, 42px);
            color: var(--blue-900);
            line-height: 1.15;
            margin-bottom: 16px;
        }

        .section-sub {
            font-size: 16px;
            color: var(--gray-400);
            max-width: 520px;
            line-height: 1.7;
            margin-bottom: 56px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .service-card {
            border: 0.5px solid var(--gray-100);
            border-radius: 14px;
            padding: 28px 24px;
            background: white;
            transition: all .2s;
        }

        .service-card:hover {
            border-color: var(--blue-400);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(55,138,221,0.1);
        }

        .service-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .service-card h3 {
            font-size: 16px;
            font-family: 'DM Serif Display', serif;
            color: var(--blue-900);
            margin-bottom: 8px;
        }

        .service-card p {
            font-size: 13px;
            color: var(--gray-400);
            line-height: 1.6;
        }

        /* ── HOW IT WORKS ── */
        .how-section {
            padding: 96px 5%;
            background: var(--gray-50);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 32px;
            position: relative;
        }

        .step {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .step-num {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--blue-600);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
        }

        .step h3 {
            font-size: 17px;
            color: var(--blue-900);
        }

        .step p {
            font-size: 14px;
            color: var(--gray-400);
            line-height: 1.6;
        }

        /* ── ROLES ── */
        .roles-section {
            padding: 96px 5%;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .role-card {
            border-radius: 16px;
            padding: 32px 28px;
        }

        .role-card.admin    { background: var(--blue-50); border: 1px solid #B5D4F4; }
        .role-card.client   { background: var(--teal-50); border: 1px solid #9FE1CB; }
        .role-card.tecnic   { background: var(--gray-50); border: 1px solid var(--gray-100); }
        .role-card.gestora  { background: var(--coral-50); border: 1px solid #F5C4B3; }

        .role-emoji { font-size: 28px; margin-bottom: 14px; }

        .role-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .role-card.admin h3  { color: var(--blue-800); }
        .role-card.client h3 { color: var(--teal-600); }
        .role-card.tecnic h3 { color: var(--gray-800); }
        .role-card.gestora h3{ color: var(--coral-400); }

        .role-card p {
            font-size: 13px;
            line-height: 1.65;
        }

        .role-card.admin p  { color: var(--blue-600); }
        .role-card.client p { color: var(--teal-600); }
        .role-card.tecnic p { color: var(--gray-400); }
        .role-card.gestora p{ color: #993C1D; }

        /* ── CTA ── */
        .cta-section {
            padding: 96px 5%;
            background: var(--blue-900);
            text-align: center;
        }

        .cta-section h2 {
            font-size: clamp(30px, 4vw, 48px);
            color: white;
            margin-bottom: 16px;
            line-height: 1.15;
        }

        .cta-section p {
            font-size: 16px;
            color: rgba(255,255,255,0.55);
            margin-bottom: 40px;
        }

        .cta-buttons {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-cta-primary {
            padding: 14px 32px;
            background: white;
            color: var(--blue-800);
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-cta-primary:hover { background: var(--blue-50); transform: translateY(-1px); }

        .btn-cta-outline {
            padding: 14px 32px;
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-cta-outline:hover { border-color: rgba(255,255,255,0.55); transform: translateY(-1px); }

        /* ── FOOTER ── */
        footer {
            background: var(--gray-900);
            padding: 48px 5% 32px;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .footer-logo {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-tagline {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            margin-top: 6px;
        }

        .footer-links h4 {
            font-size: 12px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 12px;
        }

        .footer-links ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }

        .footer-links a {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color .2s;
        }

        .footer-links a:hover { color: white; }

        .footer-bottom {
            border-top: 0.5px solid rgba(255,255,255,0.1);
            padding-top: 24px;
            font-size: 12px;
            color: rgba(255,255,255,0.25);
            text-align: center;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .hero { grid-template-columns: 1fr; padding-top: 100px; }
            .hero-visual { display: none; }
            .stats-strip { grid-template-columns: repeat(2, 1fr); }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav>
    <a href="{{ url('/') }}" class="logo">
        <div class="logo-icon">🔧</div>
        ReparaYa
    </a>
    <ul class="nav-links">
        <li><a href="#serveis">Serveis</a></li>
        <li><a href="#com-funciona">Com funciona</a></li>
        <li><a href="#rols">Per a qui</a></li>
    </ul>
    <div class="nav-cta">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-primary">El meu panell</a>
        @else
            <a href="{{ route('login') }}" class="btn-outline">Iniciar sessió</a>
            <a href="{{ route('register') }}" class="btn-primary">Registrar-se</a>
        @endauth
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            <span></span> Plataforma professional d'avaries
        </div>

        <h1>
            La teva avaria,<br>
            <em>resolta avui</em>
        </h1>

        <p>
            Fontaneria, electricitat, fusteria i molt més.
            Sol·licita un tècnic en minuts i segueix el teu servei en temps real.
        </p>

        <div class="hero-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-hero-primary">Accedir al panell</a>
            @else
                <a href="{{ route('register') }}" class="btn-hero-primary">Demanar un tècnic</a>
                <a href="{{ route('login') }}" class="btn-hero-secondary">Ja tinc compte</a>
            @endauth
        </div>
    </div>

    {{-- Mini dashboard de mostra --}}
    <div class="hero-visual">
        <div style="position: relative; padding: 20px;">
            <div class="dashboard-card">
                <div class="dash-header">
                    <span class="dash-title">Incidències actives</span>
                    <span class="dash-badge">En viu</span>
                </div>

                <div class="stats-row">
                    <div class="stat-mini">
                        <div class="num">24</div>
                        <div class="lbl">Pendents</div>
                    </div>
                    <div class="stat-mini">
                        <div class="num">8</div>
                        <div class="lbl">Urgents</div>
                    </div>
                    <div class="stat-mini">
                        <div class="num">142</div>
                        <div class="lbl">Aquest mes</div>
                    </div>
                </div>

                <div class="incident-list">
                    <div class="incident-row">
                        <div class="inc-dot" style="background: var(--coral-400);"></div>
                        <div class="inc-info">
                            <div class="inc-name">Fuita d'aigua</div>
                            <div class="inc-addr">C/ Major, 14 — Eixample</div>
                        </div>
                        <span class="inc-tag" style="background: var(--coral-50); color: var(--coral-400);">Urgent</span>
                    </div>
                    <div class="incident-row">
                        <div class="inc-dot" style="background: var(--blue-400);"></div>
                        <div class="inc-info">
                            <div class="inc-name">Instal·lació elèctrica</div>
                            <div class="inc-addr">Av. Diagonal, 88 — Gràcia</div>
                        </div>
                        <span class="inc-tag" style="background: var(--blue-50); color: var(--blue-600);">Estàndard</span>
                    </div>
                    <div class="incident-row">
                        <div class="inc-dot" style="background: var(--teal-400);"></div>
                        <div class="inc-info">
                            <div class="inc-name">Reparació fusteria</div>
                            <div class="inc-addr">C/ Balmes, 201 — Sarrià</div>
                        </div>
                        <span class="inc-tag" style="background: var(--teal-50); color: var(--teal-600);">Assignada</span>
                    </div>
                </div>
            </div>

            {{-- Floating card --}}
            <div class="floating-card fc-bottom">
                <div class="fc-icon" style="background: var(--teal-50); font-size: 16px;">✅</div>
                <div>
                    <div style="font-weight: 500; color: var(--gray-800); font-size: 12px;">Servei finalitzat</div>
                    <div style="color: var(--gray-400); font-size: 11px; margin-top: 1px;">REP-2026-0041 — fa 2 min</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<div class="stats-strip">
    <div class="stat-big">
        <div class="num">+2.400</div>
        <div class="lbl">Serveis realitzats</div>
    </div>
    <div class="stat-big">
        <div class="num">98%</div>
        <div class="lbl">Clients satisfets</div>
    </div>
    <div class="stat-big">
        <div class="num">48h</div>
        <div class="lbl">Temps màxim resposta</div>
    </div>
    <div class="stat-big">
        <div class="num">12</div>
        <div class="lbl">Zones cobertes</div>
    </div>
</div>

{{-- SERVEIS --}}
<section class="section" id="serveis">
    <div class="section-label">Els nostres serveis</div>
    <h2 class="section-title">Tot el que necessites,<br>en un sol lloc</h2>
    <p class="section-sub">
        Des de petites reparacions fins a instal·lacions complexes.
        Tècnics certificats disponibles les 24 hores per a urgències.
    </p>

    <div class="services-grid">
        <div class="service-card">
            <div class="service-icon" style="background: var(--blue-50);">🔧</div>
            <h3>Fontaneria</h3>
            <p>Fuites, instal·lació, canvis de canonades i reparació de sanitaris.</p>
        </div>
        <div class="service-card">
            <div class="service-icon" style="background: #FFFBEA;">⚡</div>
            <h3>Electricitat</h3>
            <p>Quadres elèctrics, instal·lacions, avaries i certificats d'habitabilitat.</p>
        </div>
        <div class="service-card">
            <div class="service-icon" style="background: var(--teal-50);">🚪</div>
            <h3>Fusteria</h3>
            <p>Reparació de portes, finestres, mobles i instal·lació de persianes.</p>
        </div>
        <div class="service-card">
            <div class="service-icon" style="background: var(--coral-50);">🎨</div>
            <h3>Pintura</h3>
            <p>Pintura interior i exterior, gotelé, arrebossat i tractaments especials.</p>
        </div>
        <div class="service-card">
            <div class="service-icon" style="background: var(--gray-50);">❄️</div>
            <h3>Climatització</h3>
            <p>Instal·lació i manteniment d'aire condicionat i calefacció.</p>
        </div>
        <div class="service-card">
            <div class="service-icon" style="background: #FFF5F0;">🏗️</div>
            <h3>Obres menors</h3>
            <p>Reformes, alicatat, paviments i adequació d'espais interiors.</p>
        </div>
    </div>
</section>

{{-- COM FUNCIONA --}}
<section class="how-section" id="com-funciona">
    <div style="max-width: 640px; margin: 0 auto 56px;">
        <div class="section-label">Com funciona</div>
        <h2 class="section-title">De la incidència<br>a la solució</h2>
    </div>

    <div class="steps-grid">
        <div class="step">
            <div class="step-num">1</div>
            <h3>Sol·licita el servei</h3>
            <p>Omple el formulari indicant el tipus d'avaria, la direcció i la franja horària preferida.</p>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <h3>Assignem un tècnic</h3>
            <p>El nostre administrador assigna el millor tècnic disponible per a la teva especialitat.</p>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <h3>Rep confirmació</h3>
            <p>Reps el codi d'incidència i pots consultar l'estat del teu servei en tot moment.</p>
        </div>
        <div class="step">
            <div class="step-num">4</div>
            <h3>Problema resolt</h3>
            <p>El tècnic realitza la reparació. El servei queda registrat al teu historial.</p>
        </div>
    </div>
</section>

{{-- ROLS --}}
<section class="roles-section" id="rols">
    <div class="section-label">Per a qui</div>
    <h2 class="section-title">Una plataforma,<br>múltiples perfils</h2>
    <p class="section-sub">Cada usuari té el seu propi espai adaptat a les seves necessitats.</p>

    <div class="roles-grid">
        <div class="role-card admin">
            <div class="role-emoji">👨‍💼</div>
            <h3>Administrador</h3>
            <p>Gestió completa d'incidències, tècnics, especialitats i gestores. Calendari visual i liquidacions mensuals.</p>
        </div>
        <div class="role-card client">
            <div class="role-emoji">🏠</div>
            <h3>Client particular</h3>
            <p>Crea i segueix les teves sol·licituds. Historial complet de serveis i modificació de dades personals.</p>
        </div>
        <div class="role-card tecnic">
            <div class="role-emoji">🔨</div>
            <h3>Tècnic</h3>
            <p>Consulta la teva agenda de treball diària, setmanal i mensual. Tots els detalls de cada servei assignat.</p>
        </div>
        <div class="role-card gestora">
            <div class="role-emoji">🏢</div>
            <h3>Administrador de finques</h3>
            <p>Crea avisos per a les teves comunitats i consulta les comissions acumulades mes a mes.</p>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <h2>Comença avui mateix</h2>
    <p>Registra't en menys d'un minut i sol·licita el teu primer servei sense compromís.</p>
    <div class="cta-buttons">
        @auth
            <a href="{{ route('dashboard') }}" class="btn-cta-primary">Accedir al panell</a>
        @else
            <a href="{{ route('register') }}" class="btn-cta-primary">Crear compte gratuït</a>
            <a href="{{ route('login') }}" class="btn-cta-outline">Iniciar sessió</a>
        @endauth
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="footer-top">
        <div>
            <a href="{{ url('/') }}" class="footer-logo">🔧 ReparaYa</a>
            <p class="footer-tagline">Gestió professional d'avaries domèstiques.</p>
        </div>
        <div class="footer-links">
            <h4>Plataforma</h4>
            <ul>
                <li><a href="{{ route('login') }}">Iniciar sessió</a></li>
                <li><a href="{{ route('register') }}">Registrar-se</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Serveis</h4>
            <ul>
                <li><a href="#serveis">Fontaneria</a></li>
                <li><a href="#serveis">Electricitat</a></li>
                <li><a href="#serveis">Fusteria</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h4>Empresa</h4>
            <ul>
                <li><a href="#com-funciona">Com funciona</a></li>
                <li><a href="#rols">Per a qui</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        © {{ date('Y') }} ReparaYa — Tots els drets reservats
    </div>
</footer>

</body>
</html>