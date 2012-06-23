<?php

class TSDatabase {
    private static function getHostname( $language, $project ) {
        return "$language$project-p.rrdb.toolserver.org";
    }

    private static function getDBName( $language, $project ) {
        return "$language$project" . "_p";
    }

    public static function getConnection( $language, $project ) {
        global $dbUser, $dbPassword;

        $host = TSDatabase::getHostname( $language, $project );
        $database = TSDatabase::getDBName( $language, $project );

        $db = new PDO( "mysql:host=$host;dbname=$database", $dbUser, $dbPassword );
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  

        return $db;
    }
}
