<!DOCTYPE html>
<html lang="en">
<!--
    Auteur: Srijon Rahman
    Date: 04.04.2023
    Projet: Faire un site de vente de casquette en ligne
    Détail: Page affichant la facture de la commande
-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Panier</title>
</head>

<body>
    <?php

    require_once './functions/function_order.php';
    require_once './functions/function_session.php';
    if (!StartSession()) {
        // Pas de session, donc redirection à l'acceuil
        header('Location: /index.php');
        exit;
    }
    $idOrder = $_SESSION['idOrder'];
    $idUser = $_SESSION['idUser'];
    $quantity = 0;
    $price = 0.00;
    $nomModel = "";
    $nomMarque = "";
    $records = getDataOrderCapsById(intval($idOrder));



    $client = GetUserFromSession();

    if ($client === false) {
        // Pas connecté, donc redirection à la page de connection
        header('Location: login.php');
        exit;
    }

    $clienOrder = GetOrderFromSession();

    if ($clienOrder === false) {
        // Pas de commande, donc redirection à la page de commande
        header('Location: commande.php');
        exit;
    }

    if ($records === false) {
        echo "Les commandes ne peuvent être affichées. Une erreur s'est produite.";
        exit;
    }
    foreach ($records as $caps) {
        $quantity = $caps->quantity;
        $price = $caps->unit_price;
    }
    if (isset($_POST['confirm'])) {
        if (ConfirmOrder($idOrder)) {
            header('Location: product.php');
            exit;
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
                    <li class="nav-item"><a class="nav-link active" href="#">Facture</a></li>
                    <li class="nav-item"><a class="nav-link" href="./inscription.php">Inscription</a></li>
                    <li class="nav-item"><a class="nav-link" href="./login.php">Connexion</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <?php


        echo "<div class=\"card\">";
        echo "<div class=\"container\">";
        echo "<img src=\"./img/cap_default.jpg\" alt=\"cap_default\" style=\"width:100%\">";
        echo "<h4><b>";
        echo "</b></h4>";
        echo "<p>Quantité: " . $quantity . "</p>";
        echo "<p>" . $price . " .-</p>";
        echo "</div>";
        echo "</div>";

        ?>
        <form action="#" method="post">
            <input type="submit" name="confirm" value="Confirmer la commande" class="btn btn-primary"><br>
        </form>

    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>

</body>

</html>