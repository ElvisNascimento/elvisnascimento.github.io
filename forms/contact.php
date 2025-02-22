<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Se estiver usando Composer
// require 'caminho/para/PHPMailer/src/PHPMailer.php'; // Se estiver sem Composer
// require 'caminho/para/PHPMailer/src/SMTP.php';
// require 'caminho/para/PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Erro: Preencha todos os campos corretamente!";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'seuemail@gmail.com'; // Substitua pelo seu e-mail Gmail
        $mail->Password   = 'suasenha'; // Substitua pela senha do seu e-mail ou senha de app
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Configurações do e-mail
        $mail->setFrom($email, $name);
        $mail->addAddress('elvisnascimentodev@gmail.com'); // E-mail de destino
        $mail->addReplyTo($email, $name);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<strong>Nome:</strong> $name<br><strong>Email:</strong> $email<br><br><strong>Mensagem:</strong><br>$message";
        $mail->AltBody = "Nome: $name\nEmail: $email\n\nMensagem:\n$message";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "Erro ao enviar: {$mail->ErrorInfo}";
    }
} else {
    echo "Acesso inválido!";
}
?>
