<?php

function activeEditors( $project, $lang ) {
    global $app;

    $headers = array(
        'user_name',
        'total_edits',
        'mainspace_edits'
    );

    $fromDate = $app->request()->get('from');

    if( !isset( $fromDate ) || empty( $fromDate ) ) {
        // Defaults to one month till now
        $fromDate = date( 'Ymd', time() - (1 * 30 * 24 * 60 * 60) );
    }

    $fromTimestamp = $fromDate . '000000';

    $db = TSDatabase::getConnection( $lang, $project );
    $query = <<<SQL
        SELECT /* SLOW_OK */ 
            DISTINCT user_name, 
            user_editcount, 
            (SELECT count(*) FROM revision 
                JOIN page ON page_id = rev_page 
                WHERE rev_user = user_id 
                    AND page_namespace = 0 
                    AND rev_timestamp > 20120524000000
            ) AS mainspace_edits 
        FROM user JOIN user_groups ON user_id = ug_user
        ORDER BY mainspace_edits DESC;
SQL;

    $statement = $db->prepare( $query );

    echo $fromTimestamp;

    //$statement->bindParam( ':afterTime', $fromTimestamp, PDO::PARAM_INT );

    while( $row = $statement->fetch() ) {
        var_dump( $row );
        foreach( $row as $val ) {
            echo "$val, ";
        }
        echo "\n";
    }
}
