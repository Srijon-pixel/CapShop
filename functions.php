<?php

require_once './db/database.php';
require_once './class/cap.php';

/**
 * Récupère tous les outils
 *
 * @return array|bool Un tableau des ECap
 *                    False si une erreur
 */
function getAllCaps()
{
	$arr = array();

	$sql = "SELECT `caps`.`id_cap`, `caps`.`id_model`, `models`.`name` AS `nomModel`, `brands`.`name` AS `nomMarque`, `caps`.`price` AS `price`, `caps`.`description`, 
	`caps`.`quantity` AS `quantity`
	FROM caps
	JOIN models ON caps.id_model = models.id_model
	JOIN brands ON models.id_brand = brands.id_brand
	WHERE active = 1;";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute();
	} catch (PDOException $e) {
		return false;
	}
	// On parcoure les enregistrements 
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		// On crée l'objet ECap en l'initialisant avec les données provenant
		// de la base de données
		$c = new ECap(
			intval($row['id_cap']),
			$row['id_model'],
			$row['price'],
			$row['description'],
			$row['quantity'],
			$row['nomModel'],
			$row['nomMarque'],
			$row['active'] = 1

		);
		// On place l'objet ECap créé dans le tableau
		array_push($arr, $c);
	}

	// Done
	return $arr;
}

function desactivateCap($idCap)
{

	$sql = "UPDATE db_caps.caps SET active = 0 WHERE caps.id_cap = :c";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(":c" => $idCap));
	} catch (PDOException $e) {
		return false;
	}
	// Done
	return true;
}

function modifyCap($idCap, $nameModel, $nameMarque, $price, $description, $quantity){
	$sql = "UPDATE db_caps.caps SET `models`.`name` AS `nomModel` = :nmo,  `brands`.`name` AS `nomMarque` = :nma, 
	`caps`.`price` = :p, `caps`.`description` = :p, `caps`.`quantity` = :q
	JOIN models ON caps.id_model = models.id_model
	JOIN brands ON models.id_brand = brands.id_brand
	WHERE `caps`.`id_caps` = :i";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(":i" => $idCap, ":nmo" => $nameModel, ":nma" => $nameMarque, ":p" => $price, ":d" => $description, ":q" => $quantity));
	} catch (PDOException $e) {
		return false;
	}
	// Done
	return true;
}

/**
 * Vérifier que la chaîne de caractères est valide pour un age.
 * Doit contenir uniquement des chiffres et l'âge doit être compris
 * entre le min et max inclus.
 *
 * @param string $nb
 * @param integer $min Le nombre minimimum. Défaut est 0.
 * @param integer $max Le nombre  maximum. Défaut est 130.
 * @return integer Le nombre en integer.
 *                 Si la chaîne de caractère ne contient pas un nombre valide
 *                 False est retourné.
 */
function CheckNumberPositiv($nb, $min = 0, $max = 130)
{
	if (is_numeric($nb)) {
		$num = intval($nb);
		// Si valide, on vérifie les bornes
		if ($num >= $min && $num <= $max)
			return $num;   // Si valide, on retourne le $num sous format numérique
	}
	// Si on arrive ici, une erreur s'est produite
	return false;
}

/*
UPDATE db_caps.caps SET 
`models`.`name` = "lksfjv",  
`brands`.`name` = "ésalkjv", 
-- do later
`caps`.`price` = 0.15, 
`caps`.`description` = "kjsah",
`caps`.`quantity` = 6
-- end do later
FROM db_caps.caps
	LEFT JOIN models ON caps.id_model = models.id_model
	LEFT JOIN brands ON models.id_brand = brands.id_brand
    WHERE `caps`.`id_cap` = 3
 */