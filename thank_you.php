<!DOCTYPE html>
<html>
	<head>
		<title>Payment Invoice</title>
		<script src="jquery.min.js"></script>
		<link rel="stylesheet" href="bootstrap.min.css" />
		<script src="bootstrap.min.js"></script>
	</head>
	<body>
<?php
//index.php

$message = '';

$connect = new PDO("mysql:host=localhost;dbname=payment", "root", "");

function fetch_customer_data($connect)
{
	$id = $_GET['payment_id'];
	$query = "SELECT * FROM payment WHERE payment_id='$id'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$GLOBALS['emaill']=$row["email"];
	$output = '
	<h3 align="center">Payment Invoice</h3>
	<br />
	<div class="table-responsive">
		<table class="table table-striped table-bordered" style="width:50%; margin: auto;">
			<tr><th>Parameters</th><th>Status</th></tr>
				<tr><td>Payment Id </td><td>'.$row["payment_id"].'</td></tr>
				<tr><td>Payment Status </td><td>'.$row["payment_status"].'</td></tr>
				<tr><td>Amount </td><td>'.$row["amount"].'</td></tr>
				<tr><td>Currency </td><td>INR</td></tr>
				<tr><td>Recipient Name </td><td>PRP Financial Ventures</td></tr>
				<tr><td>Transaction made by</td><td>'.$row["name"].'</td></tr>
				<tr><td>E-mail</td><td>'.$row["email"].'</td></tr>
				<tr><td>Payment Gateway </td><td>RazorPay</td></tr>
				<tr><td>Time Stamp </td><td>'.$row["added_on"].'</td></tr>
			
			
	';
	}
	// foreach($result as $row)
	// {
	// 	$output .= '
	// 		<tr>
				
	// 			<td>'.$row["payment_status"].'</td>
	// 			<td>'.$row["amount"].'</td>
	// 			<td>INR</td>
	// 			<td>Finance Guru</td>
	// 			<td>'.$row["name"].'</td>
	// 			<td>'.$row["email"].'</td>
	// 			<td>Razor Pay</td>
	// 			<td>'.$row["added_on"].'</td>
	// 		</tr>
	// 	';
	// }
	$output .= '
		</table>
	</div>
	<div class="text-center">
	<br />
    <h8>This is a computer generated invoice. Hence no signature is required.</h8>
	<br />
	<h8>A copy of this invoice has been sent to your mail-id.</h8>
    </div>
      <br><br>
      <div class="text-center">
          <button onclick="window.print()" class="btn btn-primary">Print</button>
      </div>
	';
	return $output;
}


	include('pdf.php');
	$file_name = md5(rand()) . '.pdf';
	$html_code = '<link rel="stylesheet" href="bootstrap.min.css">';
	$html_code .= fetch_customer_data($connect);
	$pdf = new Pdf();
	$pdf->load_html($html_code);
	$pdf->render();
	$file = $pdf->output();
	file_put_contents($file_name, $file);
	
	require 'class/class.phpmailer.php';
	$mail = new PHPMailer;
	$mail->IsSMTP();								//Sets Mailer to send message using SMTP
	$mail->Host = 'smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
	$mail->Port = '465';								//Sets the default SMTP server port
	$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
	$mail->Username = 'obhaimujhemaroo@gmail.com';					//Sets SMTP username
	$mail->Password = 'OggyBhai@123';					//Sets SMTP password
	$mail->SMTPSecure = 'ssl';							//Sets connection prefix. Options are "", "ssl" or "tls"
	$mail->From = 'obhaimujhemaroo@gmail.com';			//Sets the From email address for the message
	$mail->FromName = 'PRP Financial Ventures';			//Sets the From name of the message
	$mail->AddAddress($emaill);		//Adds a "To" address
	$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
	$mail->IsHTML(true);							//Sets message type to HTML				
	$mail->AddAttachment($file_name);     				//Adds an attachment from a path on the filesystem
	$mail->Subject = 'Payment Receipt';			//Sets the Subject of the message
	$mail->Body = 'Please Find Payment Receipt in attach PDF File.';				//An HTML or plain text message body
	if($mail->Send())								//Send an Email. Return true on success or false on error
	{
		$message = '<label class="text-success">Payment Receipt has been sent successfully to your mail-id</label>';
	}
	unlink($file_name);


?>
	
		<br />
		<div class="container">
			
			<br />
			
			<br />
			<?php
			echo fetch_customer_data($connect);
			?>			
		</div>
		<br />
		<br />
	</body>
</html>





