<div align="center">

# 🌸 Delynn World

**Fan site pribadi untuk Delynn — member JKT48**

[![tests](https://github.com/Chavall315/delynn-worldv2/actions/workflows/tests.yml/badge.svg)](https://github.com/Chavall315/delynn-worldv2/actions/workflows/tests.yml)
[![linter](https://github.com/Chavall315/delynn-worldv2/actions/workflows/lint.yml/badge.svg)](https://github.com/Chavall315/delynn-worldv2/actions/workflows/lint.yml)
[![PHP](https://img.shields.io/badge/PHP-8.3%2B-8892BF?logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-4-FB70A9)](https://livewire.laravel.com)

</div>

---

## ✨ Tentang Proyek

**Delynn World** adalah fan site yang dibuat dengan cinta untuk Delynn, member JKT48.
Situs ini mengagregasi informasi terkini seputar aktivitas Delynn — mulai dari jadwal theater,
galeri foto kiriman fans, hingga timeline perjalanan kariernya.

Data jadwal theater diambil secara real-time dari **JKT48Connect API** dan di-cache setiap 5 menit.

---

## 🖥️ Fitur

| Halaman | Deskripsi |
|---|---|
| 🏠 **Home** | Landing page utama |
| 🎭 **Theater** | Jadwal show JKT48 yang ada Delynn di lineup-nya, update otomatis tiap 5 menit |
| 📸 **Gallery** | Galeri foto kiriman fans (perlu approval admin sebelum tampil) |
| 📅 **Timeline** | Perjalanan karier dan momen penting Delynn |
| 🔗 **Connect** | Link sosial media dan kontak |

---

## 🛠️ Tech Stack

- **Backend** — [Laravel 13](https://laravel.com) + [Livewire 4](https://livewire.laravel.com)
- **Frontend** — Blade + [Tailwind CSS v4](https://tailwindcss.com) + [Alpine.js](https://alpinejs.dev)
- **Database** — SQLite (lokal) / MySQL (produksi)
- **Storage** — [Supabase Storage](https://supabase.com) untuk foto galeri
- **API Eksternal** — [JKT48Connect](https://jkt48connect.my.id) untuk jadwal theater
- **Build Tool** — [Vite 8](https://vitejs.dev)
- **Testing** — [Pest PHP](https://pestphp.com)
- **Linting** — [Laravel Pint](https://laravel.com/docs/pint)
- **Static Analysis** — [Larastan / PHPStan](https://github.com/larastan/larastan)

---

## 🚀 Instalasi Lokal

### Prasyarat

- PHP **8.3+**
- Composer **2+**
- Node.js **22+**

### Langkah-langkah

```bash
# 1. Clone repo
git clone https://github.com/Chavall315/delynn-worldv2.git
cd delynn-worldv2

# 2. Install dependensi
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Migrasi database
php artisan migrate

# 5. Build assets
npm run build

# 6. Jalankan server
composer dev
```

> **Tip:** composer dev menjalankan PHP server, queue worker, dan Vite sekaligus dalam satu terminal.

---

## ⚙️ Konfigurasi Environment

Salin .env.example ke .env, lalu isi variabel berikut:

```env
# Database (default SQLite, ubah ke mysql untuk produksi)
DB_CONNECTION=sqlite

# Supabase Storage — untuk fitur upload foto galeri
SUPABASE_URL=https://xxxx.supabase.co
SUPABASE_SERVICE=your-service-role-key
SUPABASE_BUCKET=your-bucket-name

# JKT48Connect API — untuk jadwal theater
JKT48CONNECT_API_KEY=your-api-key
JKT48CONNECT_BASE_URL=https://jkt48connect.my.id
```

---

## 🧪 Testing & Quality Checks

```bash
# Jalankan semua test
php artisan test

# Format kode (Laravel Pint)
composer lint

# Cek style tanpa mengubah file
composer lint:check

# Static analysis (PHPStan)
composer types:check

# Semua sekaligus (identik dengan CI pipeline)
composer ci:check
```

---

## 📂 Struktur Direktori

```
app/
├── Http/Controllers/
│   ├── TheaterController.php    # Jadwal theater (JKT48Connect)
│   ├── TimelineController.php   # Timeline karier Delynn
│   ├── PhotoController.php      # Galeri + admin moderation
│   └── ProfileController.php
├── Models/
│   ├── Photo.php
│   └── TimelineEvent.php
└── Services/
    ├── TheaterScheduleService.php   # Fetch + cache jadwal dari API
    └── SupabaseStorageService.php   # Upload foto ke Supabase
```

---

## 🔄 CI/CD

Proyek ini menggunakan **GitHub Actions** dengan dua workflow otomatis:

| Workflow | Trigger | Yang dijalankan |
|---|---|---|
| 	ests | Push / PR ke main, master, develop | PHPStan + Pest (PHP 8.3, 8.4, 8.5) |
| linter | Push / PR ke main, master, develop | Laravel Pint code style check |

---

<div align="center">

Made with 💗 for Delynn — JKT48

</div>
