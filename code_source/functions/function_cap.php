<?php
require_once './db/database.php';
require_once './class/cap.php';
require_once './class/favorite.php';

/**
 * Récupère toutes les casquettes de la base de donnée
 *
 * @return array|bool Un tableau des ECap
 *                    False si une erreur
 */
function getAllCaps()
{
	$arr = array();

	$sql = "SELECT `caps`.`id_cap`, `caps`.`id_model`, `models`.`name` AS `nomModel`, `brands`.`name` AS `nomMarque`, `caps`.`price` AS `price`, `caps`.`description`, 
	`caps`.`quantity` AS `quantity`, `caps`.`active`
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
			$row['active'] 

		);
		// On place l'objet ECap créé dans le tableau
		array_push($arr, $c);
	}

	// Done
	return $arr;
}

function getCapById($idCap)
{
	$arr = array();
	$sql = "SELECT `caps`.`id_cap`, `caps`.`id_model`, `models`.`name` AS `nomModel`, `brands`.`name` AS `nomMarque`, `caps`.`price` AS `price`, `caps`.`description`, 
	`caps`.`quantity` AS `quantity`, `caps`.`active`
	FROM caps
	JOIN models ON caps.id_model = models.id_model
	JOIN brands ON models.id_brand = brands.id_brand
	WHERE active = 1 and caps.id_cap = :ic;";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(':ic' => $idCap));
	} catch (PDOException $e) {
		return false;
	}
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		$c = new ECap(
			intval($row['id_cap']),
			$row['id_model'],
			$row['price'],
			$row['description'],
			$row['quantity'],
			$row['nomModel'],
			$row['nomMarque'],
			$row['active']
		);
		array_push($arr, $c);
	}
	return $arr;
}

/**
 * Rend la casquette non actif et don non visible par l'utilisateur
 *
 * @param integer $idCap L'identifiant de la casquette
 * @return bool true si la requête a été correctement effectué, sinon false 
 */
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

/**
 * Modifie les données de la casquettes dans la base de donnée
 *
 * @param integer $idCap L'identifiant de la casquette
 * @param string $nameModel Le modèle de la casquette
 * @param string $nameMarque La marque de la casquette
 * @param double $price Le prix de la casquette
 * @param string $description La description de la casquette
 * @param integer $quantity la quantité de casquette
 * @return bool true si la requête a été correctement effectué, sinon false 
 */
function modifyCap($idCap, $nameModel, $nameMarque, $price, $description, $quantity)
{

	$sql = "UPDATE db_caps.caps 
	JOIN models ON caps.id_model = models.id_model
	JOIN brands ON models.id_brand = brands.id_brand
	SET `models`.`name` = :nmo, `brands`.`name` = :nma, 
	`caps`.`price` = :p, `caps`.`description` = :d, `caps`.`quantity` = :q
	WHERE `caps`.`id_cap` = :i";
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
 * Insère la casquette dans la base de donnée
 * 
 * @param string $nameModel Le modèle de la casquette
 * @param string $nameMarque La marque de la casquette
 * @param double $price Le prix de la casquette
 * @param string $description La description de la casquette
 * @param integer $quantity la quantité de casquette
 * @return bool true si la requête a été correctement effectué, sinon false 
 */
function addCap($nameModel, $nameMarque, $price, $description, $quantity)
{
	$sql = "INSERT INTO `db_caps`.`caps` (`models`.`name`, `brands`.`name`, `price`, `description`, `quantity`) 
	VALUES(:nmo, :nma, :p, :d, :q)";

	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(
			":nmo" => $nameModel, ":nma" => $nameMarque, ":p" => $price, ":d" => $description, ":q" => $quantity
		));
	} catch (PDOException $e) {
		return false;
	}
	// Fini
	return true;
}


function searchCap($keyword)
{
	$arr = array();
	$sql = "SELECT `caps`.`id_cap`, `caps`.`id_model`, `models`.`name` AS `nomModel`, `brands`.`name` AS `nomMarque`, `caps`.`price` AS `price`, 
	`caps`.`description`, `caps`.`quantity` AS `quantity`, `caps`.`active` 
	FROM `caps` 
	JOIN models ON caps.id_model = models.id_model 
	JOIN brands ON models.id_brand = brands.id_brand
	WHERE `models`.`name` LIKE '%$keyword%' AND active = 1
	ORDER BY `models`.`name`";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute();
	} catch (PDOException $e) {
		return false;
	}
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		$c = new ECap(
			intval($row['id_cap']),
			$row['id_model'],
			$row['price'],
			$row['description'],
			$row['quantity'],
			$row['nomModel'],
			$row['nomMarque'],
			$row['active']
		);
		array_push($arr, $c);
	}
	return $arr;
}

function addFavoriteCap($idUser, $idCap){
	$sql = "INSERT INTO `db_caps`.`favorite` (`id_user`, `id_cap`) 
	VALUES(:u, :c)";

	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(
			":u" => $idUser, ":c" => $idCap
		));
	} catch (PDOException $e) {
		return false;
	}
	// Fini
	return true;
}
