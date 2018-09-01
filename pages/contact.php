<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
set_error_handler("var_dump");

if(isset($_POST['submit'])){
	$to = "tbaljevic@hotmail.com"; // this is your Email address
	$from = $_POST['email']; // this is the sender's Email address
	
	$name = $_POST['name'];
	
	$subject = "Form submission";
	$subject2 = "Copy of your form submission";
	
	$message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $_POST['message'];
	$message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];

	print_r($message);	print_r($message2);
	
	$headers = "From:" . $from;
	$headers2 = "From:" . $to;
	
	$success1 = mail($to,$subject,$message,$headers);
	$success2 = mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
	
	if ($success1) {
		echo "<p>SUCCESS 1</p>";
	} else {
		echo "<p>FAIL 1</p>";
	}
	
	if ($success2) {
		echo "<p>SUCCESS 2</p>";
	} else {
		echo "<p>FAIL 2</p>";
	}
	
	echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
}

?>

<h1>Let's Talk!</h1>

<p class="center">My preferred mode of communication is LinkedIn. Please feel free to send me a message if you'd like to get in touch!</p>

<div class="break"></div>

<div class="gallery">
	<a class='image-link' href="https://www.linkedin.com/in/tadbaljevic/">
		<img class='circular gallery-image' src='./resources/images/links/linkedin.jpg'/>
	</a>
</div>
<!--
<div class="break"></div>

<p class="center">Alternatively, you could email me:</p>

<div style="margin: auto;">
	<form action="" method="post">
		<table style="margin: auto;">
			<tr>
				<th colspan='2'>Contact</th>
			</tr>
			<tr>
				<td style="text-align: right;">Your Name:</td>
				<td>
					<input type="text" name="name" />
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Last Name:</td>
				<td>
					<input type="text" name="last_name">
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Email:</td>
				<td>
					<input type="text" name="email">
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">Message:</td>
				<td>
					<textarea rows="5" name="message" cols="30"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2' style="text-align: center;">
					<input type="submit" name="submit" value="Submit">
				</td>
			</tr>
		</table>
	</form>
</div>-->