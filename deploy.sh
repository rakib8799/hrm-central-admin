#!/bin/bash

echo "🚀 Starting Laravel, Inertia & Vue.js deployment..."

# Configurations
USER="admin"
SUB_DOMAIN="basic-project"
DOMAIN="mkrdev.xyz"

APP_DIR="/home/$USER/web/$SUB_DOMAIN.$DOMAIN/public_html"
PHP="php8.3"   # Ensure this matches your PHP version

# Navigate to app directory
cd "$APP_DIR" || {
    echo "❌ Failed to access $APP_DIR"
    exit 1
}

# Check if .git exists
if [ ! -d ".git" ]; then
    echo "❌ No Git repository found in $APP_DIR"
    exit 1
fi

echo "📥 Pulling latest changes from Git..."
git reset --hard
git pull origin main

# Ensure the app is up-to-date with PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Laravel specific configurations (environment file, key generation, etc.)
echo "🔐 Setting up Laravel application..."
if [ ! -f ".env" ]; then
    cp .env.example .env
fi

# Set the correct permissions for Laravel storage and cache
chmod -R ug+rwx storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

touch storage/logs/laravel.log
chmod 666 storage/logs/laravel.log
chown www-data:www-data storage/logs/laravel.log

echo "🔑 Generating application key if not set..."
$PHP artisan key:generate --force

echo "🧪 Running migrations and setting up caches..."
$PHP artisan migrate --force
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache

# Install and build Node.js (Vue.js) dependencies
echo "🧱 Installing Node dependencies and building assets..."
npm ci || npm install
npm run build

# Optional: Clear and cache all assets to ensure it's up-to-date
npm run prod

echo "✅ Deployment complete!"

# Restart services if required (e.g., Nginx or PHP-FPM)
echo "🔄 Restarting PHP-FPM and Nginx..."
systemctl restart php8.3-fpm
systemctl restart nginx

echo "🚀 Site deployed and services restarted successfully!"
