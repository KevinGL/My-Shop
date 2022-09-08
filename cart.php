<?php

require_once("datas.php");

session_start();

if(isset($_GET["idProduct"]))
{
    if(!isset($_SESSION["cart"]))
        $_SESSION["cart"] = [];
    
    array_push($_SESSION["cart"], $_GET["idProduct"]);

    //var_dump($_SESSION["cart"]);

    header("Location: index.php");
}
else
{
    require_once("header.php");

    $totalPrice = 0.0;

    ?>

    <br>

    <div class="container">
    
        <?php

        if(count($_SESSION["cart"]) != 0)
        {
            ?>
                <table class="table table-active">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Catégorie</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach($_SESSION["cart"] as $id)
                    {
                        $prod = $sql->select(["*"], "products", ["id", $id]);
                        //var_dump($res);
                        
                        if($prod)
                        {
                            $cat = $sql->select(["name"], "categories", ["id", $prod["category_id"]]);
                            
                            $onclick = "window.location.href = 'deleteInCart.php?idProduct=" . $id ."';"
                            
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $prod["name"] ?></th>
                                    <td><?php echo $prod["price"] ?> €</td>
                                    <td><?php echo $cat["name"] ?></td>
                                    <td><button type="button" onclick="<?php echo $onclick ?>" class="btn btn-warning">Retirer du panier</button></td>
                                </tr>
                            <?php

                            $totalPrice += $prod["price"];

                            $i++;
                        }
                    }

                    ?>

                    </tbody>
                </table>


                <div class="alert alert-dismissible alert-info">
                    Total : <?php echo $totalPrice; ?> €
                </div>

            <?php

        }

        else
        {
            ?>
                <div class="alert alert-dismissible alert-warning">
                    <!--<button type="button" class="btn-close" data-bs-dismiss="alert"></button>-->
                    <h4 class="alert-heading">Quel dommage :(</h4>
                    <p class="mb-0">Votre panier est vide !</p>
                </div>
            <?php
        }

        ?>
    </div>

    <?php

    //var_dump($totalPrice);

   
}