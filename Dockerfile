# Dockerfile
FROM php:8.2-cli

# Installer SQLite et extensions
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_sqlite zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# Créer la base de données SQLite
RUN touch database/database.sqlite
RUN chmod 777 database/database.sqlite storage bootstrap/cache

# Exécuter les migrations
RUN php artisan migrate --force

# Créer le lien de stockage
RUN php artisan storage:link

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]