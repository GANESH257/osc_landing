<?php
//ini_set('display_errors', 1);
error_reporting(preg_match('/^(localhost)$/', $_SERVER['HTTP_HOST'])? E_ALL:0);
ini_set('upload_max_filesize', '120M');
ini_set('post_max_size', '120M');
## defining root variables
define('sitepath', dirname(dirname(__FILE__)));
## checking session
session_start();
## starting ob
ob_start();
## creating object
$site = new site();

$date = date("Y-m-d");
$datetime = date("Y-m-d H:i:s");
class site {	
	public $domain    = "";
	public $basedir   = "";
	public $local     = false;
	public function __construct(){
		$this->basedir  = sitepath.(!preg_match("/\/$/", $this->basedir)?"/":"");
		$diroot         = str_replace(str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]), "", str_replace("\\", "/", $this->basedir));
		$this->domain   = "http".(isset($_SERVER["HTTPS"])?"s":"")."://".$_SERVER["HTTP_HOST"];
		$this->domain   .= (!preg_match("/\/$/", $this->domain) && !preg_match("/^\//", $diroot)?"/":"").$diroot;
		$this->domain   .= !preg_match("/\/$/", $this->domain)?"/":"";
		$this->local    =  preg_match("/localhost/", $_SERVER['HTTP_HOST']);
	}

	public function esc($string, $filters=""){
		$string = is_string($string) || is_numeric($string)?$string:"";
		$string = trim(stripslashes($string));
		preg_match("/strip_non_utf8/i", $filters)?$string = preg_replace('/[^\x00-\x7f\xA9\xAE\xA3\xA5]|(\&\#[0-9]{1,}\;)/', '', $string):0;
		preg_match("/strip_tags/i", $filters)?$string = strip_tags($string):0;
		preg_match("/html_encode/i", $filters)?$string = htmlentities($string, ENT_IGNORE):0;
		preg_match("/html_encode/i", $filters)?$string = str_replace("'", "&#39;", $string):0;
		preg_match("/filter_phone/i", $filters)?$string = preg_replace('/[^0-9\+\ \-\)\(]/', '', $string):0;
		return $string;
	}
	public function is_mail($a){
		return filter_var($a, FILTER_VALIDATE_EMAIL);
	}
	public function extn($fname){
	    $fname=explode('.',$fname);
	    return strtolower($fname[count($fname)-1]);
	}
	public function str2url($name){
		$file_name = strtolower($name);
		$file_name = preg_replace('/[^0-9a-zA-Z]/',"-",$file_name);
		$file_name = preg_replace('/--+/',"-",$file_name);
		$file_name = preg_replace('/\-$|^\-/',"",$file_name);
		return $file_name;
	}
	
	public function more($str = "", $len = 100){
		$str = html_entity_decode($str);
		$str = strip_tags($str);
		$str = strlen($str)>$len?substr($str,0,$len)."..":$str ;
		return $str;
	}
	
	
	public function randomstr($len=6, $chars="uln"){
		$pattern = "";
		$pattern .= preg_match("/n/", $chars)?"1234567890":"";
		$pattern .= preg_match("/l/", $chars)?"abcdefghijklmnopqrstuvwxyz":"";
		$pattern .= preg_match("/u/", $chars)?"ABCDEFGHIJKLMNOPQRSTUVWXYZ":"";
		$pattern .= preg_match("/s/", $chars)?"@#$&*-_+":"";
		$str = "";
		if(strlen($pattern)>0){
			while(strlen($str)<$len){
				$str .= $pattern[rand(0,strlen($pattern)-1)];
			}
		}
		return $str;
	}
	public function write_file($filename,$content){
		$exist_content = "";
		if(file_exists($filename)){
			$exist_content = file_get_contents($filename);
		}
		$fp = fopen($filename, 'w');
		fwrite($fp, '<div style="overflow:hidden; font-family:arial; font-size:12px; padding-bottom:10px; margin-bottom:10px; border-bottom:1px dashed #ccc;">
		<div style="width:20%; float:left;">['.date("Y-m-d h:i:s A").']</div>
		<div style="width:79%; float:right;">'.$content.'</div></div>'.$exist_content);
		fclose($fp);
	}
	
	public function redirect($link = ""){
		ob_clean();
		$link = $link==""?(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:$this->domain):$link;
		!preg_match("/^http/", $link)?$link=$this->domain.$link:0;
		header("location:$link");
		exit;
	}
	public function mail_headers(){
		$title = 'Spine Care';
		$currentDomain = preg_replace('/www\./i', '', $_SERVER['SERVER_NAME']);
		$header  = "content-type:text/html\r\n";
		$header .= "from:".$title."<dr.amit@onlinespinecare.com>";
		return $header;
	}
	public function send_mail($to, $subject, $content, $attach=false, $file='email'){
		global $db;
		$options = 'Spine Care';
		$template = $this->basedir."includes/".$file.".html";
		$template = is_file($template)?@file_get_contents($template):"";
		$template = $template==false?"":$template;
		$template = str_replace(array("[site-link]", "[site-title]", "[year]", "[subject]", "[content]"), array($this->domain, $options, date("Y"), $subject, $content), $template);
		$headers = $this->mail_headers();
		
		if($this->local){
			$this->write_file($this->basedir."mail.html", "<table cellpadding=\"7\" style=\"font-size:12px;\"><tr valign=\"top\"><td><strong>To</strong></td><td>$to".
			"</td></tr><tr valign=\"top\"><td><strong>Headers</strong></td><td>".nl2br(htmlentities($headers))."</td></tr></table>".$template);
		}else{
			return mail($to,$subject,$template,$headers);
		}
	}
	
	//Brevo Mail sending for Enquiries
	public function brevoMailSend($mailname, $mailid, $subject, $content){
        if($mailname!='' && $this->is_mail($mailid)){


            $template = $this->basedir."includes/email.html";
            $template = is_file($template)?@file_get_contents($template):"";
            $template = $template==false?"":$template;
            $template = str_replace(array("[site-title]", "[site-link]", "[site-year]", "[subject]", "[content]"), array($this->domain, 'Spine Care', date("Y"), $subject, $content), $template);

            // API endpoint and key
            $endpoint = 'https://api.brevo.com/v3/smtp/email';
            // Get API key from environment variable, fallback to empty string if not set
            $api_key = $_ENV['BREVO_API_KEY'] ?? getenv('BREVO_API_KEY') ?? '';

            // Request payload
            $datas = [
                'sender' => [
                    'email' => 'surgeonspine18@gmail.com',  // change with your email address
                    'name' => 'Spine Care',
                ],
                'to' => [
                    [
                        'name' => $mailname,
                        'email' => $mailid
                    ]
                ],
                'subject' => $subject,
                'htmlContent' => $template
            ];

            // Set cURL options
            $optionmail = [
                CURLOPT_URL => $endpoint,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($datas),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'accept: application/json',
                    'api-key: ' . $api_key,
                    'content-type: application/json'
                ]
            ];

            // Initialize cURL session
            $curl = curl_init();

            // Set cURL options
            curl_setopt_array($curl, $optionmail);

            // Execute the request
            $responsemail = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = curl_error($curl);

            // Check for errors
            if ($responsemail === false || !empty($curlError)) {
                error_log('Brevo cURL Error: ' . $curlError);
                curl_close($curl);
				return false;
            }
            
            curl_close($curl);

                // Decode the JSON response
                $response_data = json_decode($responsemail, true);

                // Check if JSON decoding was successful
                if ($response_data === null) {
                error_log('Brevo Response Error: Invalid JSON. HTTP Code: ' . $httpCode . ', Response: ' . substr($responsemail, 0, 200));
                    return false;
                } else {
                    // Check if response contains 'messageId' key
                    if (isset($response_data['messageId'])) {
						return true;
                } elseif (isset($response_data['message']) || isset($response_data['error'])) {
                    error_log('Brevo API Error: ' . json_encode($response_data));
						return false;
                    } else {
                    error_log('Brevo Unknown Response: ' . json_encode($response_data));
						return false;
                }
            }
        }else{
			return false;
		}
    }
    
	public function json($obj){
		ob_clean();
		header("content-type:application/json");
		echo json_encode($obj);
		exit;
	}
	

	public function sendenquiry($args=array()){
		global $date, $datetime;
		if(!empty($args)){
		    $pdo = new PDO('mysql:host=localhost;dbname=spinecare_db', 'spinecare_user', 'rynV*Aqw^ER7');
			//$pdo = new PDO('mysql:host=localhost;dbname=spinecare', 'root', '');
			$name = $this->esc($args['name']);
			$email = $this->esc($args['email']);
			$phone = $this->esc($args['phone']);
			$message = $this->esc($args['message']);

			### Insert
			$sql = "INSERT INTO `landing_page_enquiries` (`name`, `email`, `phone`, `message`, `created_at`) VALUES (?,?,?,?,?)";
			$stmt= $pdo->prepare($sql);
			$stmt->execute([$name, $email, $phone, $message, $datetime]);
		}
	}
	
	// OTP Helper Functions
	
	/**
	 * Get Country Codes Array
	 * Returns array of supported countries with codes and shortcodes
	 */
	public function getCountryCode(){
		return array(
			array("code" => "+1", "shortcode" => "US", "name" => "United States"), 
			array("code" => "+1", "shortcode" => "CA", "name" => "Canada"), 
			array("code" => "+91", "shortcode" => "IN", "name" => "India"), 
			array("code" => "+44", "shortcode" => "UK", "name" => "United Kingdom")
		);
	}

	/**
	 * Get Country Details by Shortcode
	 * @param string $shortcode Country shortcode (US, CA, IN, UK)
	 * @param array $data Country data array from getCountryCode()
	 * @return array|null Country details or null if not found
	 */
	public function getCountryDetails($shortcode, $data) {
		foreach ($data as $country) {
			if ($country["shortcode"] === $shortcode) {
				return $country;
			}
		}
		return null;
	}

	/**
	 * Google reCAPTCHA Verification
	 * Verifies reCAPTCHA v3 token with Google
	 * @param string $captcha reCAPTCHA token from frontend
	 * @return bool True if verified, false otherwise
	 */
	public function getGooglecaptchaResponse($captcha){
		// Check if config-otp.php is loaded
		if (!defined('RECAPTCHA_SECRET_KEY')) {
			require_once(__DIR__ . '/config-otp.php');
		}
		
		$secretKey = RECAPTCHA_SECRET_KEY;
		$resp = false;
		
		if($secretKey!='' && $captcha!=''){
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.urlencode($secretKey).'&response='.urlencode($captcha);
			$response = @file_get_contents($url);
			
			if ($response !== false) {
				$responseKeys = json_decode($response, true);
				if($responseKeys && isset($responseKeys["success"]) && $responseKeys["success"]) {
					$resp = true;
				}
			}
		}
		return $resp;
	}

	/**
	 * Get User IP Address
	 * @return string User's IP address
	 */
	public function getUserIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
		} else {
			return $_SERVER['REMOTE_ADDR'] ?? '';
		}
	}
	
}
?>