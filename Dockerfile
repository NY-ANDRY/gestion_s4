# Étape 1 : Builder
FROM node:20 as build

# Installer PHP, Composer et extensions
RUN apt update && apt install -y \
  php php-cli php-mbstring php-xml php-bcmath unzip curl git php-mysql php-pgsql php-curl

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Copier le code source
WORKDIR /app
COPY . .

# Installer dépendances PHP et JS
RUN composer install --optimize-autoloader --no-dev
RUN npm ci && npm run build

# Étape 2 : Image finale PHP avec extensions PostgreSQL
FROM php:8.2-cli

# Installer extensions nécessaires dans l'image finale
RUN apt update && apt install -y libpq-dev unzip git curl && docker-php-ext-install pdo pdo_pgsql

# Dossier de travail
WORKDIR /app

# Copier les fichiers depuis le build
COPY --from=build /app /app

# Lancer les migrations puis le serveur Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080
