@extends('layouts.site')

@section('title', 'Delynn World — Fansite Adeline Wijaya JKT48')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">

    {{-- Background gradient blobs --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-pink-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-600/15 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-fuchsia-500/10 rounded-full blur-3xl"></div>
    </div>

    {{-- Subtle grid pattern --}}
    <div class="absolute inset-0 z-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-pink-500/10 border border-pink-500/20 text-pink-400 text-xs font-semibold tracking-widest uppercase mb-8">
            <span class="w-1.5 h-1.5 rounded-full bg-pink-400 animate-pulse"></span>
            JKT48 — Gen. 12
        </div>

        {{-- Heading --}}
        <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6" style="font-family: 'Playfair Display', serif;">
            <span class="text-white">Selamat Datang</span><br>
            <span class="bg-gradient-to-r from-pink-400 via-fuchsia-400 to-purple-400 bg-clip-text text-transparent">
                di Delynn World
            </span>
        </h1>

        <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            Fansite unofficial untuk <span class="text-white font-medium">Adeline Wijaya</span> — Delynn,
            member JKT48 Generasi 12. Tempat berkumpulnya para fans setia Delynn.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('gallery') }}"
               class="px-8 py-3.5 rounded-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold text-sm shadow-xl shadow-pink-500/30 hover:shadow-pink-500/50 hover:scale-105 transition-all duration-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="m21 15-5-5L5 21"/><circle cx="8.5" cy="8.5" r="1.5"/></svg>
                Lihat Gallery
            </a>
            <a href="{{ route('timeline') }}"
               class="px-8 py-3.5 rounded-full border border-gray-700 text-gray-300 font-semibold text-sm hover:border-pink-400 hover:text-white transition-all duration-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Timeline Delynn
            </a>
        </div>

        {{-- Scroll hint --}}
        <div class="mt-16 flex flex-col items-center gap-2 text-gray-600">
            <span class="text-xs tracking-widest uppercase">Scroll</span>
            <div class="w-px h-8 bg-gradient-to-b from-gray-600 to-transparent animate-bounce"></div>
        </div>
    </div>
</section>

{{-- ===== QUICK STATS ===== --}}
<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $stats = [
                ['value' => '12', 'label' => 'Generasi JKT48', 'icon' => '✦'],
                ['value' => '2023', 'label' => 'Tahun Debut', 'icon' => '✦'],
                ['value' => '∞', 'label' => 'Fans Setia', 'icon' => '♥'],
                ['value' => '#1', 'label' => 'Di Hati Kita', 'icon' => '★'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-6 text-center hover:border-pink-500/30 hover:bg-gray-900/80 transition-all duration-300 group">
                <div class="text-pink-400 text-xs mb-2 group-hover:scale-110 transition-transform duration-300">{{ $stat['icon'] }}</div>
                <div class="text-3xl font-bold text-white mb-1">{{ $stat['value'] }}</div>
                <div class="text-gray-500 text-xs">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- ===== SECTION: EXPLORE ===== --}}
<section class="max-w-6xl mx-auto px-6 pb-20">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">Jelajahi Delynn World</h2>
        <p class="text-gray-500 text-sm">Semua yang kamu butuhkan tentang Delynn, ada di sini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- Gallery Card --}}
        <a href="{{ route('gallery') }}" class="group relative bg-gray-900/60 border border-gray-800 rounded-2xl p-7 hover:border-pink-500/40 hover:bg-gray-900 transition-all duration-300 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-pink-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="m21 15-5-5L5 21"/><circle cx="8.5" cy="8.5" r="1.5"/></svg>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Gallery</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Koleksi foto dan momen terbaik Delynn dari berbagai event JKT48.</p>
                <div class="mt-5 flex items-center gap-1.5 text-pink-400 text-sm font-medium">
                    Lihat semua
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
        </a>

        {{-- Timeline Card --}}
        <a href="{{ route('timeline') }}" class="group relative bg-gray-900/60 border border-gray-800 rounded-2xl p-7 hover:border-purple-500/40 hover:bg-gray-900 transition-all duration-300 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Timeline</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Perjalanan karier Delynn dari awal debut hingga sekarang secara kronologis.</p>
                <div class="mt-5 flex items-center gap-1.5 text-purple-400 text-sm font-medium">
                    Lihat timeline
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
        </a>

        {{-- Updates Card --}}
        <a href="{{ route('updates') }}" class="group relative bg-gray-900/60 border border-gray-800 rounded-2xl p-7 hover:border-fuchsia-500/40 hover:bg-gray-900 transition-all duration-300 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-fuchsia-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-fuchsia-500/10 border border-fuchsia-500/20 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-fuchsia-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-white font-semibold text-lg mb-2">Updates</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Update terbaru, jadwal theater, dan berita terkini seputar Delynn.</p>
                <div class="mt-5 flex items-center gap-1.5 text-fuchsia-400 text-sm font-medium">
                    Cek update
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>
        </a>
    </div>
</section>

{{-- ===== QUOTE / FAN SUPPORT BANNER ===== --}}
<section class="max-w-6xl mx-auto px-6 pb-24">
    <div class="relative rounded-3xl overflow-hidden border border-gray-800">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-500/10 via-purple-500/10 to-fuchsia-500/10"></div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-pink-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        <div class="relative z-10 px-8 py-14 text-center">
            <blockquote class="text-white text-xl md:text-2xl font-medium italic leading-relaxed max-w-2xl mx-auto mb-6" style="font-family: 'Playfair Display', serif;">
                "Terima kasih sudah selalu mendukung Delynn. Setiap aplikasi, setiap sorak, setiap doa — terasa sampai."
            </blockquote>
            <p class="text-gray-500 text-sm">— Dari para fans untuk Delynn </p>
            <a href="{{ route('connect') }}"
               class="mt-8 inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white/5 border border-white/10 text-gray-300 text-sm font-medium hover:bg-pink-500/15 hover:border-pink-500/30 hover:text-pink-400 transition-all duration-300">
                Bergabung dengan komunitas fans
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection