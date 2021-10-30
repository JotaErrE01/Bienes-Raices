<?php

    require 'app.php';

    function incluirTemplate( string $nombre, bool $inicio = false ){
        include( TEMPLATES_URL . "/${nombre}.php" );
    }

    function isAuthenticated() : bool {
        session_start();
        $auth = $_SESSION['login'];
        return $auth ? true : false;
    }