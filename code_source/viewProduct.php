<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Page-détaillé</title>
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
    define('BUCKET_BUTTON', "Ajouter dans panier");
    define('FAVORI_BUTTON', "Favori");

    $idCap = $_SESSION['idCap'];



    $client = GetUserFromSession();

    if ($client === false) {
        // Pas connecté, donc redirection à la page de connection
        header('Location: login.php');
        exit;
    }

    $clientCap = GetCapFromSession();

    if ($clientCap === false) {
        // Pas de casquette, donc redirection à la page des produits
        header('Location: product.php');
        exit;
    }


    $records = getCapById($idCap);
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
                echo "";
                echo "<p>$cap->description</p>";

                echo "<p> $cap->price  .-</p>";
                echo '<form action="" method="post"><input type="hidden" name="cap" value="' . $cap->id_cap . '">';
                echo '<input type="submit" name="BUC" value="' . BUCKET_BUTTON . '"><input type="submit" name="FAV" value="' . FAVORI_BUTTON . '"></form>';
                echo "</div>";
                echo "</div>";
            }
            ?>
            <input type="submit" name="add" value="Ajouter au panier" class="btn btn-primary"><br>
        </form>
    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>

</body>

</html>