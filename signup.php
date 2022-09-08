<?php

require_once("datas.php");

session_start();

require_once("header.php");

//var_dump($sql);

if(isset($_SESSION["userAlready"]))
{
    echo "Ce pseudo est déjà pris !\n";
    unset($_SESSION["userAlready"]);
}

if(isset($_SESSION["mailAlready"]))
{
    echo "Cette adresse mail est déjà prise !\n";
    unset($_SESSION["mailAlready"]);
}

if(isset($_SESSION["badPasswordConf"]))
{
    echo "Le mot de passe n'a pas été correctement confirmé !\n";
    unset($_SESSION["badPasswordConf"]);
}

if(!isset($_POST["username"]) || !isset($_POST["mail"]) || !isset($_POST["password"]) || !isset($_POST["passwordConfirm"]))
{
?>

    <div class="container">
        <form action="#" method="post">
            <fieldset>
                <legend>Inscrivez-vous, c'est gratuit !</legend>

                <div class="form-group">
                    <label for="email" class="form-label mt-4">Entrez votre adresse mail</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mail" required="required">
                </div>
                
                <div class="form-group">
                    <label for="username" class="form-label mt-4">Choisissez un nom d'utilisateur</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username" required="required">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label mt-4">Choisissez un mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="password" required="required">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label mt-4">Confirmez votre mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="passwordConfirm" required="required">
                </div>
                <br>
                
                <button type="submit" class="btn btn-primary">C'est parti pour My Shop !</button>
            </fieldset>
        </form>
    </div>

    <?php
}

else
{
    if($_POST["password"] !== $_POST["passwordConfirm"])
    {
        $_SESSION["badPasswordConf"] = true;

        header("Location: #");
    }
    
    else
    {
        $res = $sql->select(["*"], "users", [ "username", $_POST["username"] ]);
        //var_dump($res);

        if(!$res)       //Utilisateur inexistant
        {
            $res2 = $sql->select(["*"], "users", [ "email", $_POST["mail"] ]);
            
            if(!$res2)      //Adress mail inexistante, inscription acceptée
            {
                //$_SESSION["new_user"] = $_POST["username"];

                //$_SESSION['isConnected'] = true;

                $_SESSION["user"] = [
                    "username" => $_POST["username"],
                    "email" => $_POST["mail"],
                    "admin" => "0"
                ];

                //var_dump($_SESSION["user"]);

                $sql->add("users", ["username", "password", "email", "admin"], [$_POST["username"], password_hash($_POST["password"], PASSWORD_BCRYPT), $_POST["mail"], "0"]);
                
                header("Location: index.php");
            }

            else
            {
                $_SESSION["mailAlready"] = true;

                header("Location: #");
            }
        }

        else
        {
            //echo "Ce pseudo est déjà pris !\n";
            $_SESSION["userAlready"] = true;

            header("Location: #");
        }
    }
}