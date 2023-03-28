<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Inscription</title>
</head>

<body>
    <?php
    session_start();
    require_once './functions.php';

    //variables
    const COL_ERROR = "red";

    $username = "";
    $email = "";
    $password = "";
    $cpassword = "";

    $colUsername = "";
    $colEmail = "";
    $colPassword = "";
    $colCPassword = "";

    if (isset($_POST['inscription'])) {

        $username = filter_input(INPUT_POST, 'username');
        if ($username == false) {
            $colUsername = COL_ERROR;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if ($email == false) {
            $colEmail = COL_ERROR;
        }

        $password = filter_input(INPUT_POST, 'password');
        $cpassword = filter_input(INPUT_POST, 'cpassword');
        if (CheckPasswordSyntax($password) == false || $password !== $cpassword) {
            $colPassword = COL_ERROR;
            $colCPassword = COL_ERROR;
        }

        if ($colUsername != COL_ERROR && $colEmail != COL_ERROR && $colPassword != COL_ERROR && $colCPassword != COL_ERROR) {
            if (addUser($username, $email, $password)) {
                header('Location: login.php');
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
                    <li class="nav-item"><a class="nav-link active" href="#">Inscription</a></li>
                    <li class="nav-item"><a class="nav-link" href="./login.php">Connexion</a></li>

                </ul>
            </div>
        </nav>
    </header>
    <main>

        <form action="#" method="POST">
            <label for="username" style="color:<?php echo $colUsername; ?>">Nom d'utilisateur</label><br>
            <input type="text" name="username" value="<?php echo $username;?>"> <br>
            <label for="email" style="color:<?php echo $colEmail; ?>">Email:</label><br>
            <input type="text" name="email" value="<?php echo $email;?>"><br>
            <label for="password" style="color:<?php echo $colPassword; ?>" placeholder="Minimum une majuscule, une minuscule, un chiffre, un symbole et 8 caractères">Mot de passe : </label><br>
            <input type="password" name="password" value="<?php echo $password;?>"><br>
            <label for="cpassword" style="color:<?php echo $colCPassword; ?>" placeholder="Minimum une majuscule, une minuscule, un chiffre, un symbole et 8 caractères">Confirmation du mot de passe : </label><br>
            <input type="password" name="cpassword" value="<?php echo $cpassword;?>"><br>
            <input type="submit" name="inscription" value="S'inscrire" class="btn btn-primary">
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