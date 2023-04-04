<!DOCTYPE html>
<html lang="en">
<!--
    Auteur: Srijon Rahman
    Date: 04.04.2023
    Projet: Faire un site de vente de casquette en ligne
    Détail: Page d'accueil
-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Accueil</title>
</head>

<body>
    <?php
    session_start();
    require_once './functions/function_cap.php';


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
                    <li class="nav-item"><a class="nav-link active" href="#">
                            <h2>CapShop</h2>
                        </a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="./product.php">Produits</a></li>
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

        <form action="./product.php" method="POST">
            <input type="submit" value="Voir la boutique" class="btn btn-primary">
        </form>
        <br />
        <label for="tri">Filtre: </label><br>
        <select name="tri">
            <option value="Aucun">Aucun </option>
            <option value="PrixDesc">Prix décroissant </option>
            <option value="PrixAsc">Prix croissant </option>
            <option value="Favoris">Favoris</option>
        </select><br>
        <div class="search-container">
            <form action="./index.php">
                <label for="search"> Rechercher</label><br>
                <input type="text" placeholder="Search..." name="search">
                <button type="submit"><i>Rechercher</i></button>
            </form>
        </div><br>
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
            echo "</div>";
            echo "</div>";
        }
        ?>
    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>