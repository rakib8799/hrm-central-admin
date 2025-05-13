#!/bin/bash

set -e
set -o pipefail

# Log deployment output to a file
exec > >(tee -a deploy.log)
exec 2>&1

echo "🚀 Starting full Laravel + Inertia + Vue.js deployment..."

# === CONFIGURATION ===
USER="hrm"
SUB_DOMAIN="hrm-central-admin"
DOMAIN="mkrdev.xyz"
APP_DIR="/home/$USER/web/$SUB_DOMAIN.$DOMAIN/public_html"
PHP="php8.3"

# === STEP 1: Check Private repository and set ssh key for this  ===
if [ "$IS_PRIVATE_REPO" = "true" ] && [ -n "$SSH_KEY" ]; then
    echo "🔐 Setting up SSH agent for private GitHub repository access..."
    eval "$(ssh-agent -s)"

    SSH_KEY="${SSH_KEY/#\~/$HOME}"
    echo "Using SSH key: $SSH_KEY"

    ssh-add "$SSH_KEY"
else
    echo "ℹ️ Skipping SSH setup — either the repo is Public or SSH KEY is missing."
fi

# === STEP 2: Navigate to App Directory ===
echo "📂 Changing to app directory..."
cd "$APP_DIR" || { echo "❌ Failed to access $APP_DIR"; exit 1; }

# === STEP 3: Git Pull with Safety ===
echo "📥 Pulling latest code..."
if [ ! -d ".git" ]; then
    echo "❌ No Git repository found."
    exit 1
fi
git config --global --add safe.directory "$APP_DIR"
git fetch origin main
git reset --hard origin/main

# === STEP 4: Composer Dependencies ===
echo "📦 Installing Composer dependencies..."
composer clear-cache
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# === STEP 5: .env and APP_KEY ===
echo "🔐 Checking environment file..."
if [ ! -f ".env" ]; then
    echo "📄 .env not found. Copying from .env.example..."
    cp .env.example .env
fi

echo "🔑 Checking APP_KEY..."
if ! grep -q "^APP_KEY=base64" .env; then
    echo "🔑 Generating APP_KEY..."
    $PHP artisan key:generate
fi

# === STEP 6: Backup .env & Database ===
echo "💾 Backing up .env and database..."
cp .env ".env.backup.$(date +%F-%H-%M-%S)"

# Ensure correct permissions before backup
sudo chown -R "$USER":"$USER" "$APP_DIR/storage"
sudo chmod -R 775 "$APP_DIR/storage"

# Run the backup
sudo -u "$USER" $PHP artisan backup:run --only-db --disable-notifications || echo "⚠️ Database backup skipped or failed"

# === STEP 7: Database Migrations ===
echo "🧬 Running migrations..."
$PHP artisan migrate --force

# === STEP 8: NPM Build ===
echo "🧱 Building frontend assets..."
npm ci
npm run build

# === STEP 9: Permissions ===
echo "🔐 Setting correct permissions..."
sudo chown -R "$USER":"$USER" "$APP_DIR/storage"
sudo chmod -R 775 "$APP_DIR/storage"
sudo chmod -R 775 "$APP_DIR/bootstrap/cache"
chmod -R 775 "$APP_DIR"

# === STEP 10: Queue and Scheduling ===
echo "🔄 Checking if Queue commands exist..."
if command -v $PHP artisan queue:restart > /dev/null 2>&1; then
    echo "🔄 Restarting queues if running..."
    $PHP artisan queue:restart  # Restart queues if running
else
    echo "⚠️ queue:restart command not found. Skipping queue restart."
fi

echo "⏰ Checking if Scheduled tasks exist..."
if command -v $PHP artisan schedule:run > /dev/null 2>&1; then
    echo "⏰ Running scheduled tasks..."
    $PHP artisan schedule:run   # Run any scheduled tasks immediately
else
    echo "⚠️ schedule:run command not found. Skipping scheduled tasks."
fi

# === STEP 11: Storage Link ===
echo "🔗 Checking if storage:link command exists..."
if command -v $PHP artisan storage:link > /dev/null 2>&1; then
    echo "🔗 Creating storage symlink..."
    $PHP artisan storage:link  # Create symlink for storage if needed
else
    echo "⚠️ storage:link command not found. Skipping storage symlink."
fi

# === STEP 12: Restart Services (PHP-FPM, Nginx) ===
echo "🔄 Restarting PHP-FPM and Nginx services..."
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx

# === COMPLETE ===
echo "✅ Deployment completed successfully!"
