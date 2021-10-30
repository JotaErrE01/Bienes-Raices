<?php

    function conectarDb() : mysqli{
        $db = mysqli_connect('localhost', 'root', 'jotaerre01', 'bienes_raices');
        if ($db->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
            exit;
        }
        return $db;
    }