# Localhost vs Production - OTP Verification Guide

## ✅ What Works on Localhost (`http://localhost:8888/lpnew/`)

### **Will Work:**
1. **Email OTP (Brevo)** ✅
   - Works perfectly on localhost
   - No domain restrictions
   - Test with any email address

2. **SMS OTP (RingCentral)** ✅
   - Should work on localhost
   - No domain restrictions for API calls
   - Test with US phone numbers (+1)

3. **OTP Generation & Verification** ✅
   - PHP sessions work on localhost
   - OTP storage and verification works
   - All backend logic works

4. **Form Flow** ✅
   - JavaScript OTP flow works
   - Form validation works
   - UI/UX works perfectly

### **⚠️ May Have Issues:**

1. **reCAPTCHA v3** ⚠️
   - **Issue**: reCAPTCHA requires domain registration in Google reCAPTCHA console
   - **Localhost**: `localhost:8888` may not be registered
   - **Solution Options**:
     - **Option A**: Register `localhost` and `localhost:8888` in Google reCAPTCHA console
     - **Option B**: Test without reCAPTCHA (forms will still work, just no spam protection)
     - **Option C**: Use production domain for testing

## 🌐 What Works on Production (GoDaddy)

### **Everything Works:**
1. **Email OTP** ✅
2. **SMS OTP** ✅
3. **reCAPTCHA v3** ✅ (if domain is registered)
4. **All Features** ✅

## 🔧 Configuration Differences

### **Localhost Setup:**
- Use: `http://localhost:8888/lpnew/`
- Sessions: Work automatically
- API calls: All work (Brevo, RingCentral)
- reCAPTCHA: May need domain registration

### **Production Setup (GoDaddy):**
- Use: `https://www.onlinespinecare.com/lpnew/`
- Sessions: Work automatically
- API calls: All work
- reCAPTCHA: Should be registered for production domain

## 📝 Netlify Code - NO CHANGES NEEDED

### **✅ Netlify Forms Stay the Same**

**Important**: You do NOT need to modify any Netlify code or Git repository.

**Why?**
- OTP verification happens **BEFORE** submitting to Netlify
- The Netlify endpoint stays the same: `https://spinecare-landing-page.netlify.app`
- Form data structure stays the same
- Netlify forms continue to work as before

**Flow:**
```
User fills form
    ↓
OTP verification (NEW - happens on your server)
    ↓
Submit to Netlify (UNCHANGED - same as before)
    ↓
Netlify processes form (UNCHANGED)
```

**What Changed:**
- ✅ Added OTP verification step before Netlify submission
- ✅ Forms now require OTP before submitting
- ✅ Netlify endpoint and form structure: **NO CHANGES**

## 🧪 Testing on Localhost

### **Step 1: Install Composer Dependencies**
```bash
cd /Applications/MAMP/htdocs/lpnew
composer install
```

### **Step 2: Test Email OTP (Works Immediately)**
1. Fill form with non-US country code (e.g., UK +44)
2. Click "Send Verification Code"
3. Check email inbox
4. Enter OTP and submit

### **Step 3: Test SMS OTP (Should Work)**
1. Fill form with US country code (+1)
2. Enter valid US phone number
3. Click "Send Verification Code"
4. Check phone for SMS
5. Enter OTP and submit

### **Step 4: Test reCAPTCHA (May Need Setup)**
- If reCAPTCHA errors appear, you can:
  - **Option A**: Register `localhost:8888` in Google reCAPTCHA console
  - **Option B**: Test without reCAPTCHA (remove reCAPTCHA check temporarily)
  - **Option C**: Test on production domain

## 🔐 reCAPTCHA Domain Registration

### **To Register Localhost:**

1. Go to: https://www.google.com/recaptcha/admin
2. Find your reCAPTCHA site (Site Key: `6LfvdVcqAAAAABlZbwDh0MKP9LpT10JKxPSqEYqG`)
3. Click "Settings"
4. Under "Domains", add:
   - `localhost`
   - `localhost:8888`
   - `127.0.0.1`
5. Save changes

### **For Production:**
- Ensure `onlinespinecare.com` is registered
- Ensure `www.onlinespinecare.com` is registered

## ✅ Quick Answer Summary

### **Q: Will OTP work on localhost?**
**A:** Yes! Most features work:
- ✅ Email OTP: Works
- ✅ SMS OTP: Should work
- ✅ OTP verification: Works
- ⚠️ reCAPTCHA: May need domain registration

### **Q: Should I modify Netlify code?**
**A:** **NO** - Netlify code stays exactly the same:
- ✅ No changes to Netlify forms
- ✅ No changes to Git repository
- ✅ Same endpoint: `https://spinecare-landing-page.netlify.app`
- ✅ OTP happens BEFORE Netlify submission

### **Q: What do I need to do?**
**A:** Just:
1. ✅ Create `.env` file (already done)
2. ✅ Run `composer install`
3. ✅ Test on localhost
4. ✅ Deploy to GoDaddy when ready

## 🚀 Recommended Testing Approach

1. **Test Email OTP on localhost** (most reliable)
2. **Test SMS OTP on localhost** (should work)
3. **Test full flow on production** (after deployment)
4. **Register localhost in reCAPTCHA** (if you want to test reCAPTCHA locally)

## 📞 Troubleshooting Localhost

### **If OTP not sending:**
- Check `.env` file exists and has correct credentials
- Check `composer install` was run
- Check PHP error logs
- Verify sessions are working

### **If reCAPTCHA errors:**
- Register `localhost:8888` in reCAPTCHA console
- Or test without reCAPTCHA (forms still work)

### **If SMS not working:**
- Check RingCentral credentials in `.env`
- Check phone number format (+1XXXXXXXXXX)
- Check RingCentral account status

---

**Bottom Line**: OTP will work on localhost for testing. Netlify code needs NO changes. Everything is ready to test! 🎉

