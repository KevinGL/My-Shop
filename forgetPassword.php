<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once("datas.php");

session_start();

require_once("header.php");

if(isset($_SESSION["badMail"]))
{
    echo "Adresse mail introuvable !\n";

    unset($_SESSION["badMail"]);
}

if(!isset($_POST["mail"]))
{
?>

    <div class="container">
        <form action="#" method="post">
            <fieldset>
                <legend>Mot de passe passé à la trappe :(</legend>

                <div class="form-group">
                    <label for="email" class="form-label mt-4">Entrez l'adresse mail rattachée à votre compte</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mail" required="required">
                    <label for="email" class="form-label mt-4">Entrez un nouveau mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="newpassword" required="required">
                    <label for="email" class="form-label mt-4">Confirmez le mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="newpasswordconf" required="required">
                </div>
                <br>
                
                <button type="submit" class="btn btn-primary">Valider</button>
            </fieldset>
        </form>
    </div>
<?php
}

else
{
    $res = $sql->select(["*"], "users", ["email", $_POST["mail"]]);
    //var_dump($res);
    if(!$res)
    {
        $_SESSION["badMail"] = true;

        header("Location: #");
    }
    else
    {
        ini_set("SMTP","ssl://smtp.gmail.com");
        ini_set("smtp_port","465");
        
        $newPassword = uniqid();
        //echo $newPassword . "\n";
        /*$to = "kevin.progc@gmail.com";
        $subject = "VIRALPATEL.net";
        $body = "Body of your message here you can use HTML too. e.g. <br> <b> Bold </b>\r\n";
        $headers = "From: Peter\r\n";
        $headers .= "Reply-To: info@yoursite.com\r\n";
        $headers .= "Return-Path: info@yoursite.com\r\n";
        $headers .= "X-Mailer: PHP5\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        var_dump( mail($to,$subject,$body,$headers) );*/

        $message = "Line 1\r\nLine 2\r\nLine 3";

        // Dans le cas où nos lignes comportent plus de 70 caractères, nous les coupons en utilisant wordwrap()
        $message = wordwrap($message, 70, "\r\n");

        // Envoi du mail
        var_dump( mail('kevin.progc@gmail.com', 'Mon Sujet', $message) );

        echo "Votre nouveau mot de passe a été envoyé à votre adresse mail personnelle\n";
    }
}