@extends('layouts.site')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">

    <div class="mb-14 text-center">
        <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">
            Timeline <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">Delynn</span>
        </h1>
        <p class="text-gray-400">Perjalanan karier Delynn di JKT48, dari awal hingga sekarang.</p>
    </div>

    @if ($events->isEmpty())
        <div class="text-center py-16 rounded-2xl border border-dashed border-white/10">
            <p class="text-gray-500">Belum ada event yang ditambahkan.</p>
        </div>
    @else
        <div class="relative pl-10">
            {{-- garis vertikal --}}
            <div class="absolute left-[11px] top-2 bottom-2 w-px bg-gradient-to-b from-pink-500/60 via-purple-500/40 to-transparent"></div>

            @foreach ($events as $event)
                <div class="relative mb-12 last:mb-0">
                    {{-- titik --}}
                    <div class="absolute -left-10 top-1.5 w-[23px] h-[23px] rounded-full bg-gray-950 border-2 border-pink-500 flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-400 to-purple-400"></div>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-2xl p-6 hover:border-pink-500/30 transition-colors">
                        <p class="text-xs font-semibold tracking-widest uppercase text-pink-400 mb-2">
                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }}
                        </p>
                        <h3 class="text-lg font-semibold text-white mb-2">{{ $event->title }}</h3>

                        @if ($event->photo_url)
                            <img src="{{ $event->photo_url }}" alt="{{ $event->title }}" class="w-full max-h-80 object-cover rounded-xl mb-3">
                        @endif

                        @if ($event->description)
                            <p class="text-gray-400 text-sm leading-relaxed">{{ $event->description }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection