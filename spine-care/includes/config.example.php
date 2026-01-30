<?php
/**
 * Configuration template file
 * Copy this file to config.php and fill in your actual credentials
 * DO NOT COMMIT config.php - it's in .gitignore
 */

// Brevo (Sendinblue) API Configuration
define('BREVO_API_KEY', 'your-brevo-api-key-here');
define('BREVO_API_ENDPOINT', 'https://api.brevo.com/v3/smtp/email');
define('BREVO_SENDER_EMAIL', 'your-email@example.com');
define('BREVO_SENDER_NAME', 'Spine Care');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');
