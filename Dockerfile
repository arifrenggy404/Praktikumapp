FROM php:8.5-cli-alpine

# Install ekstensi PHP & dependensi sistem yang dibutuhkan Laravel & MySQL
RUN apk add --no-cache \
    git \
    unzip \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip opcache

# Install Composer versi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Menyalin seluruh file project ke dalam container
COPY . /app

# Install dependensi Laravel tanpa dev & optimasi autoloader
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Berikan izin akses penuh ke folder storage dan bootstrap/cache
RUN chmod -R 777 /app/storage /app/bootstrap/cache

# Copy dan berikan hak akses eksekusi ke docker-entrypoint.sh
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port (Dapat disesuaikan oleh hosting via $PORT)
EXPOSE 8080 8000 80

ENTRYPOINT ["docker-entrypoint.sh"]
