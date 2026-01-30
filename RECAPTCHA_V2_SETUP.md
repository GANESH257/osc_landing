# How to Get reCAPTCHA v2 Key (If You Want Checkbox)

## Current Situation

You currently have a **reCAPTCHA v3** key, which is **invisible** (no checkbox). 

If you want a **visible checkbox** for the brochure form, you need to create a separate **reCAPTCHA v2** key.

## Steps to Create reCAPTCHA v2 Key

### 1. Go to Google reCAPTCHA Admin
Visit: https://www.google.com/recaptcha/admin/create

### 2. Create New Site
- **Label**: "Spine Care Brochure Form v2" (or any name)
- **reCAPTCHA type**: Select **"reCAPTCHA v2"** → **"I'm not a robot" Checkbox**
- **Domains**: Add your domain(s):
  - `onlinespinecare.com`
  - `www.onlinespinecare.com`
  - `localhost` (for testing)

### 3. Accept Terms and Submit
Click "Submit" to create the site

### 4. Get Your Keys
You'll receive:
- **Site Key** (for frontend): `6Lf...` (different from v3 key)
- **Secret Key** (for backend): `6Lf...` (different from v3 key)

### 5. Update Code

Once you have the v2 keys, update:

**`index.php`** - Add v2 script:
```html
<!-- Google reCAPTCHA v2 (for brochure form) -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
```

**`index.php`** - Add checkbox widget:
```html
<div class="g-recaptcha" data-sitekey="YOUR_V2_SITE_KEY"></div>
```

**`assets/js/enquiry.js`** - Check for checkbox completion:
```javascript
var recaptchaResponse = grecaptcha.getResponse();
if (!recaptchaResponse) {
    // Show error: "Please complete reCAPTCHA"
    return false;
}
```

## Current Solution (v3 - No Checkbox)

Right now, the brochure form uses **reCAPTCHA v3** (invisible) like the appointment forms. This:
- ✅ Works immediately (no new keys needed)
- ✅ Provides bot protection
- ✅ Shows a notice that reCAPTCHA is active
- ❌ No visible checkbox

## Recommendation

**Keep v3** - It's simpler and provides the same protection. The checkbox is just visual - v3 is actually more effective at stopping bots.

But if you **really want the checkbox**, follow the steps above to get a v2 key.

