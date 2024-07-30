# Intro
Sistem Inventaris Gudang - Barang Masuk dan Barang Keluar

![App Screenshot](https://github.com/rayys0703/)

## Admin credentials
**email:** admin@gmail.com
**password:** 12345678

## Tech Stack

**Client:** Bootstrap, Jquery

**Server:** PHP 8.2.x, Laravel 11.x

  
## Menu

- Dashboard
- Daftar barang
- Daftar gudang
- Daftar supplier
- Daftar customer
- Daftar jenis barang
- Daftar status barang
- Barang masuk
- Permintaan barang keluar
- Daftar keperluan
- Barang keluar
- Profile
  
## Installation 

```
composer install or composer update
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000

npm install
npm run dev
```