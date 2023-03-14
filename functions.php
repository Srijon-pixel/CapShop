<?php

require_once './db/database.php';
require_once './class/cap.php';
require_once './class/order.php';
require_once './class/user.php';

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

function addOrderCaps($idCap, $quantity, $unitPrice)
{
	$sql = "INSERT INTO `db_caps`.`order_caps` (id_cap, quantity, unit_price) 
	VALUES(:ic, :q, :u)";

	$statement = EDatabase::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	try {
		$statement->execute(array(
			":ic" => $idCap, ":q" => $quantity, ":u" => $unitPrice
		));
	} catch (PDOException $e) {
		return false;
	}
	// Fini
	return true;
}

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
			$row['total_price'],
			$row['order_date'],
			$row['id_user']
		);
		// On place l'objet EOrder créé dans le tableau
		array_push($arr, $c);
	}

	// Done
	return $arr;
}
