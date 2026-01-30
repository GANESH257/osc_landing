# 📋 Comprehensive Project Overview - Spine Care Landing Page

## 🎯 **Project Purpose**
A professional medical landing page for **Chesterfield S.P.I.N.E. Center** featuring Dr. Amit Bhandarkar, an orthopedic spine surgeon specializing in minimally invasive spine surgery. The website serves as a lead generation and patient engagement platform with comprehensive tracking and analytics.

---

## 🏗️ **Project Architecture**

### **Technology Stack**
- **Frontend**: HTML5, CSS3 (SCSS), JavaScript (jQuery)
- **Backend**: PHP 7.4+
- **Framework**: Bootstrap 5.3.3
- **Animations**: AOS (Animate On Scroll) Library
- **Carousel**: OwlCarousel2
- **Hosting**: GoDaddy (production), MAMP (local development)
- **Form Processing**: Netlify Forms (primary), PHP/Brevo API (backup)
- **Analytics**: Google Tag Manager, Google Analytics, Hotjar
- **Tracking**: Google Sheets via Google Apps Script

---

## 📁 **File Structure**

### **Core Files**
```
lpnew/
├── index.php                    # Main landing page (2036 lines)
├── thank-you.php                # Thank you page after form submission
├── download.php                  # Brochure download page
├── test.php                      # Testing page
├── htaccess                      # Apache rewrite rules
│
├── assets/
│   ├── css/
│   │   ├── style.css            # Main stylesheet (2400+ lines)
│   │   ├── responsive.css        # Mobile responsive styles
│   │   ├── style.scss            # SCSS source file
│   │   └── style.css.map         # Source map
│   ├── js/
│   │   ├── enquiry.js           # Form handling & validation
│   │   └── news.js              # Newsletter & marquee functionality
│   └── images/                  # All website images & icons
│
├── includes/
│   ├── functions.php            # Core PHP functions & site class
│   ├── mail.php                 # Contact form processing
│   ├── newslettermail.php       # Newsletter subscription handler
│   ├── download-brochure.php    # Brochure download handler
│   ├── google-sheets.php        # Google Sheets integration class
│   ├── email.html               # Email template
│   └── credentials/             # API credentials (not in repo)
│
├── netlify-forms/               # Netlify form backend
│   ├── index.html
│   ├── brochure-download.html
│   ├── _redirects
│   └── netlify.toml
│
└── clean-deployment/            # Production-ready deployment package
```

---

## 🎨 **Website Sections & Features**

### **1. Header Section**
- **Top Bar**: Email and phone contact info
- **Main Header**: Logo, Brochure download button, Book Appointment button
- **Sticky Navigation**: Header becomes sticky on scroll

### **2. Hero Section**
- **Headline**: "Expert Spine Care with Compassion In The Heart of Chesterfield"
- **Subheadline**: Highlights minimally invasive procedures, faster recovery, personalized care
- **CTA**: Book Appointment button with pulse animation
- **Background**: Hero image with overlay

### **3. Flash News Marquee**
- Scrolling ticker showing services:
  - Minimally Invasive Spine Surgery
  - Neuromodulation
  - Endoscopic Spine Surgery
  - Same Day Pain Fixing
  - Interventional Pain Management

### **4. Trust Signals Section**
- Visual badges showing:
  - Triple fellowship trained Spine Surgeon
  - 15+ Years of Experience
  - Minimally Invasive, Evidence-Based Treatments
  - Many happy patients (5-star rating)
  - Accepted by Major Insurance Plans & cash pay options

### **5. Conditions We Treat Section**
Organized by categories:
- **Pain**: Back Pain, Neck Pain, SI Joint Pain, Extremity Pain, Chronic Pain, Sciatica, Nerve Pain, Phantom Pain, Cervical Headache
- **Weakness**: Foot Drop, Hand Clumsiness, Claudication
- **Degenerative Conditions**: Degenerative Disc Disease, Disc Herniation, Spondylosis, Facet Joint Arthritis, Spondylolisthesis, Spinal Stenosis
- **Deformity**: Scoliosis, Kyphosis
- **Spinal Fracture/Injury**: Osteoporotic Fractures, Traumatic Spine Fractures, Whiplash Injury
- **Joint Conditions**: Spinal Infections, Sacroiliac Joint Dysfunction, Facet Joint Arthritis
- **Other Symptoms**: Tingling, Numbness, Bladder Problems, Back Spasms, Cramps in Extremities

### **6. Why Chesterfield Section**
- Background with animated gradient overlay
- Highlights:
  - Convenient Location
  - On-site Diagnostic Imaging
  - Personalized Treatment Plans
  - Flexible Scheduling
- Google Maps embed showing clinic location
- Text Now CTA button

### **7. CTA Popup (Scroll-Triggered)**
- Appears when user scrolls to "Meet Doctor" section
- Professional popup with:
  - Close button (X)
  - Compelling headline
  - Book Appointment button
- Can be closed by clicking outside, pressing Escape, or clicking close button
- Only shows once per session

### **8. Meet Your Spine Care Expert Section**
- Doctor's photo and credentials
- Bio highlighting:
  - Triple Fellowship-Trained Spine Surgeon
  - Fellowship-Trained in Minimally Invasive Spine Surgery
  - Globally Trained
  - 15+ Years of Surgical Experience
  - 1,000+ Successful Procedures
- Certifications displayed:
  - American Board of Spine Surgery/AANOS (2020-2021)
  - American Board of Spine Surgery/ISASS (2018)
  - AO Spine Global Diploma Spine Surgery (2022)
- Certificate gallery (6 certificates)

### **9. Our Specialized Treatments Section**
Six treatment cards:
1. **Minimally Invasive Spine Surgery**: Smaller incisions, reduced tissue damage, faster recovery
2. **Endoscopic Spine Surgery**: Advanced camera technology, minimal scarring
3. **Same Day Spine Surgery**: Outpatient procedures, quick recovery
4. **Disc Replacement Surgery**: Preserves motion, long-lasting results
5. **Interventional Pain Management**: Precision-guided injections, spinal cord stimulation
6. **Motion Preserving Surgery**: Maintains flexibility, long-term relief

### **10. CTA Section**
- Prominent call-to-action box
- "Call Now" button (tracked)
- "Book Appointment" button
- Text Now button

### **11. Testimonials Section**
- 6 patient testimonials with 5-star ratings
- Verified patient reviews
- Responsive grid layout

### **12. Contact Us Section**
- **Location Card**: Full address with Google Maps link
- **Phone Card**: Two phone numbers (DISC and SPINE), Call Us link, Text Now button
- **Email Card**: Email address with Send Email link
- **Contact Form**: Full enquiry form with:
  - Name, Country Code, Phone, Email, Message
  - Privacy Policy checkbox
  - SMS Consent checkbox
  - Netlify honeypot spam protection
- **Google Maps Embed**: Interactive map showing clinic location

### **13. FAQ Section**
- 6 frequently asked questions with expandable answers:
  1. What is Minimally Invasive Spine Surgery?
  2. How do I know if I need spine surgery?
  3. What is the recovery time after spine surgery?
  4. Do you accept insurance?
  5. What conditions do you treat?
  6. What is Endoscopic Spine Surgery?

### **14. Footer**
- **Social Media Links**: Instagram, Facebook, Twitter, LinkedIn
- **Email**: dr.amit@onlinespinecare.com
- **Doctor Info**: Name, credentials, title
- **Newsletter Signup**: Email subscription form
- **Copyright**: Current year, powered by Ensemble Digital Labs

### **15. Floating Elements**
- **WhatsApp Float Button**: Links to WhatsApp chat
- **Floating Call Button**: Animated pulsing phone button (bottom right)

---

## 📝 **Forms & Data Collection**

### **1. Contact/Enquiry Form** (Multiple Instances)
- **Locations**: 
  - Modal popup (triggered by "Book Appointment" buttons)
  - Contact section (main page form)
- **Fields**: Name, Country Code, Phone, Email, Message, Privacy Policy, SMS Consent
- **Submission**: 
  - Primary: Netlify Forms (`https://spinecare-landing-page.netlify.app`)
  - Backup: PHP/Brevo API (`includes/mail.php`)
- **Processing**: 
  - Saves to MySQL database (`landing_page_enquiries` table)
  - Sends to Google Sheets
  - Sends emails via Brevo API to:
    - mgmt@onlinespinecare.com
    - itteam@onlinespinecare.com
    - getupihm@gmail.com
- **Success**: Redirects to `thank-you.php`

### **2. Brochure Download Form**
- **Location**: Modal popup (triggered by "Brochure" button)
- **Fields**: Name, Phone, Email
- **Submission**: Netlify Forms
- **Processing**: 
  - Sends emails via Brevo API
  - Same recipients as contact form
- **Success**: Redirects to `download.php` with brochure PDF link

### **3. Newsletter Subscription Form**
- **Location**: Footer
- **Fields**: Email only
- **Submission**: PHP (`includes/newslettermail.php`)
- **Processing**: 
  - Validates email
  - Sends emails via Brevo API
  - Same recipients as other forms

---

## 🔍 **Tracking & Analytics**

### **Google Tag Manager (GTM)**
- **Container ID**: `GTM-N565GV57`
- **Purpose**: Centralized tag management
- **Implementation**: Both in `<head>` and `<body>` (noscript)

### **Google Analytics**
- **Tracking ID**: `G-FRFXBKHV0W`
- **Purpose**: Page views, user behavior, conversion tracking

### **Hotjar**
- **Site ID**: `6436979`
- **Purpose**: User session recordings, heatmaps, user behavior analysis

### **Button Click Tracking**
- **Method**: Google Apps Script + Google Sheets
- **Script URL**: `https://script.google.com/macros/s/AKfycbyi0qZkYLysrpfAfbJpfpj-Yz4fgwxFnaG3m5A6CE6Rrw4Bqh0DYVK78mCPCNo-qRYyrQ/exec`
- **Spreadsheet ID**: `1cUIs8ffCzwFt7W7H4K-SSAznNNNNrVOdudS4f0tXiww`
- **Tracked Buttons**:
  - "Call Now" buttons (8 locations)
  - "Text Now" buttons (6 locations)
- **Tracked Data**:
  - Timestamp
  - Button Type (Call Now / Text Now)
  - Section Name (where button was clicked)
  - User Agent (browser/device info)
  - Referrer (where user came from)
  - Page URL
  - Action type

### **Form Submission Tracking**
- **Google Sheets Integration**: Via `includes/google-sheets.php`
- **Spreadsheet ID**: `1P9YhiovvD9oqZHeIn-vjwqhiY6GABdH3IUBUbMRj_FA`
- **Data Tracked**: Name, Phone, Email, Message, Timestamp

---

## 🗄️ **Database**

### **MySQL Database**
- **Database Name**: `spinecare_db`
- **User**: `spinecare_user`
- **Table**: `landing_page_enquiries`
- **Columns**: 
  - `id` (auto-increment)
  - `name` (VARCHAR)
  - `email` (VARCHAR)
  - `phone` (VARCHAR)
  - `message` (TEXT)
  - `created_at` (DATETIME)

---

## 📧 **Email System**

### **Brevo (formerly Sendinblue) API**
- **API Key**: `your_brevo_api_key_here` (stored in `.env` file)
- **Sender Email**: `surgeonspine18@gmail.com`
- **Sender Name**: "Spine Care"
- **Template**: `includes/email.html`
- **Recipients**:
  - mgmt@onlinespinecare.com
  - itteam@onlinespinecare.com
  - getupihm@gmail.com

### **Email Types**
1. **Enquiry Emails**: Contact form submissions
2. **Brochure Download Emails**: Brochure form submissions
3. **Newsletter Emails**: Newsletter subscriptions

---

## 🎯 **SEO & Schema Markup**

### **Structured Data (JSON-LD)**
1. **Organization Schema**: MedicalOrganization
   - Name, URL, Logo, Social Media Links
   - Contact Point (phone, area served)

2. **Local Business Schema**: MedicalClinic
   - Address, Phone, Opening Hours
   - Medical Specialty, Available Services

3. **Medical Conditions Schema**: Multiple conditions
   - Back Pain, Neck Pain, SI Joint Pain, etc.
   - Each with description, associated anatomy, possible treatments

4. **Service Schemas**: 6 services
   - Minimally Invasive Spine Surgery
   - Neuromodulation
   - Endoscopic Spine Surgery
   - Same Day Pain Fixing
   - Interventional Pain Management
   - Conservative Spine Care

5. **FAQ Schema**: FAQPage
   - 6 common questions with answers

### **Meta Tags**
- **Title**: "Spine Care"
- **Viewport**: Responsive design
- **Favicon**: `assets/images/favicon.png`

---

## 🎨 **Design & Styling**

### **Color Scheme**
- **Primary Orange**: `#FF7537` (CTA buttons, highlights)
- **Blue Gradient**: Used in banners and sections
- **White/Black**: Text and backgrounds
- **Grey**: Secondary text and borders

### **Typography**
- **Primary Font**: Plus Jakarta Sans (Google Fonts)
- **Secondary Font**: Poppins (Google Fonts)
- **Icons**: Bootstrap Icons, Font Awesome

### **Responsive Breakpoints**
- Mobile: < 768px
- Tablet: 768px - 991px
- Desktop: > 992px

### **Animations**
- **AOS Library**: Fade-up, fade-right, fade-left animations
- **Pulse Animation**: Call-to-action buttons
- **Marquee**: Scrolling services ticker
- **Smooth Scroll**: Page navigation

---

## 🔧 **JavaScript Functionality**

### **jQuery Plugins**
- **OwlCarousel2**: Testimonials carousel (if implemented)
- **jQuery Marquee**: Scrolling ticker
- **Bootstrap 5**: Modal dialogs, form validation

### **Custom Functions**
1. **`trackButtonClick(buttonType, section)`**
   - Tracks button clicks to Google Sheets
   - Captures user data (UA, referrer, timestamp)
   - Non-blocking (doesn't interfere with button action)

2. **CTA Popup Management**
   - `showCTAPopup()`: Shows popup on scroll
   - `closeCTAPopup()`: Closes popup
   - `bookAppointmentFromPopup()`: Opens appointment modal

3. **FAQ Toggle**
   - Expand/collapse FAQ items
   - Only one open at a time

4. **Sticky Header**
   - Header becomes sticky on scroll
   - Smooth transition

5. **Form Handling** (`enquiry.js`)
   - Prevents double submission
   - Form validation
   - AJAX submission to Netlify
   - Error handling
   - Success redirects

6. **Newsletter** (`news.js`)
   - Email validation
   - AJAX submission
   - Success/error messages

---

## 📱 **Mobile Features**

### **Responsive Design**
- Mobile-first approach
- Touch-friendly buttons
- Responsive images
- Collapsible navigation
- Mobile-optimized forms

### **Mobile-Specific Elements**
- Floating WhatsApp button
- Floating call button (pulsing animation)
- Touch-friendly CTA buttons
- Mobile-optimized maps

---

## 🔐 **Security Features**

### **Form Security**
- **Honeypot Fields**: Netlify forms include hidden bot-field
- **Input Sanitization**: PHP `esc()` function sanitizes all inputs
- **Email Validation**: Server-side email validation
- **CSRF Protection**: Form tokens (via Netlify)

### **API Security**
- **Credentials Storage**: API keys stored in `includes/credentials/` (not in repo)
- **Error Handling**: Graceful error handling without exposing sensitive info
- **HTTPS**: All external API calls use HTTPS

---

## 🚀 **Deployment**

### **Production Environment**
- **Hosting**: GoDaddy
- **Domain**: `onlinespinecare.com/lpnew`
- **PHP Version**: 7.4+ (recommended)
- **File Permissions**: 644 (files), 755 (directories)

### **Deployment Package**
- **Clean Deployment Folder**: `clean-deployment/`
- **Includes**: All essential files without git history
- **Size**: ~18.5 MB (optimized)

### **Deployment Checklist**
1. ✅ Upload all files maintaining folder structure
2. ✅ Set proper file permissions
3. ✅ Configure `.htaccess` for URL rewriting
4. ✅ Set up Google Apps Script for tracking
5. ✅ Configure Google Sheets
6. ✅ Test all forms
7. ✅ Verify tracking functionality
8. ✅ Test on multiple devices/browsers

---

## 📊 **Third-Party Integrations**

### **Netlify Forms**
- **Endpoint**: `https://spinecare-landing-page.netlify.app`
- **Purpose**: Reliable form processing
- **Features**: Spam protection, email notifications, CSV export

### **Google Services**
- **Google Maps**: Clinic location embedding
- **Google Sheets**: Data storage and analytics
- **Google Apps Script**: Serverless backend for tracking

### **Brevo API**
- **Purpose**: Transactional email sending
- **Features**: HTML email templates, delivery tracking

---

## 🎯 **Business Information**

### **Clinic Details**
- **Name**: Chesterfield S.P.I.N.E. Center
- **Doctor**: Dr. Amit Bhandarkar, M.D.
- **Specialty**: Orthopedic Spine Surgeon
- **Location**: 
  - Clarkson Executive Building
  - 16216 Baxter Road, Suite 110
  - Chesterfield, MO 63017
- **Phone**: 636-893-8243 (DISC) / 636-893-8243 (SPINE)
- **Email**: dr.amit@onlinespinecare.com
- **Hours**: Monday to Friday, 8:00 AM - 4:00 PM

### **Social Media**
- **Instagram**: @s.p.i.n.e_care
- **Facebook**: Profile ID 61556835675703
- **Twitter**: @dr_bhandarkar_

---

## 🔄 **Data Flow**

### **Contact Form Submission Flow**
1. User fills form → JavaScript intercepts submission
2. Form data sent to Netlify Forms (primary)
3. Parallel processing:
   - Netlify stores submission
   - PHP saves to MySQL database
   - Google Sheets updated
   - Brevo sends emails to 3 recipients
4. User redirected to thank-you page

### **Button Click Tracking Flow**
1. User clicks tracked button
2. `trackButtonClick()` function executes
3. Data collected (timestamp, button type, section, UA, referrer)
4. Data sent to Google Apps Script via fetch API
5. Google Apps Script appends data to Google Sheet
6. Button action continues (call/text initiated)

---

## 📈 **Performance Optimizations**

### **Code Optimizations**
- Minified CSS/JS where possible
- Lazy loading for images
- CDN for external libraries (Bootstrap, jQuery, etc.)
- Async loading for analytics scripts

### **Caching**
- Browser caching via `.htaccess`
- Static asset versioning (`?v=0.001`)

---

## 🐛 **Known Issues & Solutions**

### **Button Tracking**
- **Issue**: Google Apps Script URL may need updating
- **Solution**: Deploy script and update URL in `index.php`

### **Form Submissions**
- **Issue**: Netlify forms may have CORS restrictions
- **Solution**: Using `no-cors` mode in fetch requests

### **Email Delivery**
- **Issue**: Brevo API key may expire
- **Solution**: Update credentials in `includes/functions.php`

---

## 📚 **Documentation Files**

1. **DEPLOYMENT_CHECKLIST.md**: Step-by-step deployment guide
2. **DEPLOYMENT_SUMMARY.md**: Overview of deployment package
3. **GOOGLE_SHEETS_SETUP.md**: Google Sheets tracking setup
4. **FINAL_VERIFICATION.md**: Post-deployment testing checklist
5. **QUICK_FIX_GUIDE.md**: Troubleshooting common issues

---

## 🎓 **Key Features Summary**

✅ **Professional Medical Landing Page**
✅ **Comprehensive Condition Information**
✅ **Multiple Contact Methods** (Phone, Email, Text, WhatsApp)
✅ **Form Tracking & Analytics**
✅ **Button Click Analytics**
✅ **SEO Optimized** (Schema markup, meta tags)
✅ **Mobile Responsive**
✅ **Email Integration** (Brevo API)
✅ **Database Storage** (MySQL)
✅ **Google Sheets Integration**
✅ **Scroll-Triggered CTA Popup**
✅ **Patient Testimonials**
✅ **Certificate Gallery**
✅ **Interactive Google Maps**
✅ **FAQ Section**
✅ **Newsletter Signup**
✅ **Social Media Integration**

---

## 🔮 **Future Enhancements**

Potential improvements:
- Online appointment scheduling system
- Patient portal integration
- Live chat functionality
- Video testimonials
- Blog section
- Multi-language support
- Advanced analytics dashboard
- A/B testing capabilities

---

**Last Updated**: Based on current codebase analysis
**Maintained By**: Ensemble Digital Labs
**Project Status**: Production Ready ✅

