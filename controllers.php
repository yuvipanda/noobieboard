<?php

function test() {
    $db = TSDatabase::getConnection( 'ta', 'wiki' );
    var_dump( $db );
}
