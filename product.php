<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Produits</title>
</head>

<body>
    <?php
    session_start();
    require_once './functions.php';

    define('DESACTIVE_BUTTON', "Supprimer");
    define('UPDATE_BUTTON', "Modifier");

    $idDesactive = -1;
    $idModify = -1;
    $search = "";

    $search = filter_input(INPUT_POST, "search");

    $records = getAllCaps();
    if ($records === false) {
        echo "Les casquettes ne peuvent être affichées. Une erreur s'est produite.";
        exit;
    }



    if (isset($_POST['DES'])) {
        $idDesactive = filter_input(INPUT_POST, "cap");
        $idDesactive = intval($idDesactive);
    }
   

    if ($idDesactive > 0) {
        if (desactivateCap($idDesactive) == false) {
            echo "Le produit ne peut pas être supprimé. Une erreur s'est produite.";
        }else{
            header('Location: index.php');
        }
    }

    if (isset($_POST['UPD'])) {
        $idModify = filter_input(INPUT_POST, "cap");
        $idModify = intval($idModify);
        $_SESSION['idModifyCap'] = $idModify;
        header('Location: modifyProduct.php');
    }
    ?>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="./index.php">
                            <h2>CapShop</h2>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="./index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"> Produits </a></li>
                    <li class="nav-item"><a class="nav-link" href="./profil.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="./commande.php">Commande</a></li>
                    <li class="nav-item"><a class="nav-link" href="./facture.php">Facture</a></li>
                    <li class="nav-item"><a class="nav-link" href="./inscription.php">Inscription</a></li>
                    <li class="nav-item"><a class="nav-link" href="./login.php">Connexion</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>

        <h1 style="color: blue;">CapShop</h1>
        <h2>Des casquettes pour tout le monde !</h2>



        <div class="search-container">
            <form action="./index.php">
                <label for="search"> Rechercher</label><br>
                <input type="text" placeholder="Search..." name="search" value="<?php echo $search ?>">
                <button type="submit" name="valider"><i>Rechercher</i></button>
            </form>
        </div><br>
        <form action="./addproduct.php" method="POST">
            <label for="add">Admin</label><br>
            <input type="submit" name="add" value="Ajouter un produit" class="btn btn-warning">
        </form>
        <?php

        foreach ($records as $cap) {
            echo "<div class=\"card\">";
            echo "<div class=\"container\">";
            echo "<img src=\"./img/cap_default.jpg\" alt=\"cap_default\" style=\"width:100%\">";
            echo "<h4><b>";
            echo $cap->nomModel;
            echo "<br>";
            echo $cap->nomMarque;
            echo '</b></h4>';
            if ($cap->quantity >= 11) {
                echo "<p style='color: green'>$cap->quantity disponibles</p>";
            } else if ($cap->quantity < 11 && $cap->quantity > 0) {
                echo "<p style='color: orange'>$cap->quantity restantes</p>";
            } else {
                echo "<p style='color: red'>Rupture de stock</p>";
            }
            echo "<p>";
            echo $cap->price . " .-";
            echo '</p>';
            echo '<form action="" method="post"><input type="hidden" name="cap" value="' . $cap->id_cap . '">';
            echo '<input type="submit" name="DES" value="' . DESACTIVE_BUTTON . '"><input type="submit" name="UPD" value="' . UPDATE_BUTTON . '"></form>';
            echo "</div>";
            echo "</div>";
        }
        ?>

    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>

</body>

</html>