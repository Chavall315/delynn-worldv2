<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moderasi Foto Gallery
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Menunggu Approval --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Menunggu Approval ({{ $pending->count() }})</h3>

                @if ($pending->isEmpty())
                    <p class="text-gray-500 text-sm">Gak ada foto yang nunggu review.</p>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($pending as $photo)
                        <div class="border rounded overflow-hidden">
                            <img src="{{ $photo->url }}" alt="{{ $photo->caption }}" class="w-full h-32 object-cover">
                            @if ($photo->caption)
                                <p class="text-xs p-2 text-gray-600">{{ $photo->caption }}</p>
                            @endif
                            <div class="flex gap-2 p-2">
                                <form action="{{ route('admin.photos.approve', $photo) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full bg-green-600 text-white text-xs py-1 rounded hover:bg-green-700">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('admin.photos.reject', $photo) }}" method="POST" class="flex-1"
                                      onsubmit="return confirm('Tolak & hapus foto ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full bg-red-600 text-white text-xs py-1 rounded hover:bg-red-700">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Sudah Tayang --}}
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Sudah Tayang ({{ $approved->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($approved as $photo)
                        <div class="relative group">
                            <img src="{{ $photo->url }}" alt="{{ $photo->caption }}" class="w-full h-32 object-cover rounded">
                            <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST"
                                  onsubmit="return confirm('Yakin mau hapus foto ini?')"
                                  class="absolute top-1 right-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>