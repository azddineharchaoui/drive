<?php

require_once("./classes/User.php");
require_once __DIR__ .'/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        User::login($email, $password);
       
    } else {
        echo "Veuillez remplir tous les champs.";
        header("Location: index.php");
    }
}
