FROM php:8.2-fpm


RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier le fichier d'environnement dédié au conteneur (contient la config MySQL "db")
COPY .env.docker .env

# Copier les fichiers de dépendances et installer les vendors (sans scripts artisan)
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

# Copier le reste de l'application dans l'image
COPY . .

# Donner les bons droits à Laravel pour le cache et le storage
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache



    #docker build -t dialloousmane1999/amicale-chicory:latest -f docker/php/Dockerfile .
#docker push  dialloousmane1999/amicale-chicory:latest