<?php

require_once("datas.php");

session_start();

require_once("header.php");

if(!isset($_POST["username"]) && !isset($_POST["mail"]) && !isset($_POST["password"]) && !isset($_POST["passwordConf"]))
{
    $id = $sql->select(["id"], "users", ["username", $_SESSION["user"]["username"]]);
    //var_dump($res);
    
    ?>
        <div class="container">
            <form action="#" method="post">
                <fieldset>
                    <legend><?php echo $_SESSION["user"]["username"] ?></legend>

                    <div class="form-group">
                        <label for="username" class="form-label mt-4">Modifier votre nom d'utilisateur</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username" value=<?php echo $_SESSION["user"]["username"] ?>>
                    </div>

                    <div class="form-group">
                        <label for="username" class="form-label mt-4">Modifier votre adresse mail</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mail" value=<?php echo $_SESSION["user"]["email"] ?>>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label mt-4">Modifier votre mot de passe</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="password">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label mt-4">Confirmer votre mot de passe</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="passwordConf">
                    </div>

                    <input type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="id" value=<?php echo $id["id"] ?>>

                    <br>
                    
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </fieldset>
            </form>
        </div>
    <?php
}

else
{
    //var_dump($_POST["id"]);
    
    if($_POST["username"] != "")
    {
        $sql->update("users", ["username", $_POST["username"]], ["id", $_POST["id"]]);

        $_SESSION["user"]["username"] = $_POST["username"];

        ?>
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="window.location.href='index.php';"></button>
                Votre nom d'utilisateur a bien été mis à jour ! :)
            </div>
        <?php
    }

    if($_POST["mail"] != "")
    {
        $sql->update("users", ["email", $_POST["mail"]], ["id", $_POST["id"]]);

        $_SESSION["user"]["email"] = $_POST["mail"];

        ?>
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="window.location.href='index.php';"></button>
                Votre adresse mail a bien été mise à jour ! :)
            </div>
        <?php
    }

    if($_POST["password"] != "" || $_POST["passwordConf"] != "")
    {
        if($_POST["password"] != $_POST["passwordConf"])
        {
            ?>
                <div class="alert alert-dismissible alert-warning">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="window.location.href='user.php';"></button>
                    <h4 class="alert-heading">Warning!</h4>
                    Merci de confirmer correctement votre mot de passe :/
                </div>
            <?php
        }

        else
        {
            $sql->update("users", ["password", password_hash($_POST["password"], PASSWORD_BCRYPT)], ["id", $_POST["id"]]);
    
            //$_SESSION["user"]["email"] = $_POST["mail"];
    
            ?>
                <div class="alert alert-dismissible alert-success">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="window.location.href='index.php';"></button>
                    Votre mot de passe a bien été mis à jour ! :)
                </div>
            <?php
        }
    }
}