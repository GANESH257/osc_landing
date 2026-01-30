# Complete Project Understanding - Spine Care Landing Page

## 🎯 **Project Overview**

This is a **medical landing page** for **Chesterfield S.P.I.N.E. Center** (Dr. Amit Bhandarkar - Spine Surgeon). The site promotes minimally invasive spine surgery services and collects patient inquiries through multiple forms with advanced security features.

**Live URL**: `https://www.onlinespinecare.com/lpnew`  
**Netlify Forms Endpoint**: `https://spinecare-landing-page.netlify.app`

---

## 📋 **What We Built**

### **1. Landing Page Structure** (`index.php`)

A comprehensive single-page website with:

#### **Sections:**
1. **Header** - Logo, navigation menu, CTA buttons
2. **Hero Section** - Main headline with "Book Appointment" CTA
3. **Flash News** - Marquee with services
4. **Trust Signals** - Credentials, experience, ratings
5. **Conditions We Treat** - Grid of medical conditions
6. **About Section** - Doctor credentials and expertise
7. **Services** - 6 treatment options with descriptions
8. **Why Choose Us** - Benefits and differentiators
9. **Treatment Options** - Detailed service cards
10. **CTA Section** - Call-to-action box
11. **Testimonials** - Patient reviews
12. **Contact Us** - Location, phone, email, contact form
13. **FAQ** - Expandable questions
14. **Footer** - Social links, newsletter signup, copyright
15. **Floating Elements** - WhatsApp button, Call button

#### **Tracking & Analytics:**
- Google Tag Manager (GTM-N565GV57)
- Hotjar (Site 6436979)
- Google Analytics (G-FRFXBKHV0W)
- Schema.org markup (MedicalOrganization, MedicalClinic)

---

### **2. Forms System** (3 Forms Total)

#### **Form 1: Appointment Booking Modal** (`#modalEnquiryForm`)
- **Location**: Modal popup (triggered by "Book Appointment" buttons)
- **Class**: `enquiryFormModal`
- **Fields**: Name, Country Code, Phone, Email, Message, Privacy Policy, SMS Consent
- **Form Name**: `modal-contact`
- **Features**: 
  - ✅ OTP verification required
  - ✅ reCAPTCHA v3 protection
  - ✅ Netlify Forms submission
  - ✅ Honeypot spam protection

#### **Form 2: Main Contact Form** (`#mainEnquiryForm`)
- **Location**: Contact section (main page)
- **Class**: `enquiryFormModal`
- **Fields**: Same as modal form
- **Form Name**: `modal-contact`
- **Features**: 
  - ✅ OTP verification required
  - ✅ reCAPTCHA v3 protection
  - ✅ Netlify Forms submission
  - ✅ Honeypot spam protection

#### **Form 3: Brochure Download Form** (`.downloadFormModal`)
- **Location**: Modal popup (triggered by "Download Brochure" buttons)
- **Fields**: Name, Country Code, Phone, Email
- **Form Name**: `brochure-download`
- **Features**: 
  - ✅ Client-side validation (name, phone, email format)
  - ✅ Country-specific phone validation (US/UK/India = 10 digits)
  - ✅ reCAPTCHA v3 protection
  - ✅ Netlify Forms submission
  - ✅ NO OTP required (simpler flow)

---

### **3. OTP Verification System** (NEW - Major Feature)

#### **Purpose:**
Prevent spam and verify user identity before form submission.

#### **Flow:**

**Step 1: User Fills Form**
- User enters: Name, Country Code, Phone, Email, Message
- Clicks **"Send Verification Code"** button

**Step 2: OTP Generation & Delivery**
- Backend generates 6-digit OTP (100000-999999)
- Stores in PHP session with 5-minute expiration
- **Routing Logic:**
  - **US/Canada (+1)**: Send SMS via RingCentral API
  - **All Others**: Send Email via Brevo API
- User sees: "Verification code has been sent..."

**Step 3: OTP Input Section**
- Main form hides, OTP section appears
- User enters 6-digit code
- Submit button enables when 6 digits entered

**Step 4: OTP Verification**
- User clicks **"Verify & Submit"**
- Backend verifies OTP against session
- If valid: Sets `$_SESSION['otp_verified'] = true`
- If invalid: Shows error, user can retry

**Step 5: Final Submission**
- reCAPTCHA v3 token generated
- Form submitted to Netlify Forms
- Redirect to `thank-you.php`

#### **Files:**

**Backend:**
- `includes/config-otp.php` - Configuration (keys, expiration times)
- `includes/send-otp.php` - Generates & sends OTP (SMS/Email)
- `includes/verify-otp.php` - Verifies entered OTP
- `includes/submit-form-otp.php` - Validates OTP before submission

**Frontend:**
- `assets/js/enquiry.js` - OTP flow JavaScript handlers

**Configuration:**
- `.env` - API credentials (RingCentral, Brevo, reCAPTCHA)
- `composer.json` - PHP dependencies (RingCentral SDK, Dotenv)

#### **OTP Settings:**
- **Length**: 6 digits
- **Expiration**: 5 minutes
- **Verification Validity**: 10 minutes (after verification, form can be submitted)
- **Storage**: PHP session (`$_SESSION`)

#### **API Integration:**

**RingCentral (SMS for US):**
- SDK: `ringcentral/ringcentral-php:^3.0`
- Authentication: JWT token
- Endpoint: `/restapi/v1.0/account/{accountId}/extension/{extensionId}/sms`
- From Number: `+16362524468`
- Credentials: Stored in `.env` file

**Brevo (Email for non-US):**
- API Key: Hardcoded in `functions.php`
- Endpoint: `https://api.brevo.com/v3/smtp/email`
- Sender: `surgeonspine18@gmail.com`
- Template: HTML email with OTP code

**Localhost Testing:**
- Test mode: Returns OTP directly in JSON response
- Bypasses API calls for easier development
- Shows: "TEST MODE: Your verification code is {OTP}"

---

### **4. reCAPTCHA Protection**

#### **reCAPTCHA v3 (Invisible)**
- **Used For**: Appointment forms, Contact form, Brochure form
- **Site Key**: `6LfvdVcqAAAAABlZbwDh0MKP9LpT10JKxPSqEYqG`
- **Secret Key**: `6LfvdVcqAAAAAPrvqj0TJ0zEE157czfK4F1WXXc35`
- **Implementation**: 
  - Script loaded in `<head>`
  - Token generated before form submission
  - Token verified server-side
  - No visible checkbox (invisible)

#### **reCAPTCHA v2 (Checkbox)**
- **Status**: Not currently used (would require separate v2 key)
- **Note**: Initially attempted for brochure form, but switched to v3 due to key compatibility

---

### **5. Form Validation**

#### **Client-Side Validation** (`assets/js/enquiry.js`)

**Appointment/Contact Forms:**
- HTML5 validation (required fields)
- Email format check
- Phone number format check
- OTP format check (6 digits)

**Brochure Form:**
- **Name**: 2-50 characters, letters/spaces only
- **Phone**: 7-15 digits, country-specific validation:
  - US/Canada (+1): Exactly 10 digits
  - UK (+44): Exactly 10 digits
  - India (+91): Exactly 10 digits
  - Others: 7-15 digits
- **Email**: Valid format with @domain.com pattern
- Real-time validation feedback (green/red borders)

#### **Server-Side Validation**
- OTP verification (session-based)
- reCAPTCHA token verification
- Input sanitization (`$site->esc()`)
- Email validation (`filter_var()`)

---

### **6. Netlify Forms Integration**

#### **Purpose:**
Reliable form submission handling and data storage.

#### **Configuration:**
- **Endpoint**: `https://spinecare-landing-page.netlify.app`
- **Method**: POST with `no-cors` mode
- **Form Names**: 
  - `modal-contact` (appointment/contact forms)
  - `brochure-download` (brochure form)

#### **Features:**
- Honeypot spam protection (`netlify-honeypot="bot-field"`)
- Automatic data storage in Netlify dashboard
- CSV export capability
- Webhook support for notifications

#### **Submission Flow:**
1. Form validated (client-side)
2. OTP verified (for appointment/contact forms)
3. reCAPTCHA token generated
4. Form data sent to Netlify via `fetch()` API
5. Redirect to `thank-you.php` after 1 second delay

---

### **7. Email Notifications**

#### **Brevo Email Integration** (`includes/functions.php`)

**Function**: `brevoMailSend($mailname, $mailid, $subject, $content)`

**Used For:**
- OTP delivery (non-US numbers)
- Enquiry notifications (`includes/mail.php`)
- Brochure download notifications (`includes/download-brochure.php`)

**Recipients:**
- `mgmt@onlinespinecare.com`
- `itteam@onlinespinecare.com`
- `getupihm@gmail.com`

**Template**: `includes/email.html` (HTML email template)

---

### **8. Google Sheets Integration**

#### **Purpose:**
Store form submissions in Google Sheets for easy access.

#### **Implementation:**
- File: `includes/google-sheets.php`
- Spreadsheet ID: `1P9YhiovvD9oqZHeIn-vjwqhiY6GABdH3IUBUbMRj_FA`
- Used in: `includes/mail.php` (contact form submissions)

---

### **9. Database Integration**

#### **MySQL Database:**
- **Connection**: PDO (`mysql:host=localhost;dbname=spinecare_db`)
- **Table**: `landing_page_enquiries`
- **Function**: `sendenquiry()` in `functions.php`
- **Fields**: name, email, phone, message, created_at

---

### **10. Dependencies & Configuration**

#### **Composer Dependencies** (`composer.json`):
```json
{
  "require": {
    "ringcentral/ringcentral-php": "^3.0",
    "vlucas/phpdotenv": "^5.0"
  }
}
```

#### **Environment Variables** (`.env`):
- RingCentral credentials (Client ID, Secret, JWT, Server URL)
- Brevo API key (also hardcoded in functions.php)
- reCAPTCHA keys (also in config-otp.php)
- OTP configuration (expiration, length)

#### **PHP Requirements:**
- PHP 7.4+ (configured in composer.json)
- Session support
- cURL extension (for API calls)
- PDO MySQL extension (for database)

---

## 🔄 **Complete User Flows**

### **Flow 1: Appointment Booking (with OTP)**

1. User clicks "Book Appointment" button
2. Modal opens with form
3. User fills: Name, Country Code, Phone, Email, Message
4. User checks Privacy Policy & SMS Consent
5. User clicks **"Send Verification Code"**
6. **Backend**: Generates OTP, sends SMS (US) or Email (non-US)
7. **Frontend**: Shows OTP input section
8. User enters 6-digit OTP
9. User clicks **"Verify & Submit"**
10. **Backend**: Verifies OTP
11. **Frontend**: Generates reCAPTCHA token
12. **Frontend**: Submits to Netlify Forms
13. Redirect to `thank-you.php`

### **Flow 2: Brochure Download (no OTP)**

1. User clicks "Download Brochure" button
2. Modal opens with form
3. User fills: Name, Country Code, Phone, Email
4. Real-time validation feedback
5. User clicks **"Download Brochure"**
6. **Frontend**: Validates all fields
7. **Frontend**: Generates reCAPTCHA token
8. **Frontend**: Submits to Netlify Forms
9. Redirect to `download.php`

### **Flow 3: Newsletter Signup**

1. User enters email in footer newsletter form
2. User clicks submit
3. **Backend**: `includes/newslettermail.php`
4. Email sent via Brevo
5. Redirect to `thank-you.php`

---

## 🛠️ **Technical Architecture**

### **Frontend:**
- **HTML**: Bootstrap 5.3.3, custom CSS
- **JavaScript**: jQuery, vanilla JS, AJAX
- **Libraries**: 
  - Bootstrap Icons
  - Owl Carousel
  - AOS (Animate On Scroll)
  - Google reCAPTCHA v3

### **Backend:**
- **Language**: PHP 7.4+
- **Session Management**: PHP sessions
- **API Integration**: 
  - RingCentral SDK (SMS)
  - Brevo REST API (Email)
  - Google reCAPTCHA API
- **Database**: MySQL (PDO)
- **Dependency Management**: Composer

### **File Structure:**
```
lpnew/
├── index.php                    # Main landing page
├── thank-you.php               # Success page
├── download.php                # Brochure download page
├── .env                        # Environment variables (credentials)
├── composer.json               # PHP dependencies
├── composer.lock               # Dependency lock file
├── vendor/                     # Composer packages
├── assets/
│   ├── css/                    # Stylesheets
│   ├── js/
│   │   ├── enquiry.js         # Form handlers & OTP flow
│   │   └── news.js            # Newsletter handler
│   └── images/                # Images, icons, PDFs
├── includes/
│   ├── functions.php          # Core functions (site class)
│   ├── config-otp.php        # OTP configuration
│   ├── send-otp.php          # OTP generation & sending
│   ├── verify-otp.php        # OTP verification
│   ├── submit-form-otp.php   # Form submission validation
│   ├── mail.php               # Contact form handler
│   ├── download-brochure.php  # Brochure form handler
│   ├── newslettermail.php     # Newsletter handler
│   ├── google-sheets.php      # Google Sheets integration
│   └── email.html             # Email template
└── netlify-forms/             # Netlify forms backend (separate repo)
```

---

## 🔐 **Security Features**

1. **OTP Verification**: Prevents automated spam submissions
2. **reCAPTCHA v3**: Bot detection and spam prevention
3. **Honeypot Fields**: Netlify honeypot spam protection
4. **Input Sanitization**: All inputs sanitized with `$site->esc()`
5. **Session Security**: OTP stored in server-side sessions
6. **HTTPS Required**: Production requires SSL
7. **Rate Limiting**: OTP expiration prevents abuse
8. **Server-Side Validation**: Never trust client-side only

---

## 📊 **Data Flow**

### **Appointment/Contact Form Submission:**

```
User Input
    ↓
Client-Side Validation
    ↓
Send OTP Request → includes/send-otp.php
    ↓
Generate OTP → Store in Session
    ↓
Send SMS (RingCentral) OR Email (Brevo)
    ↓
User Enters OTP
    ↓
Verify OTP → includes/verify-otp.php
    ↓
Set Session Flag: otp_verified = true
    ↓
Generate reCAPTCHA Token
    ↓
Submit to Netlify Forms
    ↓
Netlify Stores Data
    ↓
Redirect to thank-you.php
```

### **Brochure Download:**

```
User Input
    ↓
Client-Side Validation
    ↓
Generate reCAPTCHA Token
    ↓
Submit to Netlify Forms
    ↓
Netlify Stores Data
    ↓
Redirect to download.php
```

---

## 🚀 **Deployment**

### **Hosting:**
- **Main Site**: GoDaddy shared hosting
- **Forms Backend**: Netlify (static hosting)

### **Requirements:**
- PHP 7.4+
- Composer installed
- `.env` file with credentials
- `vendor/` directory (from `composer install`)
- Session directory writable

### **Deployment Steps:**
1. Upload all files to GoDaddy
2. Run `composer install` (or upload `vendor/` directory)
3. Create `.env` file with credentials
4. Ensure session directory is writable
5. Test OTP flow (SMS/Email)
6. Verify Netlify Forms submissions

---

## 🐛 **Known Issues & Solutions**

### **Issue 1: reCAPTCHA "Invalid key type"**
- **Cause**: Using v3 key with v2 checkbox widget
- **Solution**: Use v3 for all forms (invisible, no checkbox)

### **Issue 2: RingCentral JWT Token Error**
- **Cause**: Truncated token in `.env` file
- **Solution**: Ensure full JWT token (no `...` truncation)

### **Issue 3: Brevo IP Authorization**
- **Cause**: Localhost IP not whitelisted
- **Solution**: Test mode returns OTP directly (bypasses API)

### **Issue 4: Composer PHP Version**
- **Cause**: PHP version mismatch
- **Solution**: Use `composer install --ignore-platform-reqs`

---

## 📝 **Key Features Summary**

✅ **3 Forms**: Appointment modal, Contact form, Brochure download  
✅ **OTP Verification**: SMS (US) or Email (non-US)  
✅ **reCAPTCHA v3**: Invisible bot protection  
✅ **Netlify Forms**: Reliable submission handling  
✅ **Client-Side Validation**: Real-time feedback  
✅ **Server-Side Validation**: Secure verification  
✅ **Email Notifications**: Brevo integration  
✅ **Google Sheets**: Data storage  
✅ **MySQL Database**: Enquiry storage  
✅ **Responsive Design**: Mobile-friendly  
✅ **Analytics**: GTM, Hotjar, GA  
✅ **Schema Markup**: SEO optimization  

---

## 🎯 **What Makes This Special**

1. **Dual-Channel OTP**: Automatically routes SMS (US) or Email (others)
2. **Seamless Integration**: OTP flow integrated into existing Netlify Forms
3. **Production-Ready**: Error handling, logging, fallbacks
4. **Developer-Friendly**: Localhost test mode for easy development
5. **Security-First**: Multiple layers of spam protection
6. **User-Friendly**: Clear validation feedback, smooth UX

---

## 📚 **Documentation Files**

- `OTP_VERIFICATION_IMPLEMENTATION_GUIDE.md` - Complete OTP guide
- `NETLIFY_INTEGRATION_STATUS.md` - Netlify setup status
- `DEPLOYMENT_CHECKLIST.md` - Deployment steps
- `LOCALHOST_VS_PRODUCTION.md` - Environment differences
- `RECAPTCHA_V2_SETUP.md` - How to get v2 key (if needed)

---

**Last Updated**: December 15, 2024  
**Status**: ✅ Production Ready
