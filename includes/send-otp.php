<?php
/**
 * Send OTP Handler
 * Generates 6-digit OTP and sends via SMS (US) or Email (others)
 */

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/config-otp.php');

// Load Composer autoloader if available
$vendorPath = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($vendorPath)) {
    require_once($vendorPath);
}

header('Content-Type: application/json');

// Input sanitization function
function esc($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Check if required fields are present
if (!isset($_POST['countryCode'], $_POST['phone'], $_POST['email'])) {
    echo json_encode(['success' => false, 'error' => 'Required fields missing.']);
    exit;
}

$countryCode = esc($_POST['countryCode']); // Format: +1, +44, +91, etc.
$email = esc($_POST['email']);
$phone = esc($_POST['phone']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email address.']);
    exit;
}

// Map country code to shortcode for SMS detection
$countryCodeMap = [
    '+1' => 'US',  // US and Canada both use +1, treat as US for SMS
    '+44' => 'UK',
    '+91' => 'IN'
];

// Determine if US (for SMS) or other (for Email)
$shortcode = isset($countryCodeMap[$countryCode]) ? $countryCodeMap[$countryCode] : 'OTHER';
$isUS = ($shortcode === 'US');

// Log routing decision
error_log('OTP Routing - CountryCode: ' . $countryCode . ', Shortcode: ' . $shortcode . ', IsUS: ' . ($isUS ? 'YES' : 'NO'));

// Generate 6-digit OTP
$otp = rand(OTP_MIN, OTP_MAX);

// Store in session with 5-minute expiration
$_SESSION['sent_otp'] = $otp;
$_SESSION['otp_expire'] = time() + OTP_EXPIRATION_TIME;
$_SESSION['otp_email'] = $email;
$_SESSION['otp_phone'] = $phone;
$_SESSION['otp_country'] = $countryCode;

// Check if running on localhost (for testing)
$host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
$isLocalhost = preg_match('/localhost|127\.0\.0\.1|8888/', $host);

// Send OTP based on country code
if ($isUS) {
    // For localhost testing: return OTP directly without calling APIs
    if ($isLocalhost) {
        echo json_encode([
            'success' => true, 
            'msg' => 'TEST MODE: Your verification code is ' . $otp . '. (SMS sending skipped on localhost - add your IP to Brevo authorized IPs for production)',
            'method' => 'SMS',
            'test_mode' => true,
            'otp' => $otp
        ]);
        exit;
    }
    
    // SMS via RingCentral for US numbers (production only)
    try {
        // Load environment variables
        $envPath = dirname(__DIR__) . '/.env';
        if (!file_exists($envPath)) {
            throw new Exception('Environment file not found. Please create .env file with RingCentral credentials.');
        }

        if (class_exists('Dotenv\Dotenv')) {
            $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
        }

        // Check if RingCentral SDK is available
        if (!class_exists('RingCentral\SDK\SDK')) {
            throw new Exception('RingCentral SDK not installed. Please run: composer install');
        }

        $account = new site();
        $countryData = $account->getCountryDetails('US', $account->getCountryCode());

        if (!$countryData) {
            throw new Exception('Invalid country code');
        }

        $recipient = $countryCode . $phone; // Format: +11234567890

        // RingCentral configuration (hardcoded values)
        $accountId = '937848035';
        $extensionId = '937850035';
        $fromNumber = '+16362524468';

        $text = "Your verification code for the Spine Care form is $otp. Enter it on the site to complete your submission.";

        $body = [
            'from' => ['phoneNumber' => $fromNumber],
            'to' => [['phoneNumber' => $recipient]],
            'text' => $text
        ];

        // Get credentials from environment
        $clientId = $_ENV['RC_APP_CLIENT_ID'] ?? getenv('RC_APP_CLIENT_ID');
        $clientSecret = $_ENV['RC_APP_CLIENT_SECRET'] ?? getenv('RC_APP_CLIENT_SECRET');
        $serverUrl = $_ENV['RC_SERVER_URL'] ?? getenv('RC_SERVER_URL') ?? 'https://platform.ringcentral.com';
        $jwtToken = $_ENV['RC_USER_JWT'] ?? getenv('RC_USER_JWT');
        
        // Validate credentials exist
        if (empty($clientId) || empty($clientSecret) || empty($jwtToken)) {
            error_log('RingCentral credentials missing. ClientID: ' . (!empty($clientId) ? 'SET' : 'MISSING') . ', Secret: ' . (!empty($clientSecret) ? 'SET' : 'MISSING') . ', JWT: ' . (!empty($jwtToken) ? 'SET' : 'MISSING'));
            throw new Exception('RingCentral credentials not configured. Please check .env file.');
        }
        
        // Initialize RingCentral SDK
        $rcsdk = new \RingCentral\SDK\SDK($clientId, $clientSecret, $serverUrl);
        
        $platform = $rcsdk->platform();
        
        // Login with JWT
        try {
            // Validate JWT token format (should be a long string without spaces)
            if (empty($jwtToken) || strlen($jwtToken) < 100) {
                error_log('RingCentral JWT token appears to be invalid or truncated. Length: ' . strlen($jwtToken));
                throw new Exception('RingCentral JWT token is invalid or incomplete. Please check .env file.');
            }
            
            // Remove any whitespace/newlines that might have been added
            $jwtToken = trim($jwtToken);
            
            $platform->login(["jwt" => $jwtToken]);
            error_log('RingCentral login successful');
        } catch (\RingCentral\SDK\Http\ApiException $loginError) {
            $errorMsg = $loginError->getMessage();
            error_log('RingCentral login failed: ' . $errorMsg);
            error_log('RingCentral login error response: ' . json_encode($loginError->getResponse()));
            
            // Check for specific JWT errors
            if (stripos($errorMsg, 'unparseable') !== false || stripos($errorMsg, 'invalid') !== false) {
                throw new Exception('RingCentral JWT token is invalid or expired. Please check .env file and ensure the full token is present (no truncation).');
            }
            throw new Exception('RingCentral authentication failed: ' . $errorMsg);
        } catch (Exception $loginError) {
            error_log('RingCentral login exception: ' . $loginError->getMessage());
            throw new Exception('RingCentral authentication failed: ' . $loginError->getMessage());
        }

        // Send SMS
        try {
            $response = $platform->post("/restapi/v1.0/account/{$accountId}/extension/{$extensionId}/sms", $body);
            error_log('SMS sent successfully to: ' . $recipient . ', Response: ' . json_encode($response->json()));
        } catch (\RingCentral\SDK\Http\ApiException $smsError) {
            error_log('SMS send failed: ' . $smsError->getMessage());
            error_log('SMS error response: ' . json_encode($smsError->getResponse()));
            throw $smsError; // Re-throw to be caught by outer catch
        }

        echo json_encode([
            'success' => true, 
            'msg' => 'Verification code has been sent to your phone number. Please enter it above to verify.',
            'method' => 'SMS'
        ]);
        exit;

    } catch (\RingCentral\SDK\Http\ApiException $e) {
        $errorDetails = $e->getResponse() ? json_encode($e->getResponse()) : 'No response data';
        error_log('RingCentral API Error: ' . $e->getMessage());
        error_log('RingCentral API Error Details: ' . $errorDetails);
        error_log('RingCentral API Error Code: ' . $e->getCode());
        
        // For testing: return OTP in response if on localhost
        if ($isLocalhost) {
            echo json_encode([
                'success' => true, 
                'msg' => 'TEST MODE: Your verification code is ' . $otp . '. (SMS API error: ' . $e->getMessage() . ')',
                'method' => 'SMS',
                'test_mode' => true,
                'otp' => $otp
            ]);
            exit;
        }
        
        // On production: Don't silently fallback to email - show error
        // Only fallback if it's a specific recoverable error
        $errorMessage = $e->getMessage();
        if (stripos($errorMessage, 'unauthorized') !== false || 
            stripos($errorMessage, 'authentication') !== false ||
            stripos($errorMessage, 'invalid') !== false) {
            // Credential/authentication errors - don't fallback, show error
            echo json_encode([
                'success' => false, 
                'error' => 'SMS service configuration error. Please contact support.',
                'debug' => 'RingCentral error: ' . substr($errorMessage, 0, 100)
            ]);
            exit;
        }
        
        // For other errors, try email fallback ONLY if it's a recoverable error
        // Most errors should show error message, not silently fallback
        if (stripos($errorMessage, 'rate limit') !== false || 
            stripos($errorMessage, 'temporarily') !== false ||
            stripos($errorMessage, 'service unavailable') !== false) {
            // Only fallback for temporary/recoverable errors
            error_log('RingCentral SMS failed (temporary error), falling back to email. Error: ' . $errorMessage);
            $isUS = false;
        } else {
            // For other errors, show error message instead of silent fallback
            error_log('RingCentral SMS failed (non-recoverable), NOT falling back. Error: ' . $errorMessage);
            echo json_encode([
                'success' => false, 
                'error' => 'Unable to send SMS. Please try again later or contact support.',
                'debug_info' => 'SMS service error occurred'
            ]);
            exit;
        }
    } catch (Exception $e) {
        error_log('OTP Send Error: ' . $e->getMessage());
        error_log('OTP Send Error Trace: ' . $e->getTraceAsString());
        
        // For localhost: return OTP for testing
        if ($isLocalhost) {
            echo json_encode([
                'success' => true, 
                'msg' => 'TEST MODE: Your verification code is ' . $otp . '. (Error: ' . $e->getMessage() . ')',
                'method' => 'SMS',
                'test_mode' => true,
                'otp' => $otp
            ]);
            exit;
        }
        
        // Check error type - if it's a setup issue, don't fallback
        $errorMessage = $e->getMessage();
        if (stripos($errorMessage, 'not installed') !== false || 
            stripos($errorMessage, 'not found') !== false ||
            stripos($errorMessage, 'Environment file') !== false) {
            echo json_encode([
                'success' => false, 
                'error' => 'SMS service not configured. Please contact support.',
                'debug' => $errorMessage
            ]);
            exit;
        }
        
        // For other errors, check if it's recoverable before falling back
        if (stripos($errorMessage, 'timeout') !== false || 
            stripos($errorMessage, 'connection') !== false ||
            stripos($errorMessage, 'network') !== false) {
            // Network errors - can fallback to email
            error_log('SMS failed (network error), falling back to email. Error: ' . $errorMessage);
            $isUS = false;
        } else {
            // Configuration/setup errors - don't fallback, show error
            error_log('SMS failed (configuration error), NOT falling back. Error: ' . $errorMessage);
            echo json_encode([
                'success' => false, 
                'error' => 'SMS service not available. Please contact support.',
                'debug_info' => $errorMessage
            ]);
            exit;
        }
    }
}

if (!$isUS) {
    // Email via Brevo for non-US numbers or SMS fallback
    try {
        // For localhost testing: return OTP directly
        if ($isLocalhost) {
            echo json_encode([
                'success' => true, 
                'msg' => 'TEST MODE: Your verification code is ' . $otp . '. (Email sending skipped on localhost)',
                'method' => 'Email',
                'test_mode' => true,
                'otp' => $otp
            ]);
            exit;
        }
        
        $account = new site();
        
        $mailContent = '<div style="max-width: 600px; background: #fff; padding: 30px; margin: auto; border-radius: 8px;">
                <p>Hello,</p>
                <p>Your verification code for the Spine Care form is:</p>
                <h1 style="color: #FF7537; font-size: 32px; text-align: center; margin: 20px 0; font-weight: bold;">' . $otp . '</h1>
                <p>Please enter this code on the website to verify your identity. This code is valid for 5 minutes.</p>
                <br>
                <p>Thank you,<br>Spine Care Team</p>
            </div>';

        $resp = $account->brevoMailSend(
            'User', 
            $email, 
            'Verification Code - Spine Care', 
            $mailContent
        );
        
        if($resp){
            echo json_encode([
                'success' => true, 
                'msg' => 'Verification code has been sent to your email. Please enter it above to verify.',
                'method' => 'Email'
            ]);
        } else {
            error_log('Brevo email send returned false for email: ' . $email);
            // Fallback for localhost testing
            if ($isLocalhost) {
                echo json_encode([
                    'success' => true, 
                    'msg' => 'TEST MODE: Your verification code is ' . $otp . '. (Brevo email failed - IP not whitelisted)',
                    'method' => 'Email',
                    'test_mode' => true,
                    'otp' => $otp
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Unable to send verification code. Please try again.']);
            }
        }
        
    } catch (Exception $e) {
        error_log('Email OTP Error: ' . $e->getMessage());
        // On localhost, still return OTP for testing
        if ($isLocalhost) {
            echo json_encode([
                'success' => true, 
                'msg' => 'TEST MODE: Your verification code is ' . $otp . '. (Email error: ' . $e->getMessage() . ')',
                'method' => 'Email',
                'test_mode' => true,
                'otp' => $otp
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Unable to send verification code: ' . $e->getMessage()]);
        }
    }
}

?>

