<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include autoload.php dari PHPMailer
require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kritik = htmlspecialchars($_POST['kritik']);

    if (!empty($kritik)) {
        $mail = new PHPMailer(true);

        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Server SMTP Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Email Anda
            $mail->Password = 'your-email-password'; // Password email Anda
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Pengaturan email
            $mail->setFrom('no-reply@yourwebsite.com', 'Sambat Rakyat');
            $mail->addAddress('zarrstronot@gmail.com'); // Email tujuan
            $mail->Subject = 'Kritik dan Saran dari Website';
            $mail->Body = "Anda menerima kritik dan saran berikut:\n\n" . $kritik;

            // Kirim email
            $mail->send();
            echo "Kritik dan saran berhasil dikirim.";
        } catch (Exception $e) {
            echo "Gagal mengirim kritik dan saran. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Harap isi kritik dan saran.";
    }
} else {
    echo "Metode pengiriman tidak valid.";
}
?>
