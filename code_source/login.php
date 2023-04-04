<!DOCTYPE html>
<html lang="en">
<!--
    Auteur: Srijon Rahman
    Date: 04.04.2023
    Projet: Faire un site de vente de casquette en ligne
    Détail: Page de connexion pour l'utilisateur
-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Connexion</title>
</head>

<body>
    <?php
    session_start();
    require_once './functions/function_user.php';

    //variables
    const COL_ERROR = "red";

    $email = "";
    $password = "";

    $colEmail = "";
    $colPassword = "";

    if (isset($_POST['connexion'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if ($email == false) {
            $colEmail = COL_ERROR;
        }

        $password = filter_input(INPUT_POST, 'password');
        if ($password == false) {
            $colPassword = COL_ERROR;
        }

        if ($colPassword != COL_ERROR && $colEmail != COL_ERROR) {
            if(CheckUserExistInDB($email,$password)){
                $_SESSION['idUser'] = getUserIdByEmail($email);
                header("location: profil.php");
                exit();
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
                    <li class="nav-item"><a class="nav-link active" href="#">Connexion</a></li>

                </ul>
            </div>
        </nav>
    </header>
    <main>





        <form action="#" method="POST">
            <label for="email">Email:</label><br>
            <input type="text" name="email" value="<?php echo $email;?>"><br>
            <label for="password">Mot de passe : </label><br>
            <input type="password" name="password" value="<?php echo $password;?>"><br>
            <input type="submit" name="connexion" value="Se connecter" class="btn btn-primary"><br>
            <a href="./inscription.php">Pas de compte ?</a>
        </form>
        <?php


        ?>

    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>

</body>

</html>