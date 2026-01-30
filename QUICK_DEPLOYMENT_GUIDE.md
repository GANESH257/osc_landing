# ⚡ Quick Deployment Guide - Spine Care Landing Page

## 🎯 **3-Step Deployment Process**

### **Step 1: Upload Files** (15 minutes)
1. Connect to GoDaddy via FTP/cPanel
2. Upload ALL files maintaining directory structure:
   ```
   ✅ index.php
   ✅ thank-you.php
   ✅ download.php
   ✅ assets/ (entire folder)
   ✅ includes/ (entire folder)
   ✅ composer.json
   ✅ composer.lock
   ✅ htaccess
   ✅ vendor/ (or vendor.zip to extract)
   ```

### **Step 2: Create `.env` File** (5 minutes)
**CRITICAL**: Create `.env` file in root with these exact values:

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

**⚠️ IMPORTANT**: 
- File must be named exactly `.env` (with the dot)
- No quotes, no spaces
- Replace `RC_USER_JWT` with COMPLETE token (check for truncation)

### **Step 3: Install Dependencies** (5 minutes)

**Option A: SSH (if available)**
```bash
cd /path/to/lpnew
composer install --ignore-platform-reqs
mkdir -p session_data_files
chmod 755 session_data_files
chmod 600 .env
```

**Option B: Upload vendor.zip**
1. Upload `vendor.zip` to root directory
2. Extract it (creates `vendor/` folder)
3. Create `session_data_files/` folder
4. Set permissions: `.env` = 600, folders = 755

---

## ✅ **Quick Test Checklist**

After deployment, test these immediately:

- [ ] Website loads: `https://www.onlinespinecare.com/lpnew/`
- [ ] Appointment form → Send OTP → Receive code → Submit
- [ ] Brochure form → Fill → Submit → Download page
- [ ] Check Netlify dashboard for submissions
- [ ] Verify CallRail script loads (check browser console)

---

## 🚨 **Common Issues & Quick Fixes**

| Issue | Quick Fix |
|-------|-----------|
| OTP not sending | Check `.env` file exists and `vendor/autoload.php` exists |
| "Class not found" error | Run `composer install` or extract `vendor.zip` |
| reCAPTCHA error | Already fixed - using v3 for all forms |
| Forms not submitting | Check Netlify endpoint URL |
| CallRail not working | Verify script is before `</body>` tag |

---

## 📞 **Need Help?**

1. Check `DEPLOYMENT_READY.md` for detailed guide
2. Check GoDaddy error logs in cPanel
3. Verify `.env` file format (no markdown syntax)
4. Test OTP locally first if possible

---

**Estimated Total Time**: 25-30 minutes  
**Status**: ✅ Ready to Deploy
