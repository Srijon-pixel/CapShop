<?php

require_once './db/database.php';
require_once './class/cap.php';
require_once './class/order.php';
require_once './class/order_caps.php';
require_once './class/user.php';

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

function getCapById($idCap)
{
	$arr = array();
	$sql = "SELECT `caps`.`id_cap`, `caps`.`id_model`, `models`.`name` AS `nomModel`, `brands`.`name` AS `nomMarque`, `caps`.`price` AS `price`, `caps`.`description`, 
	`caps`.`quantity` AS `quantity`
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
	SET `models`.`name` = :nmo,  `brands`.`name` = :nma, 
	`caps`.`price` = :p, `caps`.`description` = :p, `caps`.`quantity` = :q
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
	VALUES(:nmo, :nma, :p, :d, :q)
	";

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

/*************************************************************************************************************** */
/*************************************************************************************************************** */
/*************************************************************************************************************** */





/**
 * Récupère toutes les utilisateurs de la base de donnée
 *
 * @return array|bool Un tableau des EUser
 *                    False si une erreur
 */
function getAllUser()
{
	$arr = array();

	$sql = "SELECT `users`.`id_user`, `users`.`username`, `users`.`email`, 
	`users`.`password`, `users`.`actif`, `users`.`admin` FROM users WHERE users.actif = 1";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute();
	} catch (PDOException $e) {
		return false;
	}
	// On parcoure les enregistrements 
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		// On crée l'objet EUser en l'initialisant avec les données provenant
		// de la base de données
		$c = new EUser(
			intval($row['id_user']),
			$row['username'],
			$row['email'],
			$row['password'],
			$row['actif'] = 1,
			$row['admin']

		);
		// On place l'objet EUser créé dans le tableau
		array_push($arr, $c);
	}

	// Done
	return $arr;
}

/**
 * Insère l'utilisateur dans la base de donnée
 *
 * @param integer $username le nom de l'utilisateur
 * @param string $email l'email de l'utilisateur
 * @param string $password le mot de passe de l'utilisateur
 * @return bool true si l'insertion a été correctement effectué, sinon false 
 */
function addUser($username, $email, $password)
{
	$sql = "INSERT INTO `db_caps`.`users` (`username`, `email`, `password`) VALUES(:u,:e,:p)";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(":u" => $username, ":e" => $email, ":p" => password_hash($password, PASSWORD_BCRYPT)));
	} catch (PDOException $e) {
		return false;
	}
	// Done
	return true;
}

/**
 * Rend le compte de l'utilisateur inactif et donc impossible de se connecter avec
 *
 * @param integer $idUser l'identifiant de l'utilisateur
 * @return bool true si la requête a été correctement effectué, sinon false 
 */
function desactivateUser($idUser)
{
	$sql = "UPDATE db_caps.users SET users.actif = 0 WHERE `users`.`id_user` = :u";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(":u" => $idUser));
	} catch (PDOException $e) {
		return false;
	}
	// Done
	return true;
}

/**
 * Modifie les données de l'utilisateur dans la base de donnée
 *
 * @param integer $idUser L'identifiant de l'utilisateur
 * @param string $username le nom de l'utilisateur
 * @param string $email l'email de l'utilisateur
 * @param string $password le mot de passe de l'utilisateur
 * @return bool true si la requête a été correctement effectué, sinon false 
 */
function modifyUser($idUser, $username, $email, $password)
{
	$sql = "UPDATE `db_caps`.`users` SET users.username = :n, users.email = :e, users.password = :p  
	WHERE `users`.`id_user` = :u";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(":u" => $idUser, ":n" => $username, ":e" => $email, ":p" => password_hash($password, PASSWORD_BCRYPT)));
	} catch (PDOException $e) {
		return false;
	}
	// Done
	return true;
}

/**
 * Vérifie si le mot de passe répond aux critères pour la syntax
 *
 * @param string $password le mot de pass de l'utilisateur
 * @return bool true si le mot de passe répond à tous les critères, sinon false 
 */
function CheckPasswordSyntax($password)
{
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if ($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8) {
		return $password;
	}
	return false;
}

/**
 * Récupère toutes les données d'un utilisateur de la base de donnée
 *
 * @param integer $idUser L'identifiant de l'utilisateur
 * @return array|bool Un tableau des EUser
 *                    False si une erreur
 */
function getDataUserById($idUser)
{
	$arr = array();
	$sql = "SELECT users.id_user, users.username, users.email, users.password, `users`.`actif`, `users`.`admin` FROM db_caps.users
    WHERE users.id_user = :i and users.actif = 1";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(':i' => $idUser));
	} catch (PDOException $e) {
		return false;
	}
	// On parcoure les enregistrements 
	while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
		$c = new EUser(
			intval($row['id_user']),
			$row['username'],
			$row['email'],
			$row['password'],
			$row['actif'],
			$row['admin']
		);
		array_push($arr, $c);
	}
	return $arr;
}

/**
 * Récupère l'identifiant de l'utilisateur à partir de son email
 *
 * @param string $email l'email de l'utilisateur
 * @return bool true si la requête a été correctement effectué, sinon false 
 */
function getUserId($email)
{
	$sql = "SELECT id_user FROM db_caps.users  WHERE users.email = :e and users.actif = 1";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(':e' => $email));
	} catch (PDOException $e) {
		return false;
	}
	$row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
	return $row['id_user'];
}

/**
 * Vérifie si l'utilisateur existe dans la base de donnée
 *
 * @param string $emailUser l'email de l'utilisateur
 * @param string $passwordUser le mot de passe de l'utilisateur
 * @return bool true si l'utilisateur est bel et bien présent dans la base de donnée, sinon false
 */
function CheckUserExistInDB($emailUser, $passwordUser)
{
	$recordsUser = getAllUser();
	foreach ($recordsUser as $user) {
		if ($emailUser == $user->email) {
			if (password_verify($passwordUser, $user->password)) {
				return true;
			}
		}
	}
	return false;
}

/*************************************************************************************************************** */
/*************************************************************************************************************** */
/*************************************************************************************************************** */

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
	WHERE `orders`.`id_order` = :i";
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
 * @return bool true si la commande existe, sinon false
 */
function getOrderByIdUser($idUser)
{
	$sql = "SELECT `orders`.`id_order`,  `orders`.`is_confirmed` , `orders`.`total_price`, `orders`.`order_date`,
	`orders`.`id_user` 
	FROM orders 
	WHERE `orders`.`id_user` = :u";
	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(':u' => $idUser));
	} catch (PDOException $e) {
		return false;
	}
	$row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
	return $row['id_user'];
}

function ConfirmOrder($idOrder){
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
