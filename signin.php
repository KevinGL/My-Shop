<?php

require_once("datas.php");

session_start();

require_once("header.php");

if(isset($_SESSION["badUser"]))
{
    echo "Cet utilisateur n'existe pas !\n";
    unset($_SESSION["badUser"]);
}

if(isset($_SESSION["badPassword"]))
{
    echo "Le mot de passe ne correspond pas !\n";
    unset($_SESSION["badPassword"]);
}

if(!isset($_POST["username"]) || !isset($_POST["password"]))
{
?>

    <!--<form action="#" method="post">
        <label for="username">Entrez votre nom d'utilisateur : </label>
        <input type="text" name="username" required="required" />

        <label for="password">Entrez votre mot de passe : </label>
        <input type="password" name="password" required="required" />
        
        <input type="submit" value="Je me connecte !">
    </form>-->

    <div class="container">
        <form action="#" method="post">
            <fieldset>
                <legend>Connectez-vous !</legend>

                <div class="form-group">
                    <label for="username" class="form-label mt-4">Entrez votre nom d'utilisateur</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username" required="required">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label mt-4">Entrez votre mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="password" required="required">
                </div>
                <br>
                
                <button type="submit" class="btn btn-primary">Je me connecte !</button>
                <button type="button" onclick="window.location.href = 'forgetPassword.php';" class="btn btn-warning">Mot de passe oublié</button>
            </fieldset>
        </form>
    </div>

<?php
}

else
{
    //$passwordHashed = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $r = $sql->select(["*"], "users", [ "username", $_POST["username"] ]);

    //var_dump($passwordHashed);

    if(!$r)         //User introuvable
    {
        $_SESSION["badUser"] = true;

        header("Location: #");
    }
    else
    {
        $r = $sql->select(["*"], "users", [ "username", $_POST["username"] ]);

        //var_dump($r);

        $passwordBDD = $r["password"];

        if(password_verify($_POST["password"], $passwordBDD))       //Connexion validée
        {
            /*$_SESSION["new_user"] = $_POST["username"];

            $_SESSION['isConnected'] = true;

            $_SESSION["isAdmin"] = $r["admin"];*/
            //var_dump($r);
            $_SESSION["user"] = [
                "username" => $r["username"],
                "email" => $r["email"],
                "admin" => $r["admin"]
            ];

            //var_dump($_SESSION["user"]);

            header("Location: index.php");
        }
        
        else        //Mauvais mot de passe
        {
            $_SESSION["badPassword"] = true;

            header("Location: #");
        }
    }
}