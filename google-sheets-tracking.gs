// Google Apps Script for Button Click Tracking
// Deploy this as a web app to track button clicks from your website

// Configuration
const SPREADSHEET_ID = '1cUIs8ffCzwFt7W7H4K-SSAznNNNNrVOdudS4f0tXiww';
const SHEET_NAME = 'Button Clicks';

function doPost(e) {
  try {
    // Get the data from the POST request
    const data = JSON.parse(e.postData.contents);
    
    // Get the active spreadsheet (you'll need to create this)
    const spreadsheet = SpreadsheetApp.openById(SPREADSHEET_ID);
    const sheet = spreadsheet.getSheetByName(SHEET_NAME);
    
    // Prepare row data
    const rowData = [
      new Date(), // Current timestamp
      data.timestamp || '',
      data.buttonType || '',
      data.section || '',
      data.userAgent || '',
      data.referrer || '',
      data.pageUrl || '',
      data.action || '',
      Session.getActiveUser().getEmail() || 'Anonymous' // User email if available
    ];
    
    // Append the data to the sheet
    sheet.appendRow(rowData);
    
    // Return success response
    return ContentService
      .createTextOutput(JSON.stringify({ 'status': 'success', 'message': 'Data recorded' }))
      .setMimeType(ContentService.MimeType.JSON);
      
  } catch (error) {
    // Return error response
    return ContentService
      .createTextOutput(JSON.stringify({ 'status': 'error', 'message': error.toString() }))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

function doGet(e) {
  // Handle GET requests (optional, for testing)
  return ContentService
    .createTextOutput('Button tracking service is running')
    .setMimeType(ContentService.MimeType.TEXT);
}

function createSheet() {
  // Function to create the tracking sheet with headers
  const spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  const sheet = spreadsheet.insertSheet(SHEET_NAME);
  
  // Set up headers
  const headers = [
    'Date Recorded',
    'Timestamp',
    'Button Type',
    'Section',
    'User Agent',
    'Referrer',
    'Page URL',
    'Action',
    'User Email'
  ];
  
  sheet.getRange(1, 1, 1, headers.length).setValues([headers]);
  
  // Format headers
  sheet.getRange(1, 1, 1, headers.length)
    .setFontWeight('bold')
    .setBackground('#4285f4')
    .setFontColor('white');
  
  // Auto-resize columns
  sheet.autoResizeColumns(1, headers.length);
  
  // Freeze header row
  sheet.setFrozenRows(1);
  
  return sheet;
}

function setupTriggers() {
  // Optional: Set up automatic cleanup of old data
  ScriptApp.newTrigger('cleanupOldData')
    .timeBased()
    .everyDays(30)
    .create();
}

function cleanupOldData() {
  // Clean up data older than 1 year
  const spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
  const sheet = spreadsheet.getSheetByName(SHEET_NAME);
  
  if (!sheet) return;
  
  const data = sheet.getDataRange().getValues();
  const cutoffDate = new Date();
  cutoffDate.setFullYear(cutoffDate.getFullYear() - 1);
  
  let rowsToDelete = [];
  
  for (let i = data.length - 1; i > 0; i--) { // Start from bottom, skip header
    const rowDate = new Date(data[i][0]);
    if (rowDate < cutoffDate) {
      rowsToDelete.push(i + 1); // +1 because sheet rows are 1-indexed
    }
  }
  
  // Delete old rows (in reverse order to maintain indices)
  for (let i = rowsToDelete.length - 1; i >= 0; i--) {
    sheet.deleteRow(rowsToDelete[i]);
  }
}
