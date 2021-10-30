<?php

    //Importar la conexion
    require 'includes/config/database.php';
    $db = conectarDb();

    //crear un email y password
    $email = 'correo@correo.com';
    $password = '123456';

    //hashear password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    //query para crear el usuario
    $query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$password_hash}')";

    echo $query;

    exit;

    //agregarlo a la base de datos
    mysqli_query($db, $query);