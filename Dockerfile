# Étape 1 : construire les assets avec Node et Composer
FROM node:20 as build

# Installer PHP et Composer
RUN apt update && apt install -y php php-cli php-mbstring php-xml php-bcmath unzip curl git php-mysql php-pgsql php-curl

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Copier le code
WORKDIR /app
COPY . .

# Installer les dépendances PHP et JS
RUN composer install --optimize-autoloader --no-dev
RUN npm ci && npm run build

# Étape 2 : Image finale avec PHP
FROM php:8.2-cli

WORKDIR /app

# Copier depuis l'étape précédente
COPY --from=build /app /app

# Lancer Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080

