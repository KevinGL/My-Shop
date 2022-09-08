<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>My Shop</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link href="CSS/style.css" rel="stylesheet">
</head>

<body>


    <?php

    require_once("datas.php");

    session_start();

    require_once("header.php");

    $products = $sql->select(["*"], "products", []);
    //$aa = $sql->select(["*"], ["field" => "name", "value" => "TV 4K"], "products");

    /*if(isset($_SESSION["user"]))
    {
        echo "Bienvenue " . htmlspecialchars($_SESSION["user"]["username"]) . " !";     //Eviter failles XSS
        //unset($_SESSION["new_user"]);
    }*/

    ?>

    <br>

    <div class="container">
        <!--<ul>-->

            <?php
                $i = 0;
                
                foreach($products as $p)
                {
                    /*echo "<li><h1>" . $p["name"] . " " . $p["price"] . " €</h1>";
                    echo "<img src=" . $p["picture"] . " alt=" . $p["name"] . "/></li>";
                    $cat = $sql->select(["name"], "categories", ["id", $p["category_id"]]);
                    echo '<h2>Catégorie : ' . $cat["name"] . '</h2>';
                    
                    $onclick = "window.location.href='cart.php?idProduct=" . $p["id"] . "';";

                    //echo $onclick;

                    echo '<button type="button" onclick=' . $onclick . ' class="btn btn-success">Ajouter au panier</button><br><br>';*/

                    $onclick = "window.location.href='cart.php?idProduct=" . $p["id"] . "';";

                    ?>
                        <div class="product">

                            <img src="<?php echo $p["picture"] ?>" alt="<?php echo $p["description"] ?>">

                            <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
                                <div class="card-header"><?php echo $p["name"] ?></div>
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $p["price"] ?> €</h4>
                                    <p class="card-text"><?php echo $p["description"] ?></p>
                                </div>
                            </div>
                    
                            <button type="button" onclick="<?php echo $onclick ?>" class="btn btn-success">Ajouter au panier</button>
                        </div>
                    <?php
                    
                    if($i<count($products)-1)
                        echo '<hr>';

                    $i++;
                }
            ?>

        <!--</ul>-->

    </div>

</body>

</html>