<!DOCTYPE html>
<html lang="en">

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
    require_once './functions/function_cap.php';
    require_once './functions/function_session.php'; //Permet d'utiliser les fonctions du fichier

    if (!StartSession()) {
        // Pas de session, donc redirection à l'acceuil
        header('Location: /index.php');
        exit;
    }

    $idUser = $_SESSION['idUser'];


    define('CAP', 'cap');
    define('QUANTITY', 'quantity');

    $client = GetUserFromSession();

    if ($client === false) {
        // Pas connecté, donc redirection à la page de connection
        header('Location: login.php');
        exit;
    }

    //Test si les données des champs seront modifiés dans la BD ou pas
    if (isset($_POST['add'])) {
        $dateCommande = date("Y-m-d");

        $idOrder = addOrder($dateCommande, $idUser);
        if (isset($_POST[CAP]) || is_array($_POST[CAP])) {
            foreach ($_POST[CAP] as $idCap => $cap) {

                $capQuantity = filter_var($cap[QUANTITY], FILTER_SANITIZE_NUMBER_INT);
                if ($capQuantity > 0) {
                    if (addOrderCaps(intval($idOrder), $idCap, intval($capQuantity))) {
                        $_SESSION["idOrder"] = $idOrder;
                        header('Location: facture.php');
                        exit;
                    } else {
                        echo '<script>alert("Pas possible il vous manque des valeurs ou des valeurs sont fausses")</script>';
                    }
                }
            }
        }
    }

    $records = getAllCaps();
    if ($records === false) {
        echo "Les casquettes ne peuvent être affichées. Une erreur s'est produite.";
        exit;
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
                    <li class="nav-item"><a class="nav-link active" href="#">Commande</a></li>
                    <li class="nav-item"><a class="nav-link" href="./facture.php">Facture</a></li>
                    <li class="nav-item"><a class="nav-link" href="./inscription.php">Inscription</a></li>
                    <li class="nav-item"><a class="nav-link" href="./login.php">Connexion</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>

        <form action="#" method="post">
        <input type="submit" name="add" value="Ajouter au panier" class="btn btn-primary"><br>

            <?php

            foreach ($records as $cap) {
                echo "<div class=\"card\">";
                echo "<div class=\"container\">";
                echo "<img src=\"./img/cap_default.jpg\" alt=\"cap_default\" style=\"width:100%\">";
                echo "<input type=\"hidden\" name=\"" . CAP . "[" . $cap->id_cap . "]\" value=" . $cap->id_cap . ">";
                echo "<h4><b>";
                echo $cap->nomModel;
                echo "<br>";
                echo $cap->nomMarque;
                echo "</b></h4>";
                if ($cap->quantity >= 11) {
                    echo "<p style='color: green'>$cap->quantity disponibles</p>";
                } else if ($cap->quantity < 11 && $cap->quantity > 0) {
                    echo "<p style='color: orange'>$cap->quantity restantes</p>";
                } else {
                    echo "<p style='color: red'>Rupture de stock</p>";
                }
                echo "<input type=\"number\" max=\"$cap->quantity\" min=0 value = 0 name=\"" . CAP . "[" . $cap->id_cap . "][" . QUANTITY . "]\" ><br>";
                echo "<p>CHF $cap->price</p>";
                echo '';
                echo "</div>";
                echo "</div>";
            }
            ?>
        </form>
    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>

</body>

</html>