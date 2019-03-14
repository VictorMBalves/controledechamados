<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    class Mailer{
        
        public function sendEmail($destEmail, $nome, $subject, $body){
            require '../vendor/autoload.php';
            $mail = new PHPMailer(true); 
            //Load Composer's autoloader
            try {
                //Server settings
                // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'germantech.com.br';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'noreply@germantech.com.br';                 // SMTP username
                $mail->Password = 'germantech,123';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                   // TCP port to connect to
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                //Recipients
                $mail->setFrom('noreply@germantech.com.br', 'Controle de chamados');
                $mail->addAddress($destEmail, $nome);     
                // Add a recipient
                // $mail->addAddress('ellen@example.com');               // Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');
            
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            
                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    =  $body;
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                return true;
            } catch (Exception $e) {
                error_log('Message could not be sent. Mailer Error: ', $mail->ErrorInfo);
                return false;
            }
        }
}
?>