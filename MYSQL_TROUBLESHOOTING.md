# MySQL XAMPP Troubleshooting Guide

## Common Issues and Solutions

### 1. Port 3306 Already in Use
**Problem:** Another service is using MySQL's default port.

**Solution:**
```powershell
# Check what's using port 3306
netstat -ano | findstr :3306

# If MySQL80 service is running, stop it:
net stop MySQL80

# Or change XAMPP MySQL port in C:\xampp\mysql\bin\my.ini
# Change port=3306 to port=3307 (or another available port)
```

### 2. Windows MySQL Service Conflict
**Problem:** Windows MySQL service conflicts with XAMPP MySQL.

**Solution:**
```powershell
# Check if MySQL service exists
sc query MySQL80
sc query MySQL

# Stop and disable Windows MySQL service
net stop MySQL80
sc config MySQL80 start= disabled

# Or uninstall it
sc delete MySQL80
```

### 3. Corrupted InnoDB Files
**Problem:** Corrupted ibdata1 or ib_logfile files.

**Solution:**
1. Stop MySQL in XAMPP Control Panel
2. Backup your databases from `C:\xampp\mysql\data\`
3. Delete these files (NOT the databases):
   - `ibdata1`
   - `ib_logfile0`
   - `ib_logfile1`
   - `ibtmp1`
4. Restart MySQL

### 4. Insufficient Permissions
**Problem:** XAMPP doesn't have write permissions.

**Solution:**
- Run XAMPP Control Panel as Administrator
- Right-click XAMPP Control Panel → Run as Administrator

### 5. Memory Issues
**Problem:** MySQL running out of memory.

**Solution:**
Edit `C:\xampp\mysql\bin\my.ini`:
```ini
[mysqld]
innodb_buffer_pool_size=128M  # Reduce if you have less RAM
max_allowed_packet=64M
```

### 6. Multiple MySQL Instances
**Problem:** Multiple MySQL processes running.

**Solution:**
```powershell
# Kill all MySQL processes
taskkill /F /IM mysqld.exe
taskkill /F /IM mysql.exe

# Then restart from XAMPP Control Panel
```

### 7. Check Error Log
**Location:** `C:\xampp\mysql\data\mysql_error.log`

**View recent errors:**
```powershell
Get-Content C:\xampp\mysql\data\mysql_error.log -Tail 50
```

### 8. Reset MySQL Root Password
If you can't access MySQL:
```batch
# Run as Administrator
cd C:\xampp\mysql\bin
mysqladmin -u root password "newpassword"
```

### 9. Reinstall MySQL in XAMPP
**Last Resort:**
1. Backup all databases from `C:\xampp\mysql\data\`
2. Stop MySQL in XAMPP
3. Delete `C:\xampp\mysql\data\` (except your database folders)
4. Run `C:\xampp\mysql\mysql_installservice.bat` as Administrator
5. Restart MySQL

## Quick Fix Commands

```powershell
# Stop all MySQL processes
taskkill /F /IM mysqld.exe

# Check port 3306
netstat -ano | findstr :3306

# Check Windows MySQL service
sc query MySQL80

# Stop Windows MySQL service
net stop MySQL80

# Start XAMPP MySQL (run XAMPP Control Panel as Admin)
```

## Recommended Actions

1. **First:** Check if port 3306 is in use
2. **Second:** Check for Windows MySQL service conflicts
3. **Third:** Check error log for specific errors
4. **Fourth:** Try running XAMPP as Administrator
5. **Last:** Reinstall MySQL in XAMPP (backup first!)
