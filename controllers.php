<?php

function generateStats( $project, $lang ) {
    $db = TSDatabase::getConnection( $lang, $project );
    $query = <<<SQL
        SELECT /* SLOW_OK */ 
            DISTINCT user_name, 
            user_editcount, 
            (SELECT count(*) FROM revision 
                JOIN page ON page_id = rev_page 
                WHERE rev_user = user_id 
                    AND page_namespace = 0 
                    AND rev_timestamp > 20120401000000
            ) AS mainspace_edits 
        FROM user JOIN user_groups ON user_id = ug_user;
SQL;
    echo "Blah";

    $statement = $db->query( $query );
    while( $row = $statement->fetch() ) {
        var_dump( $row );
    }
}
