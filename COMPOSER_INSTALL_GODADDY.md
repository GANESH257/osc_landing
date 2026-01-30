# How to Install Composer Dependencies on GoDaddy

## Option 1: SSH Access (Recommended)

If you have SSH access to your GoDaddy server:

1. **SSH into your server:**
   ```bash
   ssh username@your-server-ip
   # OR
   ssh username@your-domain.com
   ```

2. **Navigate to your website directory:**
   ```bash
   cd /path/to/your/website/lpnew
   # Common paths:
   # /home/username/public_html/lpnew
   # /home/username/domains/yourdomain.com/public_html/lpnew
   ```

3. **Check if Composer is installed:**
   ```bash
   composer --version
   ```

4. **If Composer is NOT installed, install it:**
   ```bash
   curl -sS https://getcomposer.org/installer | php
   php composer.phar install
   ```

5. **If Composer IS installed, just run:**
   ```bash
   composer install
   ```

6. **Verify installation:**
   ```bash
   ls -la vendor/
   # Should see: autoload.php, ringcentral/, vlucas/, etc.
   ```

---

## Option 2: cPanel Terminal

If GoDaddy provides cPanel with Terminal access:

1. **Login to cPanel**
2. **Find "Terminal" or "SSH Access"** in cPanel
3. **Open Terminal**
4. **Run the same commands as Option 1**

---

## Option 3: Upload vendor Folder (If SSH Not Available)

If you DON'T have SSH access, you can upload the vendor folder:

### On Your Local Machine:

1. **Make sure vendor folder exists locally:**
   ```bash
   cd /Applications/MAMP/htdocs/lpnew
   composer install
   ```

2. **Zip the vendor folder:**
   ```bash
   zip -r vendor.zip vendor/
   ```

3. **Upload vendor.zip to GoDaddy** via FTP/cPanel File Manager

4. **On GoDaddy server:**
   - Extract vendor.zip in your website root directory
   - Make sure vendor/ folder is in the same directory as composer.json

---

## Option 4: Use GoDaddy's PHP Composer (if available)

Some GoDaddy hosting plans include Composer:

1. **Check if Composer is available:**
   ```bash
   which composer
   # OR
   /usr/local/bin/composer --version
   ```

2. **If available, run:**
   ```bash
   /usr/local/bin/composer install
   ```

---

## Quick Check: Is Composer Already Installed?

Run this on your GoDaddy server:
```bash
composer --version
```

If you see a version number, Composer is installed!

---

## Troubleshooting

### "composer: command not found"
- Install Composer using Option 1 instructions
- Or use Option 3 (upload vendor folder)

### "Permission denied"
- Make sure you're in the correct directory
- Check file permissions: `chmod 755 .`

### "Could not find package"
- Check internet connection on server
- Try: `composer install --no-cache`

### "Memory limit exhausted"
- Increase PHP memory: `php -d memory_limit=512M composer install`

---

## Verify Installation

After installation, check these files exist:
- ✅ `vendor/autoload.php`
- ✅ `vendor/ringcentral/ringcentral-php/`
- ✅ `vendor/vlucas/phpdotenv/`

Then test OTP SMS should work!

