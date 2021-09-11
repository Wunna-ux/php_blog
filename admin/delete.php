<?php

require '../config/config.php';
$stmt = $pdo->prepare("DELETE FROM posts where id=".$_GET['id']);
$stmt->execute();

header("Location: index.php");

?>