<?php
include('functions.php');

$response = new stdClass();
$response->status   = "error";

if(isset($_POST['name'], $_POST['phone'], $_POST['email'])){
	$name = $site->esc($_POST['name']);
	$email = $site->esc($_POST['email']);
	$phone = $site->esc($_POST['phone']);


    
    if($name!='' && $email!='' && $phone!=''){
	    $mail = '<table width:100%>
	      	<tr>
	        	<th>Name</th>
	        	<td>:</td>
	        	<td>'.$name.'</td>
	      	</tr>
	        <tr>
	        	<th>Phone</th>
	        	<td>:</td>
	        	<td>'.$phone.'</td>
	      	</tr>
	      	<tr>
	        	<th>Email</th>
	        	<td>:</td>
	        	<td>'.$email.'</td>
	      	</tr>
        </table>';

	    $resp = $site->brevoMailSend('Spine Care', 'mgmt@onlinespinecare.com','Download Brochure - Spine Care', $mail);
	    $site->brevoMailSend('Spine Care', 'itteam@onlinespinecare.com','Download Brochure - Spine Care', $mail);
	    $site->brevoMailSend('Spine Care', 'getupihm@gmail.com','Download Brochure - Spine Care', $mail);
		$response->status=$resp?'success':'error';
    }
}

$site->json($response);
?>