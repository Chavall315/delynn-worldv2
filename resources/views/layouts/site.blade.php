<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Delynn World'))</title>
    <meta name="description" content="@yield('meta_description', 'Unofficial fansite for Adeline Wijaya — JKT48 Member. Explore gallery, timeline, and updates.')">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700|playfair-display:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── CSS Variables ────────────────────────────────── */
        :root {
            --nav-height: 68px;
            --pink:       #f472b6;
            --purple:     #c084fc;
            --pink-dim:   rgba(244,114,182,0.1);
            --glass-bg:   rgba(8,8,18,0.75);
            --border:     rgba(255,255,255,0.07);
        }

        /* ── Custom scrollbar ─────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #070712; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--pink), var(--purple));
            border-radius: 99px;
        }

        /* ── Navbar ───────────────────────────────────────── */
        #site-nav {
            position: fixed;
            inset-x: 0;
            top: 0;
            z-index: 100;
            width: 100%;
            height: var(--nav-height);
            display: flex;
            align-items: center;
            transition: background 0.4s ease, box-shadow 0.4s ease;
        }
        #site-nav.scrolled {
            background: var(--glass-bg);
            backdrop-filter: blur(22px) saturate(180%);
            -webkit-backdrop-filter: blur(22px) saturate(180%);
            box-shadow: 0 1px 0 var(--border), 0 8px 32px rgba(0,0,0,0.5);
        }
        .nav-inner {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        /* Logo */
        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            letter-spacing: 0.01em;
            position: relative;
            flex-shrink: 0;
        }
        .nav-logo .accent {
            background: linear-gradient(135deg, var(--pink) 0%, var(--purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-logo::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: linear-gradient(90deg, var(--pink), var(--purple));
            border-radius: 99px;
            transition: width 0.35s ease;
        }
        .nav-logo:hover::after { width: 100%; }

        /* Nav links list */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.15rem;
            list-style: none;
            margin: 0; padding: 0;
        }
        .nav-links a {
            position: relative;
            display: block;
            padding: 0.45rem 0.85rem;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            border-radius: 8px;
            transition: color 0.2s ease, background 0.2s ease;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 3px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 1.5px;
            background: linear-gradient(90deg, var(--pink), var(--purple));
            border-radius: 99px;
            transition: width 0.3s ease;
        }
        .nav-links a:hover {
            color: rgba(255,255,255,0.9);
            background: rgba(255,255,255,0.04);
        }
        .nav-links a:hover::after { width: calc(100% - 1.7rem); }
        .nav-links a.active { color: #fff; }
        .nav-links a.active::after {
            width: calc(100% - 1.7rem);
        }

        /* CTA button */
        .nav-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.42rem 1rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.65);
            border: 1px solid var(--border);
            border-radius: 99px;
            text-decoration: none;
            background: rgba(255,255,255,0.03);
            transition: color 0.2s ease, border-color 0.2s ease,
                        background 0.2s ease, box-shadow 0.2s ease;
            flex-shrink: 0;
        }
        .nav-cta:hover {
            color: #fff;
            border-color: rgba(244,114,182,0.45);
            background: var(--pink-dim);
            box-shadow: 0 0 18px rgba(244,114,182,0.12);
        }
        .nav-cta svg {
            width: 11px; height: 11px;
            opacity: 0.65; flex-shrink: 0;
        }

        /* Hamburger */
        #nav-toggle {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 40px; height: 40px;
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0;
            border-radius: 8px;
        }
        #nav-toggle span {
            display: block;
            width: 22px; height: 1.5px;
            background: rgba(255,255,255,0.55);
            border-radius: 99px;
            transform-origin: center;
            transition: transform 0.35s ease, opacity 0.3s ease, background 0.2s ease;
        }
        #nav-toggle:hover span { background: #fff; }
        #nav-toggle.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
        #nav-toggle.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        #nav-toggle.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

        /* Mobile menu */
        #mobile-menu {
            position: fixed;
            inset-x: 0;
            top: var(--nav-height);
            z-index: 99;
            background: rgba(6,6,16,0.97);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            transform: translateY(-10px);
            opacity: 0;
            pointer-events: none;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
        }
        #mobile-menu.open {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }
        .mob-link {
            display: block;
            padding: 0.8rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            border-radius: 10px;
            border: 1px solid transparent;
            transition: color 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }
        .mob-link:hover, .mob-link.active {
            color: #fff;
            background: rgba(244,114,182,0.07);
            border-color: rgba(244,114,182,0.2);
        }
        .mob-divider {
            height: 1px;
            background: var(--border);
            margin: 0.5rem 0;
        }
        .mob-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.8rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: rgba(255,255,255,0.03);
            margin-top: 0.2rem;
            transition: color 0.2s ease, border-color 0.2s ease, background 0.2s ease;
        }
        .mob-cta:hover {
            color: #fff;
            border-color: rgba(244,114,182,0.4);
            background: var(--pink-dim);
        }

        /* Page progress bar */
        #scroll-progress {
            position: fixed;
            top: 0; left: 0;
            width: 0%;
            height: 2px;
            background: linear-gradient(90deg, var(--pink), var(--purple), #818cf8);
            z-index: 200;
            border-radius: 0 99px 99px 0;
            transition: width 0.08s linear;
        }

        /* ── Footer ───────────────────────────────────────── */
        #site-footer {
            position: relative;
            overflow: hidden;
            border-top: 1px solid var(--border);
            background: #06060f;
            padding: 4rem 1.75rem 2.25rem;
        }
        #site-footer::before {
            content: '';
            position: absolute;
            bottom: -100px; left: 50%;
            transform: translateX(-50%);
            width: 700px; height: 280px;
            background: radial-gradient(ellipse, rgba(244,114,182,0.065) 0%, transparent 70%);
            pointer-events: none;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        /* Footer 3-column grid */
        .footer-top {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1.4fr;
            gap: 2.5rem;
            align-items: start;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .footer-social {
            display: flex;
            gap: 0.6rem;
            margin-top: 1.1rem;
        }
        .footer-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px; height: 34px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.03);
            color: rgba(255,255,255,0.45);
            transition: color 0.2s ease, border-color 0.2s ease, background 0.2s ease, transform 0.2s ease;
        }
        .footer-social a:hover {
            color: var(--pink);
            border-color: rgba(244,114,182,0.35);
            background: var(--pink-dim);
            transform: translateY(-2px);
        }
        .footer-social svg { width: 15px; height: 15px; }

        .footer-bio-role .team-dot {
            display: inline-block;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #22d3ee;
            margin-right: 5px;
        }

        .footer-bio-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.2rem;
        }
        .footer-bio-name .accent {
            background: linear-gradient(135deg, var(--pink), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .footer-bio-role {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--pink);
            opacity: 0.75;
            margin-bottom: 1rem;
        }
        .footer-bio-table {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }
        .footer-bio-row {
            display: flex;
            gap: 0.6rem;
            align-items: baseline;
        }
        .footer-bio-key {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.22);
            min-width: 80px;
            flex-shrink: 0;
        }
        .footer-bio-val {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.5;
        }

        /* Center col: Explore */
        .footer-col-center {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .footer-nav-label {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.22);
            margin-bottom: 1rem;
        }
        .footer-nav-list {
            list-style: none;
            margin: 0; padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
            align-items: center;
        }
        .footer-nav-list a {
            font-size: 0.82rem;
            font-weight: 500;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            letter-spacing: 0.03em;
            transition: color 0.2s ease;
        }
        .footer-nav-list a:hover { color: var(--pink); }

        /* Right col */
        .footer-col-right {
            text-align: left;
        }
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            font-weight: 700;
            color: #fff;
            display: block;
            margin-bottom: 0.6rem;
            text-decoration: none;
        }
        .footer-logo .accent {
            background: linear-gradient(135deg, var(--pink), var(--purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .footer-tagline {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.28);
            line-height: 1.7;
        }

        /* Bottom bar */
        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .footer-copy {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.18);
            letter-spacing: 0.025em;
            line-height: 1.6;
        }
        .footer-copy strong { color: rgba(255,255,255,0.3); font-weight: 500; }
        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.28rem 0.72rem;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(244,114,182,0.65);
            border: 1px solid rgba(244,114,182,0.18);
            border-radius: 99px;
            background: rgba(244,114,182,0.05);
        }
        .badge-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--pink);
            animation: blink-dot 2.2s ease-in-out infinite;
        }
        @keyframes blink-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.35; transform: scale(0.65); }
        }

        /* ── Responsive ───────────────────────────────────── */
        @media (max-width: 768px) {
            .nav-links, .nav-cta { display: none !important; }
            #nav-toggle { display: flex; }
            .footer-top {
                grid-template-columns: 1fr;
                gap: 2.25rem;
            }
            .footer-col-center { align-items: flex-start; }
            .footer-nav-list { align-items: flex-start; }
        }

        /* ── Smooth page load ─────────────────────────────── */
        main { animation: pageIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Masonry Gallery ──────────────────────────────── */
        .masonry-gallery {
            column-count: 2;
            column-gap: 1rem;
        }
        @media (min-width: 640px)  { .masonry-gallery { column-count: 3; } }
        @media (min-width: 1024px) { .masonry-gallery { column-count: 4; } }

        .masonry-item {
            position: relative;
            break-inside: avoid;
            margin-bottom: 1rem;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border);
        }
        .masonry-item img {
            display: block;
            width: 100%;
            height: auto;
            transition: transform 0.4s ease, filter 0.3s ease;
        }
        .masonry-item:hover img {
            transform: scale(1.03);
            filter: brightness(0.55);
        }

        .masonry-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-end;
            padding: 1rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 60%);
            pointer-events: none;
        }
        .masonry-item:hover .masonry-overlay {
            opacity: 1;
        }
        .masonry-overlay p {
            color: #fff;
            font-size: 0.85rem;
            font-weight: 500;
            line-height: 1.4;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-950 text-gray-200">
    <div id="scroll-progress"></div>
    <nav id="site-nav" aria-label="Main navigation">
        <div class="nav-inner">

            <a href="{{ route('home') }}" class="nav-logo">
                Delynn <span class="accent">World</span>
            </a>

            @php
                $navLinks = [
                    ['route' => 'home',     'label' => 'Home'],
                    ['route' => 'gallery',  'label' => 'Gallery'],
                    ['route' => 'timeline', 'label' => 'Timeline'],
                    ['route' => 'updates',  'label' => 'Updates'],
                ];
            @endphp

            <ul class="nav-links">
                @foreach ($navLinks as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                           class="{{ request()->routeIs($link['route']) ? 'active' : '' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            @auth
                <a href="{{ route('connect') }}" class="nav-cta">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M2 2h5v5H2V2zm7 0h5v5H9V2zM2 9h5v5H2V9zm7 0h5v5H9V9z"/>
                    </svg>
                    Fan Connect
                </a>
            @else
                <a href="{{ route('connect') }}" class="nav-cta">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 1a2 2 0 1 1 0 4A2 2 0 0 1 8 1ZM3 7a2 2 0 1 1 0 4A2 2 0 0 1 3 7Zm10 0a2 2 0 1 1 0 4 2 2 0 0 1 0-4ZM5.5 8.5a2.5 2.5 0 0 0-4.5 0H.5v.5A2.5 2.5 0 0 0 5 11.5h.017A3 3 0 0 1 5.5 10v-.5Zm9.5 0a2.5 2.5 0 0 0-4.5 0v.5A3 3 0 0 1 10.983 11.5H11A2.5 2.5 0 0 0 13.5 9v-.5h-1.5Zm-5-1.75A3 3 0 0 0 7 9.5v.5h2v-.5a3 3 0 0 0-3-3v-.75Z"/>
                    </svg>
                    Fan Connect
                </a>
            @endauth

            <button id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </nav>
    <div id="mobile-menu" role="dialog" aria-modal="true">
        @foreach ($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="mob-link {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                {{ $link['label'] }}
            </a>
        @endforeach
        <div class="mob-divider"></div>
        @auth
            <a href="{{ route('dashboard') }}" class="mob-cta">Dashboard</a>
        @else
            <a href="{{ route('connect') }}" class="mob-cta">Fan Connect</a>
        @endauth
    </div>
    <main style="padding-top: var(--nav-height);">
        @yield('content')
    </main>
    <footer id="site-footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div>
                    <a href="{{ route('home') }}" class="footer-logo">
                        Delynn <span class="accent">World</span>
                    </a>
                    <p class="footer-tagline">
                        Unofficial fan space dedicated to Adeline Wijaya — JKT48 member.
                        Celebrating her journey through photos, stories, and memories.
                    </p>
                </div>
                <div class="footer-col-center">
                    <p class="footer-nav-label">Explore</p>
                    <ul class="footer-nav-list">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('timeline') }}">Timeline</a></li>
                        <li><a href="{{ route('updates') }}">Updates</a></li>
                        <li><a href="{{ route('connect') }}">Connect</a></li>
                    </ul>
                </div>

                <div class="footer-col-right">
                <p class="footer-bio-name">Adeline <span class="accent">Wijaya</span></p>
                <p class="footer-bio-role"><span class="team-dot"></span>JKT48 — Team Dream</p>
                <div class="footer-bio-table">
                    <div class="footer-bio-row">
                        <span class="footer-bio-key">Nama</span>
                        <span class="footer-bio-val">Adeline Wijaya</span>
                    </div>
                    <div class="footer-bio-row">
                        <span class="footer-bio-key">Panggilan</span>
                        <span class="footer-bio-val">Delynn</span>
                    </div>
                    <div class="footer-bio-row">
                        <span class="footer-bio-key">Lahir</span>
                        <span class="footer-bio-val">1 September 2007</span>
                    </div>
                    <div class="footer-bio-row">
                        <span class="footer-bio-key">Asal</span>
                        <span class="footer-bio-val">Jakarta, Indonesia</span>
                    </div>
                    <div class="footer-bio-row">
                        <span class="footer-bio-key">Tinggi</span>
                        <span class="footer-bio-val">167 cm</span>
                    </div>
                    <div class="footer-bio-row">
                        <span class="footer-bio-key">Gol. Darah</span>
                        <span class="footer-bio-val">B</span>
                    </div>
                    <div class="footer-bio-row">
                        <span class="footer-bio-key">Generasi</span>
                        <span class="footer-bio-val">Generasi 12 JKT48</span>
                    </div>
                </div>
                <div class="footer-social">
                    <a href="https://instagram.com/jkt48.delynn" target="_blank" rel="noopener" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                    </a>
                    <a href="https://x.com/Delynn_JKT48" target="_blank" rel="noopener" aria-label="X">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 2H22l-7.6 8.7L23.3 22h-7.1l-5.5-7.2L4.4 22H1.3l8.1-9.3L1 2h7.3l5 6.6L18.9 2Zm-1.2 18h1.7L7.4 4H5.6l12.1 16Z"/></svg>
                    </a>
                    <a href="https://tiktok.com/@jkt48.delynn" target="_blank" rel="noopener" aria-label="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16.6 5.82c-.9-.99-1.4-2.27-1.4-3.63h-3.45v13.6a2.7 2.7 0 1 1-1.9-2.58V9.2a6.16 6.16 0 1 0 5.35 6.1V9.94a7.6 7.6 0 0 0 4.4 1.4V7.87c-.94 0-1.86-.29-2.63-.82a5.4 5.4 0 0 1-.37-1.23Z"/></svg>
                    </a>
                </div>
            </div>

            </div>
            <div class="footer-bottom">
                <p class="footer-copy">
                    &copy; {{ date('Y') }} <strong>Delynn World</strong> &mdash;
                    Unofficial fansite.
                </p>
                <span class="footer-badge">
                    <span class="badge-dot"></span>
                    Fan Project
                </span>
            </div>
        </div>
    </footer>
    <script>
        const nav  = document.getElementById('site-nav');
        const prog = document.getElementById('scroll-progress');

        function onScroll() {
            const scrolled  = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            nav.classList.toggle('scrolled', scrolled > 20);
            if (docHeight > 0) prog.style.width = (scrolled / docHeight * 100) + '%';
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        const toggle = document.getElementById('nav-toggle');
        const mMenu  = document.getElementById('mobile-menu');

        toggle.addEventListener('click', () => {
            const open = mMenu.classList.toggle('open');
            toggle.classList.toggle('open', open);
            toggle.setAttribute('aria-expanded', open);
            document.body.style.overflow = open ? 'hidden' : '';
        });

        mMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                mMenu.classList.remove('open');
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });

        document.addEventListener('click', e => {
            if (!nav.contains(e.target) && !mMenu.contains(e.target)) {
                mMenu.classList.remove('open');
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });
    </script>

</body>
</html>