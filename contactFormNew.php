<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: contact.html');
    exit;
}

// Honeypot bot check
$botalert = $_POST['botalert'] ?? '';
if (!empty($botalert)) {
    exit;
}

// Form data
$firstName = trim($_POST['first_name'] ?? 'N/A');
$cname     = trim($_POST['cname'] ?? 'N/A');
$userEmail = trim($_POST['email_id'] ?? '');
$subject   = trim($_POST['subject'] ?? 'N/A');
$telephone = trim($_POST['telephone'] ?? 'N/A');
$message   = trim($_POST['comments'] ?? 'No message provided');

// Basic validation
if ($firstName === '' || $userEmail === '' || $telephone === '' || $message === '') {
    die('Please fill all required fields.');
}

if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    die('Please enter a valid email address.');
}

// Escape data for email body
$safeName      = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
$safeCompany   = htmlspecialchars($cname, ENT_QUOTES, 'UTF-8');
$safeEmail     = htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8');
$safeSubject   = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$safeTelephone = htmlspecialchars($telephone, ENT_QUOTES, 'UTF-8');
$safeMessage   = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

// SMTP details
$smtpEmail    = 'shivra.smtp@gmail.com';
$smtpPassword = 'tjbr gjdd ackq uazm';

// Admin Email
$adminEmail   = 'krupalatshivraecom@gmail.com';
$adminSubject = 'New Enquiry Received';

// Admin email body
$adminBody = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mail to Admin</title>
</head>
<body>
    <div bgcolor="#FFFFFF" marginwidth="0" marginheight="0">
        <table width="900" border="5" align="center" cellpadding="0" cellspacing="0" style="border-color:#0a0f4e; padding:10px; font-family:Arial, sans-serif;">
            <tr>
                <td>
                    <table width="900" style="padding:5px;">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <h2 style="color:#0a0f4e; margin:0;">Shivra Ecom</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:100px;" colspan="2">
                                    <h3>Contact Page Details of:
                                        <label style="font-size:14px; font-weight:bold;">' . $safeName . '</label>
                                    </h3>
                                </td>
                                <td style="width:290px;">
                                    <h5 style="font-size:15px; float:right; text-align:right;">Date:&nbsp;' . date("d/m/Y") . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="780" style="padding-left:10px;">
                                        <tr>
                                            <td style="width:460px;"><span style="font-size:14px; font-weight:bold;">Name</span></td>
                                            <td style="width:90px;"><span style="font-size:14px; font-weight:bold; margin-left:10px;">:</span></td>
                                            <td style="width:3500px;"><label style="font-size:14px;">' . $safeName . '</label></td>
                                        </tr>
                                       
                                        <tr>
                                            <td style="width:460px;"><span style="font-size:14px; font-weight:bold;">Email</span></td>
                                            <td style="width:90px;"><span style="font-size:14px; font-weight:bold; margin-left:10px;">:</span></td>
                                            <td style="width:3500px;"><label style="font-size:14px;">' . $safeEmail . '</label></td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="width:460px;"><span style="font-size:14px; font-weight:bold;">Phone</span></td>
                                            <td style="width:90px;"><span style="font-size:14px; font-weight:bold; margin-left:10px;">:</span></td>
                                            <td style="width:3500px;"><label style="font-size:14px;">' . $safeTelephone . '</label></td>
                                        </tr>
                                        <tr>
                                            <td style="width:460px;"><span style="font-size:14px; font-weight:bold;">Message</span></td>
                                            <td style="width:90px;"><span style="font-size:14px; font-weight:bold; margin-left:10px;">:</span></td>
                                            <td style="width:3500px;"><label style="font-size:14px;">' . $safeMessage . '</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr /></td>
                            </tr>
                            <tr>
                                <td colspan="3"><h3>Shivra Ecom</h3></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <span style="font-size:11px; color:#545353;">
                                        <b>Please do not reply to this email address as this is an automated email.</b>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>';

// User confirmation email body
$userBody = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Mail to Client</title>
</head>
<body>
    <div bgcolor="#FFFFFF" marginwidth="0" marginheight="0">
        <table width="900" border="5" align="center" cellpadding="0" cellspacing="0" style="border-color:#0a0f4e; padding:10px; font-family:Arial, sans-serif;">
            <tr>
                <td>
                    <table width="900" style="padding:5px;">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <h2 style="color:#0a0f4e; margin:0;">Shivra Ecom</h2>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:100px;" colspan="2">
                                    <h3>Dear <label style="font-size:14px; font-weight:bold;">' . $safeName . ',</label></h3>
                                </td>
                                <td style="width:290px;">
                                    <h5 style="font-size:15px; float:right; text-align:right;">Date:&nbsp;&nbsp;' . date("d/m/Y") . '</h5>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr style="border-color:#0a0f4e;" /></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    We thank you for contacting us with <strong>Shivra Ecom</strong> through our form on our website.<br /><br />
                                    Please be rest assured that your enquiry will have our best attention and we shall get in touch with you shortly.<br /><br />
                                    If you do not receive a response from us within two working days, we request you to write to us on
                                    <a href="mailto:info@shivraecom.co.uk">info@shivraecom.co.uk</a>.<br /><br />
                                    We look forward to building a strong business association with your organization.
                                    <br /><br />
                                    Best Regards,<br /><br /><br />
                                    Team Shivra Ecom
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <hr style="border-color:#0a0f4e;" />
                                     <img src="images/newhome/logo.png" href="index.html" alt="" class="jarallax-img ">
                                    <h3>Shivra Ecom</h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <span style="font-size:11px; color:#0a0f4e;">
                                        <b>Please do not reply to this email address as this is an automated email.</b>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>';

try {
    // Send email to admin
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $smtpEmail;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($smtpEmail, 'Shivra Ecom');
    $mail->addAddress($adminEmail);
    $mail->addReplyTo($userEmail, $firstName);
    $mail->isHTML(true);
    $mail->Subject = $adminSubject;
    $mail->Body = $adminBody;
    $mail->send();

    // Send confirmation email to user
    $mail2 = new PHPMailer(true);
    $mail2->SMTPDebug = SMTP::DEBUG_OFF;
    $mail2->isSMTP();
    $mail2->Host = 'smtp.gmail.com';
    $mail2->SMTPAuth = true;
    $mail2->Username = $smtpEmail;
    $mail2->Password = $smtpPassword;
    $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail2->Port = 587;

    $mail2->setFrom($smtpEmail, 'Shivra Ecom');
    $mail2->addAddress($userEmail, $firstName);
    $mail2->isHTML(true);
    $mail2->Subject = 'Thank you for contacting Shivra Ecom!';
    $mail2->Body = $userBody;
    $mail2->send();

    header('Location: thank-you.html');
    exit;

} catch (Exception $e) {
    echo 'Mailer Error: ' . $e->getMessage();
}

?>
