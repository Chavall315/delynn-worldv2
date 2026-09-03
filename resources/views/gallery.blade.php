@extends('layouts.site')

@section('content')
<div x-data="{ showModal: false, showToast: {{ session('success') ? 'true' : 'false' }} }" x-init="showToast && setTimeout(() => showToast = false, 4000)">
    <div x-show="showToast" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-6 right-6 z-[100] max-w-sm">
        <div class="flex items-start gap-3 bg-gray-900 border border-green-500/30 rounded-xl px-4 py-3 shadow-2xl shadow-black/50">
            <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-sm text-gray-200">{{ session('success') }}</p>
            <button @click="showToast = false" class="ml-auto text-gray-500 hover:text-white">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-16">
        <div class="mb-10 flex items-start justify-between gap-4 flex-wrap">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2">Gallery</h1>
                <p class="text-gray-400">
                    Bagikan momen kamu bareng <span class="text-pink-400 font-medium">Delynn</span>.
                    Foto akan tayang setelah disetujui admin.
                </p>
            </div>
            <button @click="showModal = true"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-400 hover:to-purple-500 text-white font-medium px-5 py-3 rounded-xl transition-all shadow-lg shadow-pink-500/20 hover:shadow-pink-500/30 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Foto
            </button>
        </div>

        <div class="flex items-center gap-2 mb-6">
            <div class="w-1.5 h-6 bg-pink-500 rounded-full"></div>
            <h2 class="text-lg font-semibold text-white">Kumpulan Pap Delynn</h2>
        </div>

        @if ($photos->isEmpty())
            <div class="text-center py-16 rounded-2xl border border-dashed border-white/10">
                <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 4.5h18M3.75 4.5v15a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-15" />
                </svg>
                <p class="text-gray-500">Belum ada foto yang tayang. Jadi yang pertama upload!</p>
            </div>
        @else
            <div class="masonry-gallery">
                @foreach ($photos as $photo)
                    <div class="masonry-item">
                        <img src="{{ $photo->url }}" alt="{{ $photo->caption }}" loading="lazy">
                        @if ($photo->caption)
                            <div class="masonry-overlay">
                                <p>{{ $photo->caption }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <div x-show="showModal" x-cloak class="fixed inset-0 z-[90] flex items-center justify-center p-4">
        <div @click="showModal = false"
             x-show="showModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

        <div x-show="showModal" x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-md rounded-2xl border border-white/10 bg-gray-900 p-8 overflow-hidden">

            <button @click="showModal = false" class="absolute top-4 right-4 text-gray-500 hover:text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="relative" x-data="{ fileName: null, previewUrl: null }">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-1.5 h-6 bg-pink-500 rounded-full"></div>
                    <h2 class="text-lg font-semibold text-white">Upload Foto</h2>
                </div>

                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Pilih Foto</label>

                        <label class="group flex items-center justify-center gap-3 w-full border-2 border-dashed border-white/15 hover:border-pink-500/50 rounded-xl px-4 py-8 cursor-pointer transition-colors bg-black/20">
                            <input type="file" name="photo" accept="image/*" required class="hidden"
                                   @change="fileName = $event.target.files[0]?.name; previewUrl = URL.createObjectURL($event.target.files[0])">

                            <template x-if="!previewUrl">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-500 group-hover:text-pink-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 16.5V9.75m0 0l-3 3m3-3l3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                    </svg>
                                    <p class="text-sm text-gray-400">
                                        <span class="text-pink-400 font-medium">Klik untuk pilih foto</span> atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-600 mt-1">PNG, JPG hingga 5MB</p>
                                </div>
                            </template>

                            <template x-if="previewUrl">
                                <div class="flex items-center gap-3">
                                    <img :src="previewUrl" class="w-16 h-16 object-cover rounded-lg">
                                    <span class="text-sm text-gray-300" x-text="fileName"></span>
                                </div>
                            </template>
                        </label>

                        @error('photo')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Caption (opsional)</label>
                        <input type="text" name="caption" maxlength="255" placeholder="Tulis caption di sini..." class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-pink-500/60 focus:ring-1 focus:ring-pink-500/60 transition-colors">
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-400 hover:to-purple-500 text-white font-medium px-6 py-3 rounded-xl transition-all shadow-lg shadow-pink-500/20 hover:shadow-pink-500/30">
                        Kirim untuk Direview
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection