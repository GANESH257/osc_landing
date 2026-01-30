<?php
/**
 * Form Submission OTP Validation Handler
 * Checks if OTP was verified before allowing form submission
 * This can be called as a pre-validation step before submitting to Netlify
 */

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/config-otp.php');

header('Content-Type: application/json');

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$response = new stdClass();
$response->status = "error";
$response->message = "";

// Check if OTP was verified
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    echo json_encode(['status' => 'error', 'error' => 'OTP verification required. Please verify your code first.']);
    exit;
}

// Check if OTP verification is still valid (within 10 minutes)
if (isset($_SESSION['otp_verified_at']) && (time() - $_SESSION['otp_verified_at']) > OTP_VERIFICATION_VALIDITY) {
    unset($_SESSION['otp_verified']);
    unset($_SESSION['otp_verified_at']);
    echo json_encode(['status' => 'error', 'error' => 'OTP verification expired. Please verify again.']);
    exit;
}

// Verify reCAPTCHA if token is provided
if (isset($_POST['recaptcha_token']) && !empty($_POST['recaptcha_token'])) {
    $token = $site->esc($_POST['recaptcha_token']);
    $respCaptcha = $site->getGooglecaptchaResponse($token);
    
    if (!$respCaptcha) {
        echo json_encode(['status' => 'error', 'error' => 'reCAPTCHA verification failed.']);
        exit;
    }
}

// If we get here, OTP is verified and valid
$response->status = 'success';
$response->message = 'OTP verified. Form can be submitted.';

// Optional: Clear OTP session data after successful validation
// Uncomment if you want to clear after validation (recommended for security)
// unset($_SESSION['sent_otp']);
// unset($_SESSION['otp_expire']);
// unset($_SESSION['otp_verified']);
// unset($_SESSION['otp_verified_at']);

echo json_encode($response);

?>

