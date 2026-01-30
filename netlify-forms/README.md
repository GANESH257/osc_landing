# Spine Care Landing Page - Netlify Forms

This repository contains the Netlify forms backend for the Chesterfield S.P.I.N.E. Center landing page.

## Structure

- `index.html` - Main contact form page
- `brochure-download.html` - Brochure download form
- `_redirects` - Netlify redirects configuration
- `netlify.toml` - Netlify build configuration

## Forms

### 1. Contact Form (`index.html`)
- **Form Name**: `modal-contact`
- **Fields**: Name, Country Code, Phone, Email, Message, Privacy Policy, SMS Consent
- **Purpose**: General enquiries and appointment requests

### 2. Brochure Download Form (`brochure-download.html`)
- **Form Name**: `brochure-download`
- **Fields**: Name, Phone, Email
- **Purpose**: Download spine care brochure

## Deployment

This repository is automatically deployed to Netlify at:
`https://spinecare-landing-page.netlify.app`

## Integration

The main website (hosted on GoDaddy) submits forms to this Netlify endpoint for reliable form processing and data storage.

## Form Processing

All form submissions are:
1. Stored in Netlify dashboard
2. Can be exported to CSV
3. Can trigger webhooks for email notifications
4. Protected against spam with honeypot fields 