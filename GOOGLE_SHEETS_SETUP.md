# Google Sheets Button Click Tracking Setup Guide

## 🚀 **Step-by-Step Setup**

### **1. Create Google Spreadsheet**
1. Go to [Google Sheets](https://sheets.google.com)
2. Create a new spreadsheet
3. Name it "Button Click Tracking" or similar
4. Copy the **Spreadsheet ID** from the URL (the long string between /d/ and /edit)

### **2. Set Up Google Apps Script**
1. Go to [Google Apps Script](https://script.google.com)
2. Create a new project
3. Replace the default code with the content from `google-sheets-tracking.gs`
4. **Important**: Replace `'YOUR_SPREADSHEET_ID'` with your actual spreadsheet ID

### **3. Deploy as Web App**
1. Click **Deploy** → **New deployment**
2. Choose **Web app** as type
3. Set **Execute as**: "Me" (your Google account)
4. Set **Who has access**: "Anyone"
5. Click **Deploy**
6. **Copy the Web App URL** (you'll need this)

### **4. Update Your Website**
1. In the `trackButtonClick` function in `index.php`
2. Replace `'YOUR_SCRIPT_ID'` with your actual Web App URL
3. The URL should look like: `https://script.google.com/macros/s/ACTUAL_ID/exec`

### **5. Test the Setup**
1. Deploy your website
2. Click any "Call Now" or "Text Now" button
3. Check your Google Sheet for new entries

## 📊 **Data Being Tracked**

Each button click records:
- **Date Recorded**: When the data was saved to sheets
- **Timestamp**: Exact time of button click
- **Button Type**: "Call Now" or "Text Now"
- **Section**: Which section of the page (e.g., "CTA Section", "Pain Warning Section")
- **User Agent**: Browser and device information
- **Referrer**: Where the user came from
- **Page URL**: Current page URL
- **Action**: Always "button_click"
- **User Email**: If available (usually "Anonymous")

## 🔧 **Customization Options**

### **Add More Tracking Data**
You can modify the `trackButtonClick` function to capture:
- User's location (if they allow it)
- Screen resolution
- Time spent on page before clicking
- Previous button clicks in the same session

### **Modify Sheet Structure**
Edit the `createSheet()` function to:
- Add new columns
- Change column names
- Modify formatting
- Add data validation

### **Set Up Automated Reports**
Use Google Sheets built-in features to:
- Create pivot tables
- Generate charts
- Set up email alerts
- Export data to other tools

## 🚨 **Important Notes**

1. **Rate Limits**: Google Apps Script has daily quotas
2. **Security**: The web app is public, but only accepts POST requests
3. **Data Privacy**: Ensure compliance with privacy laws
4. **Backup**: Regularly export your tracking data

## 📱 **Testing**

### **Test All Buttons**
- Call Now buttons (2 locations)
- Text Now buttons (6 locations)
- Book Appointment buttons
- CTA popup button

### **Verify Data**
Check that each click creates a new row with:
- Correct button type
- Correct section name
- Proper timestamp
- User agent information

## 🎯 **Analytics Insights**

With this tracking, you can analyze:
- **Most clicked buttons** (Call vs Text)
- **Best performing sections** (where users are most engaged)
- **User journey** (which sections lead to actions)
- **Device/browser patterns** (mobile vs desktop usage)
- **Traffic sources** (where your visitors come from)

## 🔄 **Maintenance**

### **Monthly Tasks**
- Review data for anomalies
- Clean up old data (automatic with trigger)
- Check script execution logs
- Update tracking if needed

### **Troubleshooting**
- If tracking stops working, check script execution logs
- Verify the web app URL is correct
- Ensure the spreadsheet ID is correct
- Check that the sheet name is "Button Clicks"

## 💡 **Pro Tips**

1. **Use Google Data Studio** to create beautiful dashboards
2. **Set up alerts** for unusual activity patterns
3. **Export data** to other analytics tools
4. **A/B test** different button placements and text
5. **Track conversion rates** from clicks to actual calls/texts

---

**Need Help?** Check the Google Apps Script logs for any error messages, or verify that your spreadsheet ID and web app URL are correctly configured.
