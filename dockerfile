FROM php:8.2-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copie du projet
COPY . /var/www
WORKDIR /var/www

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Configuration Nginx & permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Configuration de la publication Nginx
COPY .render/nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD service nginx start && php-fpm