# InfoHilang

Platform pelaporan dan pencarian hewan, manusia, atau barang yang hilang.

## Fitur Utama

- Buat laporan kehilangan dengan foto dan detail
- Cek duplikat laporan dengan AI
- Cari barang/hewan/manusia yang hilang
- Lokasi berbasis peta
- Komunikasi dengan pelapor
- Notifikasi real-time

## Instalasi

```bash
git clone <repository-url>
cd infoHilang
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Kebutuhan Sistem

- PHP 8.0+
- Laravel 10+
- MySQL
- Composer

## Penggunaan

1. Daftar akun baru
2. Buat laporan kehilangan atau mulai mencari
3. Gunakan filter pencarian untuk hasil yang lebih spesifik
4. Hubungi pelapor yang relevan

## Lisensi

MIT

## Tech Stack

- **Backend**: Laravel 10, PHP 8.0+
- **Database**: MySQL
- **Frontend**: Blade Templates / Livewire
- **Maps**: Leaflet
- **Real-time**: Laravel Broadcasting
- **Package Manager**: Composer, NPM

## Kontribusi

Kontribusi sangat diterima. Silakan buat branch baru untuk fitur atau perbaikan bug.
