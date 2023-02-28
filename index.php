<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 12%;
            background-color: white;
            border-radius: 5px;
            margin: 1%;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 2px 16px;
        }

        img {
            border-radius: 5px 5px 0 0;

        }
        main{
            flex-wrap: wrap;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Accueil</title>
</head>

<body>
    <?php
    session_start();
    require_once './functions.php';

    $tri = filter_input(INPUT_POST, 'tri');
    $filter = array();
    if ((isset($_POST['filter']))) {
        if ($tri == 'Date' || $tri == 'PrixDesc' || $tri == 'PrixAsc' || $tri == 'Marque' || $tri == 'Favoris') {
            array_push($filter, ['name' => 'tri', 'filter' => $tri]);
        }
    }

    function GetSelectedValueByName($filter, $name)
    {
        foreach ($filter as $value) {
            if ($value['name'] == $name) {
                return $value;
            }
        }
        return false;
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
                    <li class="nav-item"><a class="nav-link active" href="#">
                            <h2>CapShop</h2>
                        </a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="./product.php">Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="./profil.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="./panier.php">Panier</a></li>
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
            <option value="Date" <?= GetSelectedValueByName($filter, 'tri')['filter'] == 'Date' ? 'selected' : '' ?>>Date</option>
            <option value="PrixDesc" <?= GetSelectedValueByName($filter, 'tri')['filter'] == 'PrixDesc' ? 'selected' : '' ?>>Prix ></option>
            <option value="PrixAsc" <?= GetSelectedValueByName($filter, 'tri')['filter'] == 'PrixAsc' ? 'selected' : '' ?>>Prix < </option>
            <option value="Marque" <?= GetSelectedValueByName($filter, 'tri')['filter'] == 'Marque' ? 'selected' : '' ?>>Marque</option>
            <option value="Favoris" <?= GetSelectedValueByName($filter, 'tri')['filter'] == 'Favoris' ? 'selected' : '' ?>>Favoris</option>
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
                echo "<p style='color: green'>Disponible</p>";
            } else if ($cap->quantity < 11 && $cap->quantity > 0) {
                echo "<p style='color: orange'>$cap->quantity restantes</p>";
            } else {
                echo "<p style='color: red'>Rupture de stock</p>";
            }
            echo "<p>";
            echo $cap->price . ".-";
            echo '</p>';
            echo "</div>";
            echo "</div>";
        }
        ?>
    </main>
    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>