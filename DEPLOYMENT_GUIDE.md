# Hotel Rose Palace - Deployment Guide

**Version:** 1.0  
**Last Updated:** November 12, 2026  
**Status:** Production Ready

---

## 📋 Pre-Deployment Checklist

### Development Environment Verification
- [ ] All tests passing: `php artisan test`
- [ ] No error logs: `storage/logs/laravel.log`
- [ ] Database migrations up-to-date
- [ ] .env.example updated with latest variables
- [ ] All dependencies installed: `composer install`
- [ ] Assets built: `npm run build`
- [ ] Code review completed
- [ ] Git history clean and committed

### Code Quality Checks
- [ ] No sensitive data in code (passwords, keys, tokens)
- [ ] No debug code or console.log statements
- [ ] Proper error handling everywhere
- [ ] Security measures verified
- [ ] Performance optimized
- [ ] Database indexes created

---

## 🚀 Deployment Steps

### 1. Server Preparation

#### System Requirements:
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js 18 or higher (for asset compilation)
- Git
- SSL/TLS Certificate

#### Create Deployment User:
```bash
# Create non-root user for application
sudo useradd -m -s /bin/bash hotelrose
sudo usermod -aG www-data hotelrose

# Set up SSH keys for deployments
sudo mkdir -p /home/hotelrose/.ssh
sudo chmod 700 /home/hotelrose/.ssh
```

#### Install Dependencies:
```bash
# Update system
sudo apt-get update && sudo apt-get upgrade -y

# Install required packages
sudo apt-get install -y php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-curl php8.2-gd php8.2-mbstring php8.2-zip php8.2-xml

# Install Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install Git
sudo apt-get install -y git

# Install MySQL
sudo apt-get install -y mysql-server
```

### 2. Clone Repository

```bash
# Navigate to web root
cd /var/www

# Clone repository
sudo git clone https://github.com/yourusername/hotel-rose-palace.git hotelrose

# Set ownership
sudo chown -R hotelrose:www-data hotelrose

# Set permissions
cd hotelrose
chmod -R 755 .
chmod -R 777 storage bootstrap/cache
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate encryption key
php artisan key:generate

# Edit .env with production values
nano .env
```

#### Required .env Variables:

```env
APP_NAME="Hotel Rose Palace"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_rose
DB_USERNAME=hotelrose_user
DB_PASSWORD=strong_random_password

# Cache Configuration
CACHE_DRIVER=redis
SESSION_DRIVER=cookie

# Mail Configuration (if needed)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@hotelrose.com

# Session Security
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
```

### 4. Database Setup

```bash
# Create database
sudo mysql -u root -p
```

```sql
CREATE DATABASE hotel_rose CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hotelrose_user'@'localhost' IDENTIFIED BY 'strong_random_password';
GRANT ALL PRIVILEGES ON hotel_rose.* TO 'hotelrose_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

```bash
# Run migrations
php artisan migrate --force

# Seed data (initial admin user, amenities, settings)
php artisan db:seed --force
```

### 5. Install Dependencies

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies
npm install --production

# Build assets
npm run build
```

### 6. Set Up Storage Symlink

```bash
# Create symlink for public access to storage
php artisan storage:link

# Verify storage permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 7. Configure Web Server

#### Nginx Configuration:

Create `/etc/nginx/sites-available/hotelrose`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;

    # SSL Certificate
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # Root directory
    root /var/www/hotelrose/public;
    index index.php index.html index.htm;

    # Logging
    access_log /var/log/nginx/hotelrose_access.log;
    error_log /var/log/nginx/hotelrose_error.log;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss;

    # PHP handling
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Laravel routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Deny access to sensitive files
    location ~ /\.env {
        deny all;
    }

    location ~ /storage {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Cache static assets
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|webp|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/hotelrose /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

#### Apache Configuration:

Create `.htaccess` in `/var/www/hotelrose/public/`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 8. SSL/TLS Setup

Using Let's Encrypt with Certbot:

```bash
# Install Certbot
sudo apt-get install -y certbot python3-certbot-nginx

# Obtain certificate
sudo certbot certonly --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal setup
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer

# Test renewal
sudo certbot renew --dry-run
```

### 9. Cron Jobs

Set up automated tasks:

```bash
# Edit crontab
crontab -e

# Add these entries:
* * * * * cd /var/www/hotelrose && php artisan schedule:run >> /dev/null 2>&1

# Laravel schedule (check queue, cache cleanup, etc.)
```

### 10. Monitoring & Logging

#### Set Up Log Rotation:

Create `/etc/logrotate.d/hotelrose`:

```
/var/www/hotelrose/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 hotelrose www-data
}
```

#### Monitor Application:

```bash
# View real-time logs
tail -f /var/www/hotelrose/storage/logs/laravel.log

# View security logs
tail -f /var/www/hotelrose/storage/logs/security.log

# Monitor processes
htop
```

### 11. Backup Strategy

Create backup script at `/usr/local/bin/backup-hotelrose.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/backups/hotelrose"
DATE=$(date +%Y%m%d_%H%M%S)

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u hotelrose_user -p hotel_rose | gzip > $BACKUP_DIR/database_$DATE.sql.gz

# Backup application files
tar -czf $BACKUP_DIR/application_$DATE.tar.gz /var/www/hotelrose

# Backup storage
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz /var/www/hotelrose/storage

# Remove backups older than 30 days
find $BACKUP_DIR -type f -mtime +30 -delete

# Upload to cloud storage (optional)
# aws s3 sync $BACKUP_DIR s3://your-backup-bucket/

echo "Backup completed: $DATE"
```

Add to crontab:
```bash
# Daily backup at 2 AM
0 2 * * * /usr/local/bin/backup-hotelrose.sh
```

---

## 🔒 Post-Deployment Security

### Verify Security:

```bash
# Check for debug mode
grep APP_DEBUG /var/www/hotelrose/.env

# Verify file permissions
ls -la /var/www/hotelrose/storage
ls -la /var/www/hotelrose/bootstrap/cache

# Test HTTPS
curl -I https://yourdomain.com

# Check security headers
curl -I https://yourdomain.com | grep -E "X-Frame|X-Content|X-XSS|Strict"
```

### Run Final Tests:

```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPDO()

# Test email configuration
php artisan tinker
>>> Mail::raw('Test', function($message) { $message->to('test@example.com'); })

# Test file uploads
php artisan storage:link
```

---

## 📊 Production Optimization

### Cache Configuration:

```bash
# Cache config for faster loading
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### Database Optimization:

```bash
# Create necessary indexes
php artisan migrate --force

# Optimize tables
php artisan tinker
>>> DB::statement('OPTIMIZE TABLE enquiries');
>>> DB::statement('OPTIMIZE TABLE rooms');
>>> DB::statement('OPTIMIZE TABLE room_images');
```

### Performance Monitoring:

Install monitoring tools:
```bash
# New Relic (optional)
# DataDog (optional)
# Scout (optional)
```

---

## 🐛 Troubleshooting

### Common Issues:

**Permission Denied Errors:**
```bash
chmod -R 777 storage bootstrap/cache
sudo chown -R hotelrose:www-data /var/www/hotelrose
```

**Database Connection Error:**
```bash
# Check credentials in .env
# Test connection
php artisan tinker
>>> DB::connection()->getPDO()
```

**Assets Not Loading:**
```bash
# Rebuild assets
npm run build

# Clear cache
php artisan cache:clear
php artisan view:clear
```

**Uploads Not Working:**
```bash
# Verify storage symlink
ls -la public/storage

# Recreate if needed
php artisan storage:link
```

---

## 📞 Support & Maintenance

### Automated Alerts:
- [ ] Set up uptime monitoring (Pingdom, Uptime Robot)
- [ ] Configure error notifications (Sentry)
- [ ] Set up performance monitoring

### Regular Maintenance:
- [ ] Weekly backup verification
- [ ] Monthly security updates
- [ ] Quarterly performance review
- [ ] Annual infrastructure audit

---

## 🔄 Rollback Procedure

If deployment fails:

```bash
# Connect to server
ssh deployer@yourdomain.com

# Restore from backup
cd /var/www/hotelrose
git checkout HEAD~1  # Previous version

# Or restore from full backup
tar -xzf /backups/hotelrose/application_BACKUP_DATE.tar.gz -C /

# Rebuild cache
php artisan cache:clear
php artisan config:cache
php artisan view:cache
```

---

## 📈 Post-Launch Monitoring

### First Week:
- [ ] Monitor error logs daily
- [ ] Check database performance
- [ ] Verify backups working
- [ ] Monitor uptime

### Ongoing:
- [ ] Weekly security audit
- [ ] Monthly dependency updates
- [ ] Quarterly performance optimization
- [ ] Annual infrastructure review

---

**Deployment Status:** ✅ Ready for Production  
**Last Updated:** November 12, 2026  
**Next Review:** December 12, 2026

