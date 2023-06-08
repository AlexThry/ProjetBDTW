<?php

const DB_USER_NAME = 'root';
const DB_PASSWORD  = '';

/**
 * Database class
 */
final class Database {


    public static function setup() {
        self::connect_db();
    }

    public static function connect_db() {
        global $conn;

        $conn = new mysqli( 'localhost', DB_USER_NAME, DB_PASSWORD );

        if ( ! $conn ) {
            echo 'Erreur de connexion à la bdd';
        }

        $conn->query( 'USE info633' );
        $conn->query( 'SET NAMES utf8' );
    }
}

Database::setup();


