<?php
include('functions.php');
include('google-sheets.php');

$response = new stdClass();
$response->status = "error";
$response->message = "";

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

		// Send to Google Sheets
		try {
			$sheets = new GoogleSheets('1P9YhiovvD9oqZHeIn-vjwqhiY6GABdH3IUBUbMRj_FA'); // Replace with your actual spreadsheet ID
			$sheetsResult = $sheets->appendRow([
				'name' => $name,
				'phone' => $phone,
				'email' => $email,
				'message' => $message
			]);
			
			if (!$sheetsResult) {
				error_log('Failed to append data to Google Sheets');
			}
		} catch (Exception $e) {
			error_log('Google Sheets Error: ' . $e->getMessage());
			$response->message = "Error saving to database: " . $e->getMessage();
		}

		// Send emails
		$site->sendenquiry(array('name'=>$name, 'phone'=>$phone, 'email'=>$email, 'message'=>$message));
		$resp = $site->brevoMailSend('Spine Care', 'mgmt@onlinespinecare.com','Enquiry - Spine Care', $mail);
		$site->brevoMailSend('Spine Care', 'itteam@onlinespinecare.com','Enquiry - Spine Care', $mail);
		$site->brevoMailSend('Spine Care', 'getupihm@gmail.com','Enquiry - Spine Care', $mail);
		
		$response->status = $resp ? 'success' : 'error';
		if ($response->status === 'success') {
			$response->message = "Thank you for your enquiry. We will contact you soon.";
		} else {
			$response->message = "Error sending email. Please try again later.";
		}
	} else {
		$response->message = "Please fill in all required fields.";
	}
} else {
	$response->message = "Invalid form submission.";
}

$site->json($response);
?>