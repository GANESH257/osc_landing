<?php 
include('functions.php');

$response = new stdClass();
$response->status   = "error";
if(isset($_POST['email'])) {
    $email      = $site->esc($_POST['email']);

    if($site->is_mail($email)){
        $msg = '<div style="width:100%">
            <p style="line-height: 20px;margin-bottom:15px;">You have a new newsletter submission request. Please review the email at your earliest convenience.</p>
            <p style="text-align:center">Email : <strong>'.$email.'</strong></p>
        </div>';
        
        $resp = $site->brevoMailSend('Spine Care', 'mgmt@onlinespinecare.com', 'Newsletter - Spine Care', $msg); 
        $site->brevoMailSend('Spine Care', 'itteam@onlinespinecare.com','Newsletter - Spine Care', $mail);
	    $site->send_mail('Spine Care', 'getupihm@gmail.com','Newsletter - Spine Care', $mail);
        $response->status=$resp?'success':'error';
    }
}
$site->json($response);
?>