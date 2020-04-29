<?php

/* Connexion a la BDD */
$bdd_host = 'localhost';
$bdd_name = 'gbaf';
$bdd_port = '3308';
$bdd_login = 'root';
$bdd_password = '';

$bdd_dns = 'mysql:host=' . $bdd_host . ';port=' . $bdd_port . ';dbname=' . $bdd_name . '';

try
{
	$bdd = new

	PDO($bdd_dns, $bdd_login, $bdd_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	die('Erreur : ' . $e -> getMessage() . '');
}

?>