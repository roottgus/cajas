#!/usr/bin/env bash
# post_deploy.sh

cd "$DEPLOY_DIR"   
composer install --no-dev --optimize-autoloader
php artisan storage:link --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm install && npm run build   
