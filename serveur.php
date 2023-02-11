<?php
session_start();
$host = 'localhost';
$login = 'root';
$mdp = '';
$db = 'projet';
$dsn = 'mysql:host=' . $host . ';dbname=' . $db;
$pdo = new PDO($dsn, $login, $mdp);
error_log(print_r($_POST, 1));

$sql = 'insert into contact(prenom,nom,email,telephone,adresse,ville,pays) values (:prenom,:nom,:email,:telephone,:adresse,:ville,:pays)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':prenom', $_POST['inputFirstName'], PDO::PARAM_STR);
$stmt->bindParam(':nom', $_POST['inputLastName'], PDO::PARAM_STR);
$stmt->bindParam(':email', $_POST['inputEmail'], PDO::PARAM_STR);
$stmt->bindParam(':telephone', $_POST['inputTel'], PDO::PARAM_STR);
$stmt->bindParam(':adresse', $_POST['inputAddress'], PDO::PARAM_STR);
$stmt->bindParam(':ville', $_POST['inputCity'], PDO::PARAM_STR);
$stmt->bindParam(':pays', $_POST['inputCountry'], PDO::PARAM_STR);
$stmt->execute();

$user_id = $pdo->lastInsertId();

$sql = 'insert into messages(messages) values (:messages)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':messages', $_POST['message'], PDO::PARAM_STR);
$stmt->execute();

$msg_id = $pdo->lastInsertId();

$sql = 'insert into liaisons(id_user,id_msg) values (:id_user,:id_msg)';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_user', $user_id, PDO::PARAM_STR);
$stmt->bindParam(':id_msg', $msg_id, PDO::PARAM_STR);
$stmt->execute();
$_SESSION['message'] = 'votre message a été enregistré';
header('Location: Contact.html');
