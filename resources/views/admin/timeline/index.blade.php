<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Timeline
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form Tambah Event --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Tambah Event Baru</h3>
                <form action="{{ route('admin.timeline.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">Judul</label>
                        <input type="text" name="title" required class="block w-full border-gray-300 rounded shadow-sm">
                        @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal</label>
                        <input type="date" name="event_date" required class="block w-full border-gray-300 rounded shadow-sm">
                        @error('event_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" class="block w-full border-gray-300 rounded shadow-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Foto (opsional)</label>
                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm">
                        @error('photo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Tambah Event
                    </button>
                </form>
            </div>

            {{-- List Event --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Semua Event ({{ $events->count() }})</h3>

                @if ($events->isEmpty())
                    <p class="text-gray-500 text-sm">Belum ada event.</p>
                @endif

                <div class="space-y-3">
                    @foreach ($events as $event)
                        <div x-data="{ editing: false }" class="border rounded-lg p-4">

                            {{-- Tampilan biasa --}}
                            <div x-show="!editing" class="flex items-start gap-4">
                                @if ($event->photo_url)
                                    <img src="{{ $event->photo_url }}" class="w-16 h-16 object-cover rounded flex-shrink-0">
                                @endif
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }}</p>
                                    <p class="font-medium">{{ $event->title }}</p>
                                    @if ($event->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $event->description }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-2 flex-shrink-0">
                                    <button @click="editing = true" class="text-xs bg-gray-200 px-3 py-1.5 rounded hover:bg-gray-300">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.timeline.destroy', $event) }}" method="POST"
                                          onsubmit="return confirm('Yakin mau hapus event ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs bg-red-600 text-white px-3 py-1.5 rounded hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Form edit --}}
                            <div x-show="editing" x-cloak>
                                <form action="{{ route('admin.timeline.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block text-xs font-medium mb-1">Judul</label>
                                        <input type="text" name="title" value="{{ $event->title }}" required class="block w-full border-gray-300 rounded shadow-sm text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1">Tanggal</label>
                                        <input type="date" name="event_date" value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}" required class="block w-full border-gray-300 rounded shadow-sm text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1">Deskripsi</label>
                                        <textarea name="description" rows="2" class="block w-full border-gray-300 rounded shadow-sm text-sm">{{ $event->description }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1">Ganti Foto (opsional)</label>
                                        <input type="file" name="photo" accept="image/*" class="block w-full text-xs">
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">
                                            Simpan
                                        </button>
                                        <button type="button" @click="editing = false" class="text-xs bg-gray-200 px-3 py-1.5 rounded hover:bg-gray-300">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>