<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Modifier la casquette</title>
</head>

<body>
    <?php
    session_start();
    require_once './functions.php';

    //variables
    const COL_ERROR = "red";

    $nomModel = "";
    $nomMarque = "";
    $price = 0.00;
    $description = "";
    $quantity = 0;

    $colNomModel = "";
    $colNomMarque = "";
    $colPrice = "";
    $colDescription = "";
    $colQuantity = "";

    //récupère l'idModify de la page index.php
    $idModify = $_SESSION['idModifyCap'];

    //Test si les données des champs seront modifiés dans la BD ou pas
    if (isset($_POST['update'])) {

        $nomModel = filter_input(INPUT_POST, 'nomModel');
        if ($nomModel == false) {
            $colNomModel = COL_ERROR;
        }

        $nomMarque = filter_input(INPUT_POST, 'nomMarque');
        if ($nomMarque == false) {
            $colNomMarque = COL_ERROR;
        }
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        if ($price == false || $price < 0) {
            $colPrice = COL_ERROR;
        }
        $description = filter_input(INPUT_POST, 'description');
        if ($description == false) {
            $colDescription = COL_ERROR;
        }
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
        if (intval($quantity) == false || $quantity < 0) {
            $colQuantity = COL_ERROR;
        }
        if ($colNomModel != COL_ERROR && $colNomMarque != COL_ERROR && $colPrice != COL_ERROR && $colDescription != COL_ERROR && $colQuantity != COL_ERROR) {
            if (modifyCap($idModify, $nomModel, $nomMarque, $price, $description, intval($quantity))) {
                header('Location: index.php');
                exit;
            }
        } else {
            echo '<script>alert("Pas possible il vous manque des valeurs ou des valeurs sont fausses")</script>';
        }
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
                    <li class="nav-item"><a class="nav-link" href="./product.php"> Produits </a></li>
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
        <form action="#" method="post">
            
            <div class="container">
                <div class="row">
                    <div class="col shadow p-3 mb-5 bg-light rounded">
                        <p>
                            <label for="nomModel" style="color:<?php echo $colNomModel; ?>">Nom du modèle: </label><br>
                            <input type="text" name="nomModel" value="<?php echo $nomModel; ?>">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col shadow p-3 mb-5 bg-light rounded">
                    <p>
                            <label for="nomMarque" style="color:<?php echo $colNomMarque; ?>">Nom du marque: </label><br>
                            <input type="text" name="nomMarque" value="<?php echo $nomMarque; ?>">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col shadow p-3 mb-5 bg-light rounded">
                        <p>
                            <label for="price" style="color:<?php echo $colPrice; ?>">Prix: </label><br>
                            <input type="number" name="price" step="0.05" value="<?php echo $price; ?>">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col shadow p-3 mb-5 bg-light rounded">
                        <p>
                            <label for="description" style="color:<?php echo $colDescription; ?>">Description: </label><br>
                            <input type="text" name="description" step="0.05" value="<?php echo $description; ?>">
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col shadow p-3 mb-5 bg-light rounded">
                        <p>
                            <label for="quantity" style="color:<?php echo $colQuantity; ?>">Quantité: </label><br>
                            <input type="number" name="quantity" value="<?php echo $quantity; ?>">
                        </p>
                    </div>
                </div>
                <p>
                    <input type="submit" name="update" value="Modifer la casquette" class="btn btn-primary">
                </p>
        </form>
    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>