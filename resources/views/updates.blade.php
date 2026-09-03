@extends('layouts.site')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-16">

    <div class="mb-14 text-center">
        <h1 class="text-4xl font-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">
            Jadwal <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">Theater</span>
        </h1>
        <p class="text-gray-400">Show JKT48 Theater yang ada Delynn-nya. Data dari JKT48Connect, update tiap 5 menit.</p>
    </div>

    @if (empty($shows))
        <div class="text-center py-16 rounded-2xl border border-dashed border-white/10">
            <p class="text-gray-500">Belum ada jadwal show Delynn dalam waktu dekat. Cek lagi nanti ya!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($shows as $show)
                <div class="rounded-2xl overflow-hidden border border-white/10 bg-white/5 hover:border-pink-500/30 transition-colors">
                    @if (!empty($show['banner']))
                        <img src="{{ $show['banner'] }}" alt="{{ $show['title'] }}" class="w-full h-48 object-cover">
                    @endif

                    <div class="p-6">
                        <p class="text-xs font-semibold tracking-widest uppercase text-pink-400 mb-2">
                            {{ \Carbon\Carbon::parse($show['date'])->translatedFormat('l, d F Y') }}
                        </p>
                        <h3 class="text-lg font-semibold text-white mb-3">{{ $show['title'] }}</h3>

                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($show['lineup'] as $member)
                                <span class="text-xs px-2.5 py-1 rounded-full {{ $member['name'] === 'Delynn' ? 'bg-pink-500/20 text-pink-300 border border-pink-500/30 font-semibold' : 'bg-white/5 text-gray-400 border border-white/10' }}">
                                    {{ $member['name'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection