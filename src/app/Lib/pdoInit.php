<?php

function pdoInit(): PDO
{
	$dbUserName = "docker";
	$dbPassword = "docker";
	$pdo = new PDO(
		"mysql:host=mysql; dbname=todo; charset=utf8",
		$dbUserName,
		$dbPassword
	);
	return $pdo;
}