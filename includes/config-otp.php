<?php
/**
 * OTP Verification System Configuration
 * Contains reCAPTCHA keys and OTP settings
 */

// Google reCAPTCHA Configuration
define('RECAPTCHA_SECRET_KEY', '6LfvdVcqAAAAAPrvqj0TJ0zEE157czfK4F1WXXc35');
define('RECAPTCHA_SITE_KEY', '6LfvdVcqAAAAABlZbwDh0MKP9LpT10JKxPSqEYqG');

// OTP Configuration
define('OTP_EXPIRATION_TIME', 300); // 5 minutes in seconds
define('OTP_LENGTH', 6);
define('OTP_MIN', 100000);
define('OTP_MAX', 999999);

// OTP Verification Validity (after OTP is verified, form can be submitted within this time)
define('OTP_VERIFICATION_VALIDITY', 600); // 10 minutes in seconds

// Session Configuration for OTP
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load environment variables if .env file exists
$envPath = dirname(__DIR__) . '/.env';
if (file_exists($envPath)) {
    if (class_exists('Dotenv\Dotenv')) {
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    }
}

?>

