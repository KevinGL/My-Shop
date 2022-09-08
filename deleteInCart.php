<?php

session_start();

if(isset($_GET["idProduct"]))
{
    $i = 0;
    foreach($_SESSION["cart"] as $value)
    {
        if($value == $_GET["idProduct"])
        {
            unset($_SESSION["cart"][$i]);
            $_SESSION["cart"] = array_values($_SESSION["cart"]);
            break;
        }
        $i++;
    }

    //var_dump($_SESSION["cart"][$_GET["idProduct"]]);

    header("Location: index.php");
}