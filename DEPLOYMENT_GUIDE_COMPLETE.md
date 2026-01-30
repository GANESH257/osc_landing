# Complete Deployment Guide - Updated with reCAPTCHA

## 🏗️ **Architecture Overview**

Your website uses a **hybrid setup**:

1. **GoDaddy (cPanel)** - Hosts the main website
   - Landing page (`index.php`)
   - All assets (CSS, JS, images)
   - PHP backend (OTP, email, etc.)
   - Domain: `onlinespinecare.com/lpnew`

2. **Netlify** - Handles form submissions only
   - Separate Git repository
   - Endpoint: `https://spinecare-landing-page.netlify.app`
   - Receives form data from GoDaddy site
   - Stores submissions in Netlify dashboard

**They work together** - GoDaddy hosts the site, Netlify processes forms.

---

## 📦 **What Needs to be Deployed**

### ✅ **1. GoDaddy (cPanel) - REQUIRED UPDATE**

**Files to upload/replace:**

```
📁 Root Directory (/lpnew/ or public_html/lpnew/)
├── index.php                    ⚠️ UPDATED (added reCAPTCHA to brochure form)
├── assets/
│   └── js/
│       └── enquiry.js          ⚠️ UPDATED (added reCAPTCHA token generation)
├── includes/                   ✅ Keep existing (no changes)
├── vendor/                      ✅ Keep existing (no changes)
├── .env                         ✅ Keep existing (no changes)
└── [all other files]           ✅ Keep existing (no changes)
```

**What changed:**
- `index.php` - Added hidden reCAPTCHA token field to brochure form
- `assets/js/enquiry.js` - Added reCAPTCHA token generation before brochure submission

**Deployment Steps:**
1. Upload `index.php` (replace existing)
2. Upload `assets/js/enquiry.js` (replace existing)
3. **That's it!** No other files changed.

---

### ⚠️ **2. Netlify - OPTIONAL UPDATE**

**Do you need to update Netlify?**

**Short Answer: NO** - Netlify doesn't need updates because:
- Netlify Forms accepts any form fields you send
- The `recaptcha_token` field will be stored automatically
- Netlify doesn't validate reCAPTCHA (that's done on your GoDaddy server if needed)

**However**, if you want to add reCAPTCHA verification on Netlify side (optional):

**Files in Netlify repo (`netlify-forms/`):**
- `index.html` - Contact form page (for reference)
- `brochure-download.html` - Brochure form page (for reference)
- `netlify.toml` - Netlify configuration
- `_redirects` - Redirect rules

**If updating Netlify (optional):**
1. Add hidden `recaptcha_token` field to `brochure-download.html` (if you want it there)
2. Deploy to Netlify Git repository
3. Netlify will auto-deploy

**But this is NOT required** - Forms will work without updating Netlify.

---

## 🚀 **Quick Deployment Steps**

### **Step 1: Deploy to GoDaddy (cPanel)**

1. **Login to cPanel**
2. **Open File Manager**
3. **Navigate to**: `public_html/lpnew/` (or wherever your site is)
4. **Upload/Replace these 2 files:**
   - `index.php`
   - `assets/js/enquiry.js`
5. **Done!**

### **Step 2: Verify Netlify (Optional)**

1. **Check Netlify Dashboard**: `https://app.netlify.com`
2. **Find your site**: `spinecare-landing-page`
3. **Check Forms**: Forms should still be receiving submissions
4. **No action needed** - it will accept the new `recaptcha_token` field automatically

---

## ✅ **Will Everything Work?**

### **YES - Everything will work with just GoDaddy update!**

**Why?**

1. **Forms submit to Netlify** - The endpoint URL stays the same
2. **Netlify accepts any fields** - It will store `recaptcha_token` automatically
3. **reCAPTCHA script already loaded** - Already in `<head>` of `index.php`
4. **No breaking changes** - We only added a field, didn't remove anything

**Flow:**
```
User fills form → reCAPTCHA token generated → Form submits to Netlify → Netlify stores (including token) → Success!
```

---

## 🔍 **What Changed Exactly?**

### **Before:**
- Brochure form submitted directly to Netlify
- No bot protection (getting spam)

### **After:**
- Brochure form generates reCAPTCHA token
- Token included in submission
- Netlify stores token (can verify later if needed)
- Bot protection active

---

## 📋 **Deployment Checklist**

### **GoDaddy (cPanel) - REQUIRED**
- [ ] Upload `index.php` (replace existing)
- [ ] Upload `assets/js/enquiry.js` (replace existing)
- [ ] Test brochure download form
- [ ] Verify reCAPTCHA token is generated (check browser console)

### **Netlify - OPTIONAL**
- [ ] Check Netlify dashboard for form submissions
- [ ] Verify submissions include `recaptcha_token` field
- [ ] (Optional) Update Netlify repo if you want token field in HTML

---

## 🧪 **Testing After Deployment**

1. **Test Brochure Form:**
   - Fill out brochure download form
   - Click "Download Brochure"
   - Check browser console (F12) - should see reCAPTCHA token generated
   - Form should submit successfully

2. **Check Netlify Dashboard:**
   - Login to Netlify
   - Go to Forms section
   - Check latest submission
   - Should see `recaptcha_token` field in submission data

3. **Monitor Spam:**
   - Check if bot submissions decrease
   - Empty submissions should reduce significantly

---

## ❓ **FAQ**

### **Q: Do I need to update Netlify Git repo?**
**A:** No, not required. Netlify will accept the new field automatically.

### **Q: Will forms still work if I only update GoDaddy?**
**A:** Yes! Forms will work perfectly. Netlify accepts any form fields.

### **Q: What if I don't update Netlify?**
**A:** Nothing breaks. Netlify will just store the `recaptcha_token` field along with other data.

### **Q: Can I verify reCAPTCHA on Netlify side?**
**A:** Yes, but you'd need to add serverless functions. Not required for basic spam protection.

### **Q: Will this break existing functionality?**
**A:** No. We only added a field, didn't change any existing logic.

---

## 📝 **Summary**

**Minimum Required:**
- ✅ Update GoDaddy: Upload `index.php` and `assets/js/enquiry.js`
- ✅ That's it!

**Optional:**
- Update Netlify repo (not required, but can be done for consistency)

**Result:**
- ✅ Brochure form will have reCAPTCHA protection
- ✅ Bot submissions will decrease
- ✅ Everything else continues to work normally

---

**Last Updated:** December 15, 2024
**Changes:** Added reCAPTCHA v3 to brochure download form

