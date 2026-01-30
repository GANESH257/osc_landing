# 🚀 GoDaddy Deployment Checklist for Google Sheets Tracking

## ✅ **Pre-Deployment Verification**

### **1. Google Apps Script Setup**
- [ ] Google Apps Script deployed as web app
- [ ] Web app URL copied correctly: `AKfycbxjvi4Kisur3ihlZVv8PmJesO61mSAvLG4-xzWgursoXpSTM_TZdIQDVQAUFxBrVcuAGw`
- [ ] Web app set to "Anyone" access
- [ ] Script execution logs checked for errors

### **2. Google Spreadsheet Setup**
- [ ] New spreadsheet created: "Button Click Tracking"
- [ ] Spreadsheet ID copied from URL
- [ ] Sheet named "Button Clicks" created
- [ ] Headers formatted and frozen

### **3. Website Files Updated**
- [ ] `index.php` - All button tracking added
- [ ] `assets/css/style.css` - CTA popup styles added
- [ ] Button click functions working
- [ ] No JavaScript errors in browser console

## 📁 **Files to Upload to GoDaddy**

### **Core Files:**
- `index.php` (main landing page with tracking)
- `assets/css/style.css` (updated with popup styles)
- `assets/css/responsive.css` (existing responsive styles)
- `assets/css/style.scss` (source SCSS file)
- `assets/js/enquiry.js` (existing form handling)
- `assets/js/news.js` (existing functionality)

### **Assets:**
- `assets/images/` (all images)
- `assets/css/` (all CSS files)
- `assets/js/` (all JavaScript files)

### **Supporting Files:**
- `includes/` (PHP backend files)
- `htaccess` (server configuration)
- `favicon.ico` (if exists)

## 🔧 **GoDaddy-Specific Considerations**

### **1. File Permissions**
- Set PHP files to 644
- Set directories to 755
- Ensure `.htaccess` is readable

### **2. PHP Version**
- GoDaddy supports PHP 7.4+ (recommended)
- Check your hosting plan PHP version
- Update if needed for better performance

### **3. SSL Certificate**
- Ensure HTTPS is enabled
- Mixed content warnings can break tracking
- All resources should load over HTTPS

### **4. CORS Issues**
- GoDaddy may have CORS restrictions
- Google Apps Script handles this with `mode: 'no-cors'`
- Test tracking after deployment

## 🧪 **Testing After Deployment**

### **1. Basic Functionality**
- [ ] Website loads without errors
- [ ] All buttons visible and clickable
- [ ] CTA popup appears on scroll
- [ ] Forms submit correctly

### **2. Tracking Functionality**
- [ ] Click any "Call Now" button
- [ ] Click any "Text Now" button
- [ ] Check Google Sheet for new entries
- [ ] Verify data accuracy

### **3. Cross-Browser Testing**
- [ ] Chrome/Edge (desktop)
- [ ] Safari (desktop)
- [ ] Mobile browsers
- [ ] Different screen sizes

## 🚨 **Common Issues & Solutions**

### **1. Tracking Not Working**
- Check browser console for JavaScript errors
- Verify Google Apps Script URL is correct
- Ensure Google Sheet has correct permissions
- Check GoDaddy error logs

### **2. CTA Popup Not Showing**
- Verify CSS files uploaded correctly
- Check for JavaScript conflicts
- Test scroll functionality
- Ensure AOS library loaded

### **3. Button Clicks Not Recording**
- Verify Google Apps Script is deployed
- Check web app permissions
- Test with simple button click
- Monitor Google Apps Script execution logs

## 📊 **Post-Deployment Monitoring**

### **First 24 Hours:**
- Monitor Google Sheet for tracking data
- Check website performance
- Verify all buttons working
- Test on different devices

### **First Week:**
- Analyze click patterns
- Check for any tracking gaps
- Monitor server performance
- Gather user feedback

### **Ongoing:**
- Weekly data review
- Monthly performance check
- Quarterly optimization review
- Annual data cleanup

## 🎯 **Success Metrics**

### **Immediate:**
- [ ] All buttons track clicks
- [ ] Data appears in Google Sheet
- [ ] No JavaScript errors
- [ ] Website loads normally

### **Short-term (1 week):**
- [ ] Consistent tracking data
- [ ] No missing clicks
- [ ] Performance maintained
- [ ] User experience smooth

### **Long-term (1 month):**
- [ ] Meaningful analytics data
- [ ] Insights for optimization
- [ ] Conversion tracking working
- [ ] ROI measurement possible

---

## 🆘 **Need Help?**

1. **Check GoDaddy Error Logs** in cPanel
2. **Verify Google Apps Script** execution logs
3. **Test tracking locally** before uploading
4. **Use browser developer tools** to debug
5. **Contact support** if issues persist

**Remember:** The tracking will work as long as your Google Apps Script is properly deployed and accessible from the internet!
