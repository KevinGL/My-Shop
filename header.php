<link href="https://bootswatch.com/5/flatly/bootstrap.css" rel="stylesheet">

<?php
/*if(!isset($_SESSION['isConnected']))
{
    echo '<a href="signup.php">Inscription</a><br>';
    echo '<a href="signin.php">Connexion</a><br>';
}
else
{
    echo '<a href="logout.php">Déconnexion</a><br>';
}*/
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <?php
    if(isset($_SESSION["user"]))
    {
        ?>
            <a class="navbar-brand" href="user.php"><?php echo $_SESSION["user"]["username"] ?></a>
        <?php
    }
    else
    {
        ?>
            <a class="navbar-brand" href="index.php">My Shop</a>
        <?php
    }
    ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Accueil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
            <?php
                if(!isset($_SESSION['user']))
                {
                    echo '<a class="nav-link" href="signup.php">Inscription</a>';
                    //echo '<a href="signin.php">Connexion</a><br>';
                }
                else
                    echo '<a class="nav-link" href="logout.php">Déconnexion</a>';
            ?>
        </li>
        <li class="nav-item">
            <?php
                if($_SESSION['user']["admin"] == "1")
                    echo '<a class="nav-link" href="admin.php">Administrateur</a>';
            ?>
        </li>
        <li class="nav-item">
            <?php
                if(!isset($_SESSION['user']))
                {
                    //echo '<a class="nav-link" href="signup.php">Inscription</a><br>';
                    echo '<a class="nav-link" href="signin.php">Connexion</a>';
                }
            ?>
        </li>
        
      </ul>
      <form class="d-flex my-2 my-sm-0" method="post" action="search.php">
        <input class="form-control me-sm-2" type="text" required="required" name="search" />
        <input class="btn btn-secondary me-sm-2" type="submit" value="Rechercher" />
      </form>
      
      <button class="btn btn-secondary my-2 my-sm-0" type="button" onclick="window.location.href='cart.php'">Voir votre panier <?php echo " (" . count($_SESSION["cart"]) . ")" ?></button>
      
    </div>
  </div>
</nav>