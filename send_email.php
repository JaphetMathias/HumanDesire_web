<?php
header("Content-Type: application/json");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email address."]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'faidamomo2030@gmail.com'; // Your Gmail address
        $mail->Password   = '@mOmO2030'; // Your Gmail password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('contact@humandesire.store'); // Recipient email

        // Content
        $mail->isHTML(false);
        $mail->Subject = "New Contact Message from $name";
        $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$message\n";

        $mail->send();
        echo json_encode(["success" => true, "message" => "Thank you for messaging us. We will reply to you soon."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo} , Or try to send us message by using the above Email"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>