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
	JOIN brands ON models.id_brand = brands.id_brand;";
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
			$row['nomMarque']

		);
		// On place l'objet ECap créé dans le tableau
		array_push($arr, $c);
	}

	// Done
	return $arr;
}

function deleteCap($idCap)
{

	$sql = "DELETE FROM `db_caps`.`caps` WHERE `caps`.`id_cap` = :c";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(":c" => $idCap));
	} catch (PDOException $e) {
		return false;
	}
	// Done
	return true;
}

function modifyCap(){
	
}
