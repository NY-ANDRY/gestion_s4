# Étape 1 : Build des assets avec Node, PHP et Composer
FROM node:20 as build

RUN apt update && apt install -y \
  php php-cli php-mbstring php-xml php-bcmath unzip curl git php-mysql php-pgsql php-curl

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN npm ci && npm run build

# Étape 2 : Image finale avec Apache et PHP
FROM php:8.2-apache

# Installer extensions PHP nécessaires (PostgreSQL + autres)
RUN apt update && apt install -y libpq-dev unzip git curl && docker-php-ext-install pdo pdo_pgsql

# Activer mod_rewrite pour Laravel (routes)
RUN a2enmod rewrite

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier tout le projet
COPY --from=build /app /var/www/html

# Donner les permissions nécessaires à Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurer Apache pour pointer vers /public
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Lancer les migrations et Apache
CMD php artisan migrate --force && apache2-foreground
