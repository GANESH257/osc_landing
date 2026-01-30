<?php
include('functions.php');

$response = new stdClass();
$response->status   = "error";

if(isset($_POST['name'], $_POST['phone'], $_POST['email'])){
	$name = $site->esc($_POST['name']);
	$email = $site->esc($_POST['email']);
	$phone = $site->esc($_POST['phone']);
	$message = $site->esc($_POST['message']);


    
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
	      	</tr>';
			if($message!=''){
				$mail.='<tr>
					<th>Comments</th>
					<td>:</td>
					<td>'.$message.'</td>
				</tr>';
			}
	    $mail.='</table>';
	    $site->sendenquiry(array('name'=>$name, 'phone'=>$phone, 'email'=>$email, 'message'=>$message));
	    $resp = $site->brevoMailSend('Spine Care', 'mgmt@onlinespinecare.com','Enquiry - Spine Care', $mail);
	    $site->brevoMailSend('Spine Care', 'itteam@onlinespinecare.com','Enquiry - Spine Care', $mail);
	    $site->brevoMailSend('Spine Care', 'getupihm@gmail.com','Enquiry - Spine Care', $mail);
		$response->status=$resp?'success':'error';
    }
}

$site->json($response);
?>