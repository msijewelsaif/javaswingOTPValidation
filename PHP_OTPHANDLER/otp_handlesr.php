<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure this path is correct

session_start();

// Handle OTP sending
if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];

    // Generate a random 6-digit OTP
    $otp = rand(100000, 999999);
    $_SESSION['generated_otp'] = $otp;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pre2002047@gmail.com'; // Your Gmail address
        $mail->Password   = 'qrjs xosi ealf jjpx';  // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('pre2002047@gmail.com', 'Library Management System');
        $mail->addAddress($email); // Recipient's email address

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = 'Your OTP code is: <b>' . $otp . '</b>';

        $mail->send();
        echo 'OTP has been sent to your email!';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Handle OTP validation
if (isset($_POST['verify_otp'])) {
    $submitted_otp = $_POST['otp'];

    if ($submitted_otp == $_SESSION['generated_otp']) {
        echo 'OTP verified successfully!';
        // Clear the OTP from session after successful validation
        unset($_SESSION['generated_otp']);
    } else {
        echo 'Invalid OTP. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Handler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>OTP Handler</h3>
                    </div>
                    <div class="card-body">
                        <!-- OTP Sending Form -->
                        <form action="otp_handlesr.php" method="POST" id="sendOtpForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Enter Your Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="send_otp" class="btn btn-primary">Send OTP</button>
                            </div>
                        </form>

                        <!-- OTP Verification Form -->
                        <form action="otp_handlesr.php" method="POST" id="verifyOtpForm" class="mt-4">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="verify_otp" class="btn btn-success">Verify OTP</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <p id="responseMessage"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
