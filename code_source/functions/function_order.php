<?php

require_once './db/database.php';
require_once './class/order.php';
require_once './class/order_caps.php';



/**
 * Insère une commande dans la base de donnée
 *
 * @param integer $idUser L'identifiant de l'utilisateur
 * @return void
 */
function addOrder($date, $idUser)
{
	$sql = "INSERT INTO `db_caps`.`orders` (is_confirmed, order_date, id_user) 
	VALUES(0, :d, :iu)";

	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(
			":d" => $date, ":iu" => $idUser
		));
	} catch (PDOException $e) {
		return false;
	}
	// Retourne l'identifiant de la commande ajouté
	return EDatabase::lastInsertId();
}

function addOrderCaps($idOrder, $idCap, $quantity)
{
	$sqlOrderCap = "INSERT INTO `order_caps`(`id_order`, `id_cap`, `quantity`, `unit_price`)
	VALUE(:o, :ic, :q, :u)";
	$price = getPriceByIdCap($idCap);
	foreach ($price as  $value) {
		$capPrice = $value;
	}
	$statementOrderCap = EDatabase::prepare($sqlOrderCap, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

	try {

		$statementOrderCap->execute(
			array(":o" => $idOrder, ":ic" => $idCap, ":q" => $quantity, ":u" => doubleval($capPrice))
		);
	} catch (PDOException $e) {
		return false;
	}
	// Fini
	return true;
}

function getPriceByIdCap($idCap)
{
	$price_sql = "SELECT price FROM caps WHERE caps.id_cap = :ic;";

	$statementPrice = EDatabase::prepare($price_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statementPrice->execute(array(":ic" => $idCap));
	} catch (PDOException $e) {
		return false;
	}

	return $statementPrice->fetch(PDO::FETCH_ASSOC);
}


/**
 * Récupère toutes les commandes de la base de donnée
 *
 * @param integer $idUser L'identifiant de l'utilisateur
 * @return array|bool Un tableau des EOrder
 *                    False si une erreur
 */
function getAllOrder()
{
	$arr = array();

	$sql = "SELECT `orders`.`id_order`,  `orders`.`is_confirmed` , `orders`.`total_price`, `orders`.`order_date`,
	`orders`.`id_user` FROM orders";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute();
	} catch (PDOException $e) {
		return false;
	}
	// On parcoure les enregistrements 
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		// On crée l'objet EOrder en l'initialisant avec les données provenant
		// de la base de données
		$c = new EOrder(
			intval($row['id_order']),
			$row['is_confirmed'],
			$row['order_date'],
			$row['id_user']
		);
		// On place l'objet EOrder créé dans le tableau
		array_push($arr, $c);
	}

	// Done
	return $arr;
}

/**
 * Récupère les données d'une commande
 *
 * @param [type] $idOrder
 * @param integer $idUser L'identifiant de l'utilisateur
 * @return  array|bool Un tableau des EOrder
 *                    False si une erreur
 */
function getDataOrderById($idOrder)
{
	$arr = array();
	$sql = "SELECT `orders`.`id_order`,  `orders`.`is_confirmed` ,  `orders`.`order_date`,
	`orders`.`id_user` 
	FROM orders 
	WHERE `orders`.`id_order` = :i
	AND orders.is_confirmed = 1";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(':i' => $idOrder));
	} catch (PDOException $e) {
		return false;
	}
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		$c = new EOrder(
			intval($row['id_order']),
			$row['is_confirmed'],
			$row['order_date'],
			$row['id_user']
		);
		array_push($arr, $c);
	}
	return $arr;
}

/**
 * Récupère les données d'une casquette commandé
 *
 * @param integer $idOrder
 * @param integer $idUser L'identifiant de l'utilisateur
 * @return  array|bool Un tableau des EOrder
 *                    False si une erreur
 */
function getDataOrderCapsById($idOrder)
{
	$arr = array();
	$sql = "SELECT `order_caps`.`id_order_caps`, `order_caps`.`id_order`,  `order_caps`.`id_cap`,
	  `order_caps`.`quantity`, `order_caps`.`unit_price` 
	FROM order_caps 
	WHERE `order_caps`.`id_order` = :i";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(':i' => $idOrder));
	} catch (PDOException $e) {
		return false;
	}
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		$c = new EOrderCaps(
			$row['id_order_caps'],
			$row['id_order'],
			$row['id_cap'],
			$row['quantity'],
			doubleval($row['unit_price'])
		);
		array_push($arr, $c);
	}
	return $arr;
}

/**
 * Récupère les commandes d'un utilisateur
 *

 * @param integer $idUser L'identifiant de l'utilisateur
 * @return array|bool true si la commande existe, sinon false
 */
function getOrderByIdUser($idUser)
{
	$sql = "SELECT `orders`.`id_order`,  `orders`.`is_confirmed`,  `orders`.`order_date`,
	`orders`.`id_user` 
	FROM orders 
	WHERE `orders`.`is_confirmed` = 1 AND `orders`.`id_user` = :u";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(':u' => $idUser));
	} catch (PDOException $e) {
		return false;
	}
	$row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
	return $row['id_user'];
}

function ConfirmOrder($idOrder)
{
	$sql = "UPDATE db_caps.orders SET is_confirmed = 1 WHERE orders.id_order = :o";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(":o" => $idOrder));
	} catch (PDOException $e) {
		return false;
	}
	// Done
	return true;
}
