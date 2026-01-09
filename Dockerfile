FROM php:8.2-cli

# Installer SQLite3
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
    && docker-php-ext-install -j$(nproc) gd pdo pdo_sqlite zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Créer le fichier SQLite
RUN mkdir -p /var/www/html/database
RUN touch /var/www/html/database/database.sqlite
RUN chmod 777 /var/www/html/database/database.sqlite

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# ⚠️ EXÉCUTER LES MIGRATIONS (IMPORTANT !)
RUN php artisan migrate --force

# Configurer les permissions
RUN chmod -R 777 storage bootstrap/cache

# Créer le lien de stockage
RUN php artisan storage:link || true

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]