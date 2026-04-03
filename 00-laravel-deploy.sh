#!/usr/bin/env bash

# Installer les dépendances composer (sans les packages de dev)
composer install --no-dev --optimize-autoloader

# Forcer HTTPS sur tous les assets en production
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Lancer les migrations automatiquement
php artisan migrate --force

# Créer le lien symbolique storage
php artisan storage:link