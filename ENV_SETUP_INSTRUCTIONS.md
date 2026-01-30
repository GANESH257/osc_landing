# .env File Setup Instructions

## Important Note

The `.env` file was not created automatically due to security restrictions. You need to create it manually.

## Steps to Create .env File

1. **Create a new file** named `.env` in the root directory (`/Applications/MAMP/htdocs/lpnew/`)

2. **Copy the following content** into the `.env` file:

```env
# ============================================
# OTP VERIFICATION SYSTEM - ENVIRONMENT VARIABLES
# ============================================
# DO NOT commit this file to version control - it contains sensitive data

# ============================================
# RINGCENTRAL SMS API CONFIGURATION
# ============================================
RC_APP_CLIENT_ID=Vio69rKiOYzeUD1HzN9CB4
RC_APP_CLIENT_SECRET=1cKNRePU0yYcdq9atQr3MzaKl8pytt2YXcqrghDqnjYC
RC_SERVER_URL=https://platform.ringcentral.com
RC_USER_JWT=eyJraWQiOiI4NzYyZjU5OGQwNTk0NGRiODZiZjVjYTk3ODA0NzYwOCIsInR5cCI6IkpXVCIsImFsZyI6IlJTMjU2In0.eyJhdWQiOiJodHRwczovL3BsYXRmb3JtLnJpbmdjZW50cmFsLmNvbS9yZXN0YXBpL29hdXRoL3Rva2VuIiwic3ViIjoiOTM3ODUwMDM1IiwiaXNzIjoiaHR0cHM6Ly9wbGF0Zm9ybS5yaW5nY2VudHJhbC5jb20iLCJleHAiOjE5MjQ5OTE5OTksImlhdCI6MTc0NzExNTA3OSwianRpIjoiUUwwaHZtN0hSdi1YZGpxbUhTOWpBZyJ9.QXtcc8tcuhhemRyQeFWMxZidCcBHr1bNsH1XYOlLoZ5PQFzgtuJ5XXZOp8vZ3jZReIUltCVsLp051_8Znss4C9-NE2Qy_95CzhkhIwDj6Mm1T0daGJpmLO7AER_ufkYXwLB34zmXMpRENmTVpJ28WNx1sJNoRRCRqzdNjfZ0tVyVxE0P-Feqlg1l04fbxr0fUsapX1kQZqEB0jUKv5JVqxdKk9ZNNvO4NoXBtTUv1mx98txbRzZvquMEl97WuII9WN01Ev08r8MJbboFELkoeKsTc0ctqQMPzRIemaNaH99n5e-x5zG6DiSeKKDhbY0etB0cBlG9Wx2KwTxYKvu0JA

# ============================================
# BREVO EMAIL API CONFIGURATION
# ============================================
BREVO_API_KEY=your_brevo_api_key_here
BREVO_SENDER_EMAIL=surgeonspine18@gmail.com
BREVO_API_ENDPOINT=https://api.brevo.com/v3/smtp/email

# ============================================
# GOOGLE RECAPTCHA CONFIGURATION
# ============================================
RECAPTCHA_SITE_KEY=6LfvdVcqAAAAABlZbwDh0MKP9LpT10JKxPSqEYqG
RECAPTCHA_SECRET_KEY=6LfvdVcqAAAAAPrvqj0TJ0zEE157czfK4F1WXXc35

# ============================================
# OTP CONFIGURATION
# ============================================
OTP_EXPIRATION_TIME=300
OTP_LENGTH=6
OTP_MIN=100000
OTP_MAX=999999

# ============================================
# SESSION CONFIGURATION
# ============================================
SESSION_SAVE_PATH=session_data_files
SESSION_LIFETIME=300
```

3. **Set file permissions** (recommended):
   ```bash
   chmod 600 .env
   ```

4. **Add to .gitignore** (if using git):
   ```bash
   echo ".env" >> .gitignore
   ```

## Install Composer Dependencies

After creating the `.env` file, install the required PHP packages:

```bash
cd /Applications/MAMP/htdocs/lpnew
composer install
```

This will install:
- RingCentral PHP SDK (for SMS)
- Dotenv (for environment variables)

## Verify Installation

1. Check that `vendor/` directory exists
2. Check that `vendor/autoload.php` file exists
3. Test OTP sending functionality

## Troubleshooting

If you encounter issues:
- Ensure `.env` file is in the root directory
- Check file permissions on `.env`
- Verify Composer dependencies are installed
- Check PHP error logs for detailed error messages

