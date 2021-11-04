<?php

    function conectarDb() : mysqli{
        $db = new mysqli('localhost', 'root', 'jotaerre01', 'bienes_raices');
        return $db->connect_errno ? die('Error con la conexión a la base de datos') : $db;
    }