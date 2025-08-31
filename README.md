# Installasi Project

1. Clone repository ini
2. Jalankan perintah `composer install` untuk menginstal semua dependensi
3. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi sesuai kebutuhan
4. Jalankan perintah `php artisan key:generate` untuk menghasilkan kunci aplikasi
5. Jalankan migrasi database dengan perintah `php artisan migrate`
6. Jalankan seeder dengan perintah `php artisan db:seed`
7. Jalankan Symlink dengan perintah `php artisan storage:link`
8. Jalankan perintah `npm install` untuk menginstal semua dependensi frontend
9. Jalankan perintah `npm run dev` untuk mengompilasi aset frontend
10. Setelah semua langkah di atas selesai, Anda dapat menjalankan aplikasi dengan perintah `php artisan serve`

# Troubleshooting

Jika Anda mengalami masalah saat menjalankan aplikasi, periksa hal-hal berikut:

-   Pastikan semua dependensi telah diinstal dengan benar
-   Periksa file `.env` untuk memastikan konfigurasi sudah benar
-   Lihat log aplikasi di `storage/logs` untuk informasi lebih lanjut tentang kesalahan

# Akun Login

Untuk login ke aplikasi, Anda dapat menggunakan akun berikut:

-   Email: `deni@mail.com`
-   Password: `password`
