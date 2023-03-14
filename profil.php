<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Profile</title>
</head>

<body>
    <?php
    session_start();
    require_once './functions.php';

    const COL_ERROR = "red";

    $idDesactive = -1;
    $idModify = -1;
    $idUser = $_SESSION['idUser'];

    $username = "";
    $email = "";
    $password = "";

    $colUsername = "";
    $colEmail = "";
    $colPassword = "";

    if (isset($_POST['deconnexion'])) {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['desactiver'])) {
        $idDesactive = $idUser;
        $idDesactive = intval($idDesactive);
    }


    if ($idDesactive > 0) {
        if (desactivateUser($idDesactive) == false) {
            echo "Votre compte ne peut pas être supprimé. Une erreur s'est produite.";
        } else {
            session_destroy();
            header('Location: index.php');
        }
    }

    if (isset($_POST['changer'])) {
        $idModify = $idUser;
        $idModify = intval($idModify);

        $username = filter_input(INPUT_POST, 'username');
        if ($username == false) {
            $colUsername = COL_ERROR;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if ($email == false) {
            $colEmail = COL_ERROR;
        }
        $password = filter_input(INPUT_POST, 'password');
        if (CheckPasswordSyntax($password) == false) {
            $colPassword = COL_ERROR;
        }

        if ($idModify > 0 && $colUsername != COL_ERROR && $colEmail != COL_ERROR && $colPassword != COL_ERROR) {
            if (modifyUser($idModify, $username, $email, $password)) {
                header('Location: index.php');
                exit;
            }
        } else {
            echo '<script>alert("Pas possible il vous manque des valeurs ou des valeurs sont fausses")</script>';
        }
        header('Location: profil.php');
    }

    $records = getDataUserById($idUser);
    if ($records === false) {
        echo "Les données de l'utilisateur ne peuvent être affichées. Une erreur s'est produite.";
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
                    <li class="nav-item"><a class="nav-link active" href="#">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="./commande.php">Commande</a></li>
                    <li class="nav-item"><a class="nav-link" href="./panier.php">Panier</a></li>
                    <li class="nav-item"><a class="nav-link" href="./facture.php">Facture</a></li>
                </ul>

            </div>
        </nav>

    </header>
    <main>
        <form action="#" method="POST">
            <?php foreach ($records as $user) {

                echo "<label for=\"username\" style = color:" . $colUsername . ">Votre nom d'utilisateur :</label><br>";
                echo "<input type=\"text\" name=\"username\" value=\"" . $user->username . "\"><br>";
                echo "<label for=\"email\" style = color:" . $colEmail . ">Votre email : </label><br>";
                echo "<input type=\"text\" name=\"email\" value=\"" . $user->email . "\"><br>";
                echo "<label for=\"password\" style = color:" . $colPassword . ">Votre mot de passe : </label><br>";
                echo "<input type=\"text\" name=\"password\" value=\"" . $user->password . "\"><br>";
            } ?>
            <input type="submit" name="changer" value="Changer" class="btn btn-primary"><br>
            <input type="submit" name="deconnexion" value="Déconnexion" class="btn btn-warning"><br>
            <input type="submit" name="desactiver" value="Supprimer mon compte" class="btn btn-danger"><br>
        </form>
    </main>
    <footer>
        &copy;Fait par Mofassel Haque Srijon Rahman <br>
        Contact : srijon.rhmn@eduge.ch
    </footer>

</body>

</html>