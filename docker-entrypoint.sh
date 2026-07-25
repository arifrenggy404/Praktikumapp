#!/bin/sh
set -e

echo "=== Memulai Inisialisasi Container Laravel GKS Kandara ==="

# 1. Pastikan symlink storage terpasang
php artisan storage:link || true

# 2. Clear & Cache Konfigurasi Laravel
echo "Menyiapkan cache konfigurasi dan rute..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. Jalankan migrasi database jika ENV RUN_MIGRATIONS=true atau otomatis jika DB siap
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Menjalankan migrasi database otomatis..."
    php artisan migrate --force
fi

# 4. Tentukan port dari variabel environment hosting (Render, Railway, Fly.io, Heroku) atau 8080
PORT=${PORT:-8080}
echo "Server berjalan di port $PORT..."

exec php artisan serve --host=0.0.0.0 --port=$PORT
