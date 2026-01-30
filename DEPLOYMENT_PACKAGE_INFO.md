# 📦 Deployment Package Information

**Created**: January 22, 2025  
**Status**: ✅ Ready for GoDaddy cPanel Deployment

---

## 📦 **Available Deployment Packages**

### **1. `spinecare-deployment-20260122.zip`** ⭐ RECOMMENDED
**Size**: ~19-20 MB  
**Contents**: Production files only (no documentation)

**Includes:**
- ✅ All PHP files (index.php, thank-you.php, download.php)
- ✅ All assets (CSS, JS, images)
- ✅ All includes/ (PHP backend)
- ✅ vendor/ (Composer dependencies)
- ✅ composer.json & composer.lock
- ✅ htaccess
- ✅ mail.html

**Excludes:**
- ❌ Documentation files (.md)
- ❌ Test files
- ❌ Development folders
- ❌ .env file (create on server)
- ❌ Git history

**Best For**: Quick deployment when you already know the setup process

---

### **2. `spinecare-deployment-with-docs-20260122.zip`**
**Size**: ~19-20 MB  
**Contents**: Production files + essential documentation

**Includes:**
- ✅ Everything from package #1
- ✅ DEPLOYMENT_READY.md (complete guide)
- ✅ QUICK_DEPLOYMENT_GUIDE.md (3-step guide)
- ✅ PRE_DEPLOYMENT_CHECKLIST.txt (checklist)
- ✅ COMPOSER_INSTALL_GODADDY.md (Composer setup)
- ✅ ENV_SETUP_INSTRUCTIONS.md (.env setup)

**Best For**: First-time deployment or when you need reference docs

---

## 🚀 **How to Deploy via GoDaddy cPanel**

### **Step 1: Upload Zip File**
1. Login to GoDaddy cPanel
2. Open **File Manager**
3. Navigate to: `public_html/lpnew/` (or your site directory)
4. Click **Upload**
5. Select `spinecare-deployment-20260122.zip`
6. Wait for upload to complete

### **Step 2: Extract Files**
1. In File Manager, locate the uploaded zip file
2. **Right-click** → **Extract**
3. Extract to current directory (`public_html/lpnew/`)
4. Wait for extraction (may take 1-2 minutes)
5. **Delete the zip file** after extraction

### **Step 3: Create `.env` File**
1. In File Manager, click **+ File**
2. Name it exactly: `.env` (with the dot)
3. Open `.env` file for editing
4. Copy contents from `ENV_SETUP_INSTRUCTIONS.md` (if included) or see below
5. Paste and save

**`.env` File Template:**
```env
RC_APP_CLIENT_ID=Vio69rKiOYzeUD1HzN9CB4
RC_APP_CLIENT_SECRET=1cKNRePU0yYcdq9atQr3MzaKl8pytt2YXcqrghDqnjYC
RC_USER_JWT=eyJraWQiOiI4NzYyZjU5OGQwNTk0NGRiODZiZjVjYTk3ODA0NzYwOCIsInR5cCI6IkpXVCIsImFsZyI6IlJTMjU2In0.eyJhdWQiOiJodHRwczovL3BsYXRmb3JtLnJpbmdjZW50cmFsLmNvbS9yZXN0YXBpL29hdXRoL3Rva2VuIiwic3ViIjoiOTM3ODUwMDM1IiwiaXNzIjoiaHR0cHM6Ly9wbGF0Zm9ybS5yaW5nY2VudHJhbC5jb20iLCJleHAiOjE5MjQ5OTE5OTksImlhdCI6MTc0NzExNTA3OSwianRpIjoiUUwwaHZtN0hSdi1YZGpxbUhTOWpBZyJ9.QXtcc8tcuhhemRyQeFWMxZidCcBHr1bNsH1XYOlLoZ5PQFzgtuJ5XXZOp8vZ3jZReIUltCVsLp051_8Znss4C9-NE2Qy_95CzhkhIwDj6Mm1T0daGJpmLO7AER_ufkYXwLB34zmXMpRENmTVpJ28WNx1sJNoRRCRqzdNjfZ0tVyVxE0P-Feqlg1l04fbxr0fUsapX1kQZqEB0jUKv5JVqxdKk9ZNNvO4NoXBtTUv1mx98txbRzZvquMEl97WuII9WN01Ev08r8MJbboFELkoeKsTc0ctqQMPzRIemaNaH99n5e-x5zG6DiSeKKDhbY0etB0cBlG9Wx2KwTxYKvu0JA
RC_SERVER_URL=https://platform.ringcentral.com
BREVO_API_KEY=your_brevo_api_key_here
BREVO_SENDER_EMAIL=surgeonspine18@gmail.com
BREVO_API_ENDPOINT=https://api.brevo.com/v3/smtp/email
RECAPTCHA_SITE_KEY=6LfvdVcqAAAAABlZbwDh0MKP9LpT10JKxPSqEYqG
RECAPTCHA_SECRET_KEY=6LfvdVcqAAAAAPrvqj0TJ0zEE157czfK4F1WXXc35
OTP_EXPIRATION_TIME=300
OTP_LENGTH=6
OTP_MIN=100000
OTP_MAX=999999
SESSION_SAVE_PATH=session_data_files
SESSION_LIFETIME=300
```

### **Step 4: Create Session Directory**
1. In File Manager, click **+ Folder**
2. Name it: `session_data_files`
3. Set permissions: **755**

### **Step 5: Set File Permissions**
1. Select `.env` file → **Permissions** → Set to **600**
2. Select `session_data_files/` folder → **Permissions** → Set to **755**
3. Select all PHP files → **Permissions** → Set to **644**

### **Step 6: Test Website**
1. Visit: `https://www.onlinespinecare.com/lpnew/`
2. Test appointment form → OTP flow
3. Test brochure download form
4. Check Netlify dashboard for submissions

---

## 📋 **What's Included in the Package**

### **Core Files:**
```
✅ index.php              - Main landing page (with CallRail)
✅ thank-you.php          - Success page (with CallRail)
✅ download.php           - Download page (with CallRail)
✅ htaccess               - Server configuration
✅ composer.json          - Dependencies
✅ composer.lock          - Lock file
✅ mail.html              - Email template preview
```

### **Assets:**
```
✅ assets/css/            - All stylesheets
✅ assets/js/             - All JavaScript files
✅ assets/images/          - All images (37 files)
```

### **Backend:**
```
✅ includes/               - All PHP backend files
   ├── functions.php
   ├── config-otp.php
   ├── send-otp.php
   ├── verify-otp.php
   ├── submit-form-otp.php
   ├── mail.php
   ├── download-brochure.php
   ├── newslettermail.php
   ├── google-sheets.php
   └── email.html
```

### **Dependencies:**
```
✅ vendor/                 - Composer packages
   ├── autoload.php
   ├── ringcentral/
   └── vlucas/
```

---

## ⚠️ **Important Notes**

1. **`.env` File**: NOT included in zip (security). Create manually on server.
2. **Vendor Folder**: Included in zip. No need to run `composer install` if extracted correctly.
3. **Session Directory**: Create `session_data_files/` folder manually.
4. **File Permissions**: Set after extraction:
   - `.env` = 600 (read/write owner only)
   - Folders = 755
   - PHP files = 644

---

## 🔍 **Verification After Deployment**

After extracting and setting up, verify:

- [ ] `vendor/autoload.php` exists
- [ ] `.env` file created with correct credentials
- [ ] `session_data_files/` folder exists
- [ ] Website loads: `https://www.onlinespinecare.com/lpnew/`
- [ ] Forms work (test OTP flow)
- [ ] CallRail script loads (check browser console)

---

## 📞 **Troubleshooting**

### **Issue: "Class not found" error**
- **Solution**: Verify `vendor/autoload.php` exists
- **Fix**: Re-extract zip or run `composer install`

### **Issue: OTP not sending**
- **Solution**: Check `.env` file exists and has correct credentials
- **Fix**: Verify RingCentral JWT token is complete (no truncation)

### **Issue: Permission denied**
- **Solution**: Set correct file permissions
- **Fix**: `.env` = 600, folders = 755, files = 644

---

## ✅ **Package Status**

**Package Created**: ✅ Ready  
**Files Verified**: ✅ All included  
**Dependencies**: ✅ Vendor folder included  
**Documentation**: ✅ Available (in docs version)  

**Ready for deployment to GoDaddy cPanel!**
