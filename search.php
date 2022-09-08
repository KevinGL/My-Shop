<?php

require_once("datas.php");

//session_start();

require_once("header.php");

if(isset($_POST["search"]))
{
    $res = $sql->select(["*"], "products", ["name", $_POST["search"]], true);

    //var_dump($res);
    if($res)
    {
        echo "<h1>" . $res["name"] . " " . $res["price"] . " €</h1>";
        echo "<img src=" . $res["picture"] . " alt=" . $res["name"] . "/>";
        $cat = $sql->select(["name"], "categories", ["id", $res["category_id"]]);
        echo '<h2>Catégorie : ' . $cat["name"] . '</h2>';

        $onclick = "window.location.href='cart.php?idProduct=" . $res["id"] . "';";

        //echo $onclick;

        echo '<button type="button" onclick=' . $onclick . ' class="btn btn-success">Ajouter au panier</button><br><br>';
    }
}