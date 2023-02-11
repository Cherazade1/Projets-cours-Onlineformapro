<?php
session_start();
$host = 'localhost';
$login = 'root';
$mdp = '';
$db = 'projet';
$dsn = 'mysql:host=' . $host . ';dbname=' . $db;
$pdo = new PDO($dsn, $login, $mdp);
$_SESSION = [];
error_log(print_r($_POST, 1));
//$hash = password_hash($_POST['inputMdp'], PASSWORD_DEFAULT);
$sql = 'select * from admin where login like :login and statut=1';

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":login", $_POST['inputLogin'], PDO::PARAM_STR);
//$stmt->bindParam(':mdp', $_POST['inputMdp'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);


if ($result !== false) {
    $hash = $result[0]->mdp;

    if (password_verify($_POST['inputMdp'], $hash)) {
        error_log("Connexion possible");
        $_SESSION['login'] = $result[0]->login;
        $_SESSION['id'] = $result[0]->id;
        $_SESSION['statut'] = $result[0]->statut;
        header('location:printDashboard.php');
    } else {
        header('location:Administration.html');
    }
} else {
    header('location:Administration.html');
}
