<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Ajout</title>
</head>

<body>
    <?php
    require_once './functions.php';
    //les constantes
    const COL_ERROR = "red";

    // Les variables de la forme
    $nom = "";
    $idEspece = "";
    $valeurAttaque = "";
    $valeurDefense = "";

    // Les couleurs des libellés des champs
    $colNom = "";
    $colEspece = "";
    $colValeurAttaque = "";
    $colValeurDefense = "";

    if (isset($_POST['add'])) {

        // Vérification du champs nom du model
        $nomModel = filter_input(INPUT_POST, 'nomModel');
        if ($nomModel == false) {
            $colNom = COL_ERROR;
        }

      

       
        // Vérification du champs valeurVitesse avec validation d'un entier
        $valeurVitesse = filter_input(INPUT_POST, 'valeurVitesse', FILTER_VALIDATE_INT);
        if ($valeurVitesse == false) {
            $colValeurVitesse = COL_ERROR;
        }

        $poid = filter_input(INPUT_POST, 'poid', FILTER_SANITIZE_NUMBER_FLOAT);
        if ($poid == false) {
            $colPoid = COL_ERROR;
        }


       
        $description = filter_input(INPUT_POST, 'description');
        if (CheckTexte($description, MIN_LENGTH) == false) {
            $colDescription = COL_ERROR;
        }

      

        if (
            $colNom != COL_ERROR && $colEspece != COL_ERROR && $colCapacite != COL_ERROR
            && $colPoid != COL_ERROR) {
            if (addCap(
                $nom,
                $valeurAttaque,
                $valeurDefense,
                $valeurAttaqueSpecial,

            )) {
                echo "Pas possible il vous manque des valeurs ou des valeurs sont fausses";
            }
            file_put_contents($path . $imgName, $imgData);
            // On copie les informations dans le tableau de la session
            header('Location: pokedex.php');
            exit; // On ne continue pas, ça ne sert à rien
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
                    <li class="nav-item"><a class="nav-link" href="./panier.php">Panier</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <form action="" method="post">
            <label for="nomModel">Model:</label><br>
            <input type="text" name="nomModel"><br>
            <label for="nomMarque">Marque:</label><br>
            <input type="text" name="nomMarque">  <br>
            <label for="stock">Stock:</label><br>
            <input type="number" name="stock"><br>
            <label for="prix">Prix:</label><br>
            <input type="number" name="prix" step="0.01">
        </form>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>