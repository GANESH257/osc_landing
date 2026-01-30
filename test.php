<?php
include('includes/functions.php');


$mail = '<table width:100%>
  	<tr>
    	<th>Name</th>
    	<td>:</td>
    	<td>Joel</td>
  	</tr>
  	</table>';
$resp = $site->brevoMailSend('Spine Care', 'joelbenny00@gmail.com','Enquiry - Spine Care', $mail);
echo $resp;

?>