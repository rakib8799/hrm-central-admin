#!/bin/bash

set -e
set -o pipefail

echo "🚀 Starting Laravel, Inertia & Vue.js deployment..."

# === CONFIGURATION ===
USER="hrm"
SUB_DOMAIN="hrm-central-admin"
DOMAIN="mkrdev.xyz"
APP_DIR="/home/$USER/web/$SUB_DOMAIN.$DOMAIN/public_html"
PHP="php8.3"

# === STEP 1: Navigate to App Directory ===
echo "📂 Navigating to app directory..."
cd "$APP_DIR" || {
    echo "❌ Failed to access $APP_DIR"
    exit 1
}

# === STEP 2: Git Pull ===
if [ ! -d ".git" ]; then
    echo "❌ No Git repository found."
    exit 1
fi

echo "📥 Pulling latest code..."
git config --global --add safe.directory "$APP_DIR"
git reset --hard
git pull origin main --ff-only

# === STEP 3: Clear Vendor Directory ===
echo "🧹 Deleting vendor directory..."
rm -rf vendor/

# === STEP 4: Composer Install ===
echo "📦 Installing Composer dependencies..."

# Clear Composer cache to avoid old dependencies or corrupt cache
echo "🧹 Clearing Composer cache..."
sudo -u "$USER" composer clear-cache || {
    echo "❌ Composer cache clear failed"
    exit 1
}

# Run Composer install with the --no-dev flag to avoid installing unnecessary dev dependencies
echo "📦 Installing Composer dependencies..."
sudo -u "$USER" composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev || {
    echo "❌ Composer install failed"
    exit 1
}

# Fix permissions for vendor directory after Composer install
echo "🔧 Fixing permissions for vendor directory..."
chown -R "$USER":"$USER" vendor/
chmod -R 755 vendor/

# === STEP 5: Laravel Environment Setup ===
echo "🔐 Setting up Laravel environment..."

if [ ! -f ".env" ]; then
    echo "📄 .env not found, copying from .env.example"
    cp .env.example .env
fi

# Fix file permissions for .env and directories
echo "🔧 Fixing permissions for .env and directories..."
chown "$USER":"www-data" .env
chmod 664 .env
chown -R "$USER":"www-data" storage/ bootstrap/cache/
chmod -R 775 storage/ bootstrap/cache/

# Generate app key only if not set
if ! grep -q '^APP_KEY=' .env; then
    echo "🔑 Generating app key..."
    sudo -u "$USER" $PHP artisan key:generate
else
    echo "🔑 APP_KEY already exists, skipping key generation."
fi

# === STEP 6: Node Frontend Setup ===
echo "🧹 Cleaning old node_modules..."
rm -rf node_modules package-lock.json

echo "📦 Installing Node dependencies..."
sudo -u "$USER" npm install

# Clear Vite build dir to prevent EACCES errors
echo "🧹 Cleaning Vite build cache..."
rm -rf public/build/assets || true
mkdir -p public/build/assets
chown -R "$USER":"$USER" public/build

echo "⚙️ Building frontend with Vite..."
sudo -u "$USER" npm run build || {
    echo "❌ Vite build failed"
    exit 1
}

echo "✅ Deployment completed successfully!"
