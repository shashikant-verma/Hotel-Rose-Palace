# 🏨 Hotel Rose Palace - MySQL Server Location & Live Deployment Guide

---

## 📍 MySQL Server Installation Location

### Windows Installation Path
```
C:\Program Files\MySQL\MySQL Server 8.0
```

### Key MySQL Binaries Location
```
C:\Program Files\MySQL\MySQL Server 8.0\bin\
├── mysql.exe              (MySQL CLI client)
├── mysqldump.exe          (Database backup tool)
├── mysqld.exe             (MySQL server executable)
└── ... (other utilities)
```

### Additional MySQL Components on System
```
C:\Program Files\MySQL\
├── mysql begginer          (Tutorial/Demo)
├── MySQL Router 8.0        (Connection routing)
├── MySQL Server 8.0        (Main server)
├── MySQL Shell 8.0         (Advanced shell)
└── MySQL Workbench 8.0     (GUI management)
```

### Windows Service Details
- **Service Name:** MYSQL80
- **Display Name:** MYSQL80
- **Current Status:** Stopped (can be started when needed)
- **Startup Type:** Manual/Automatic

---

## 🗄️ Database Details

### Database Name
```
hotel_rose_palace
```

### Connection Parameters
```
Host:     127.0.0.1 (localhost)
Port:     3306 (default MySQL port)
Username: root
Password: (empty/no password set)
Charset:  utf8mb4
Collation: utf8mb4_unicode_ci
```

### Database Size
- **SQL File Size:** ~81 KB
- **Compressed Size:** ~10-16 KB
- **Current Tables:** 12+
- **Current Records:** 50+ (varies with bookings)

---

## 📊 Database Contents

### Core Tables
1. **users** - Admin accounts (1 record)
2. **room_types** - 2 types (Deluxe Family, Executive)
3. **rooms** - 15 rooms (numbered 101-115)
4. **room_images** - Room photos
5. **amenities** - Hotel amenities list
6. **amenity_room_type** - Amenity associations

### Booking & Operations
7. **enquiries** - Guest bookings and enquiries
8. **banquet_bookings** - Event bookings
9. **contact_messages** - Contact form submissions

### Management
10. **gallery_images** - Hotel gallery photos
11. **hotel_settings** - Hotel configuration
12. **migrations** - Database schema version control

---

## 💾 Database Backup Files

Located at: `D:\Hotel-Rose-Palace\backups\`

### Available Backup Packages

#### 1. hotel_rose_palace_LIVE_SERVER_BACKUP.zip (15.87 KB) ⭐ RECOMMENDED
**Complete package with full documentation**
- SQL database file
- Installation instructions
- Quick reference guide
- README documentation

#### 2. hotel_rose_palace_COMPLETE_BACKUP.zip (13.75 KB)
**Database + documentation**
- SQL database file
- Setup instructions
- Quick reference

#### 3. hotel_rose_palace_database_backup.zip (10.14 KB)
**Database only**
- SQL database file only
- Minimal size for quick transfer

#### 4. hotel_rose_palace_2026-11-13_180848.sql (81 KB)
**Raw SQL backup file**
- Can be used directly
- No compression

---

## 🚀 Live Server Deployment Steps

### Step 1: Prepare Live Server
```bash
# Ensure MySQL is installed and running
# Windows: Start the MYSQL80 service
# Linux/Mac: Ensure MySQL service is running
```

### Step 2: Extract Backup
```bash
# On live server, extract the zip file:
unzip hotel_rose_palace_LIVE_SERVER_BACKUP.zip

# This will extract:
# - hotel_rose_palace_2026-11-13_180848.sql
# - MYSQL_BACKUP_INSTRUCTIONS.md
# - QUICK_REFERENCE.txt
# - README.md
```

### Step 3: Create Database
```sql
-- Connect to MySQL as root
mysql -u root -h 127.0.0.1

-- Create database
CREATE DATABASE hotel_rose_palace 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Verify creation
SHOW DATABASES;
```

### Step 4: Restore Database
```bash
# Option A: Command line (recommended)
mysql -u root -h 127.0.0.1 hotel_rose_palace < hotel_rose_palace_2026-11-13_180848.sql

# Option B: From within MySQL
mysql -u root -h 127.0.0.1
mysql> SOURCE /path/to/hotel_rose_palace_2026-11-13_180848.sql;
```

### Step 5: Verify Restoration
```sql
USE hotel_rose_palace;

-- Check tables
SHOW TABLES;

-- Verify data
SELECT COUNT(*) as room_count FROM rooms;
SELECT COUNT(*) as room_type_count FROM room_types;
SELECT * FROM room_types;
SELECT COUNT(*) as amenity_count FROM amenities;
```

### Step 6: Update Laravel Configuration
```env
# Edit .env file on live server
DB_CONNECTION=mysql
DB_HOST=your_server_ip_or_localhost
DB_PORT=3306
DB_DATABASE=hotel_rose_palace
DB_USERNAME=root
DB_PASSWORD=
```

### Step 7: Laravel Setup
```bash
# Clear cache
php artisan optimize:clear

# Run migrations (if needed)
php artisan migrate --force

# Compile assets
npm run build

# Restart application
php artisan serve  # (or configure with production web server)
```

---

## 🔧 Useful Commands

### MySQL Commands
```bash
# Login to MySQL
mysql -u root -h 127.0.0.1

# Create new backup
mysqldump -u root -h 127.0.0.1 hotel_rose_palace > backup_new.sql

# Check MySQL version
mysql --version

# List all databases
mysql -u root -e "SHOW DATABASES;"

# Check table count
mysql -u root hotel_rose_palace -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='hotel_rose_palace';"
```

### PowerShell Commands (Windows)
```powershell
# Start MySQL service
Start-Service -Name MYSQL80

# Stop MySQL service
Stop-Service -Name MYSQL80

# Check service status
Get-Service -Name MYSQL80

# Create backup with timestamp
$date = Get-Date -Format 'yyyy-MM-dd_HHmmss'
& "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe" -u root hotel_rose_palace > "backup_$date.sql"
```

---

## 📋 Live Server Checklist

Before declaring live:

- [ ] MySQL installed and running on live server
- [ ] Database created and restored
- [ ] All 15 rooms (101-115) present in database
- [ ] Both room types visible (Deluxe Family, Executive)
- [ ] Admin user can login
- [ ] Gallery images load correctly
- [ ] Booking modal works
- [ ] WhatsApp number: +91 8866771900 configured
- [ ] Google Maps embed functional
- [ ] SSL certificate installed (HTTPS)
- [ ] Email configuration tested (if applicable)
- [ ] Automated backup scheduled
- [ ] Database password secured
- [ ] Application performance acceptable
- [ ] All unit tests pass

---

## 🛡️ Security Recommendations

### For Production Server:

1. **Change MySQL root password:**
```sql
ALTER USER 'root'@'localhost' IDENTIFIED BY 'strong_password_here';
FLUSH PRIVILEGES;
```

2. **Create dedicated database user:**
```sql
CREATE USER 'hotel_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON hotel_rose_palace.* TO 'hotel_user'@'localhost';
FLUSH PRIVILEGES;
```

3. **Update .env with new credentials:**
```env
DB_USERNAME=hotel_user
DB_PASSWORD=secure_password
```

4. **Set up automated backups:**
```bash
# Create cron job (Linux/Mac) or Scheduled Task (Windows)
# Run daily at 2:00 AM
0 2 * * * mysqldump -u hotel_user -p'password' hotel_rose_palace > /backups/hotel_$(date +\%Y-\%m-\%d).sql
```

5. **Configure firewall:**
```bash
# Only allow internal connections to MySQL
# Block external access to port 3306
```

---

## 📞 Support Information

**Hotel Rose Palace**
- **WhatsApp:** +91 8866771900 (for enquiries)
- **Phone 1:** +91 88667 71900
- **Phone 2:** +91 87991 29929
- **Email:** Hotelrosepalacesurat@gmail.com
- **Address:** 4th Floor, Atlanta Business Hub, VIP Road, Vesu, Surat, Gujarat 395007

---

## 📅 Backup Schedule

| Frequency | Retention | Location |
|-----------|-----------|----------|
| Daily | 7 days | Local backup folder |
| Weekly | 4 weeks | External drive/Cloud |
| Monthly | 12 months | Archive storage |

---

## 🎯 Summary

✅ **MySQL Location:** `C:\Program Files\MySQL\MySQL Server 8.0`
✅ **Backup Location:** `D:\Hotel-Rose-Palace\backups\`
✅ **Database:** `hotel_rose_palace`
✅ **Live Backup Ready:** `hotel_rose_palace_LIVE_SERVER_BACKUP.zip`
✅ **Documentation:** Complete and included in backup package

---

**Prepared:** November 13, 2026
**Status:** ✅ Ready for Live Deployment
**Version:** 1.0
