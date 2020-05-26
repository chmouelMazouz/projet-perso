<?php
// Once the form is submitted, check to ensure that the fields are not empty	 
if (trim($_POST['name']) == '') {
    $hasError = true;
} else {
    $name = trim($_POST['name']);
}
if (trim($_POST['subject']) == '') {
    $hasError = true;
} else {
    $subject = trim($_POST['subject']);
}
//Check if the email address is valid
if (trim($_POST['email']) == '') {
    $hasError = true;
} else if (!filter_var(trim($_POST['email'], FILTER_VALIDATE_EMAIL))) {
    $hasError = true;
} else {
    $email = trim($_POST['email']);
}
//Check if comment was entered
if (trim($_POST['message']) == '') {
    $hasError = true;
} else {
    if (function_exists('stripslashes')) {
        $message = stripslashes(trim($_POST['message']));
    } else {
        $message = trim($_POST['message']);
    }
}
//If there is no error then send the email
if (!isset($hasError)) {
    // Now we have all the information from the fields sent by the form.
    // Replace youremail@domain.com by your email;
    $subject = $subject;
    $to = 'youremail@domain.com';
    $headers = 'From: youremail@domain.com' . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    // load email HTML template
    $body = file_get_contents('../include/email-template.html');
    // replace appropriate placeholders
    $body = str_replace('{{name}}', $name, $body);
    $body = str_replace('{{email}}', $email, $body);
    $body = str_replace('{{message}}', $message, $body);
    $body = str_replace('{{subject}}', $subject, $body);
    $body = str_replace("\n.", "\n..", $body);
    mail($to, $subject, $body, $headers); //This method sends the email.
    echo "<button id='submit' class='btn btn-medium btn-block'>Email was sent!</button>";
}
        
        