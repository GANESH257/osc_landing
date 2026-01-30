<?php
/**
 * Verify OTP Handler
 * Verifies entered OTP against session-stored OTP
 */

require_once(__DIR__ . '/config-otp.php');

header('Content-Type: application/json');

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$enteredOtp = isset($_POST['otp']) ? trim($_POST['otp']) : '';
$validOtp = isset($_SESSION['sent_otp']) ? $_SESSION['sent_otp'] : null;
$expiresAt = isset($_SESSION['otp_expire']) ? $_SESSION['otp_expire'] : 0;

// Check if OTP exists
if ($validOtp === null) {
    echo json_encode(['success' => false, 'error' => 'No OTP found. Please request a new verification code.']);
    exit;
}

// Check if OTP expired
if (time() > $expiresAt) {
    // Clear expired OTP
    unset($_SESSION['sent_otp']);
    unset($_SESSION['otp_expire']);
    unset($_SESSION['otp_email']);
    unset($_SESSION['otp_phone']);
    unset($_SESSION['otp_country']);
    echo json_encode(['success' => false, 'error' => 'OTP expired. Please request a new verification code.']);
    exit;
}

// Validate OTP format (6 digits)
if (!preg_match('/^\d{6}$/', $enteredOtp)) {
    echo json_encode(['success' => false, 'error' => 'Invalid OTP format. Please enter a 6-digit code.']);
    exit;
}

// Verify OTP
if ($enteredOtp == $validOtp) {
    $_SESSION['otp_verified'] = true;
    $_SESSION['otp_verified_at'] = time();
    echo json_encode(['success' => true, 'msg' => 'OTP verified successfully.']);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid OTP. Please try again.']);
}

?>

