<?php

function activeEditors( $project, $lang ) {
    global $app;

    $headers = array(
        'User',
        'MainSpace Edit Count (For Time Period)',
        'All time all namespace edit count'
    );

    $fromDate = $app->request()->get('from');

    if( !isset( $fromDate ) || empty( $fromDate ) ) {
        // Defaults to one month till now
        $fromDate = date( 'Ymd', time() - (1 * 30 * 24 * 60 * 60) );
    }

    $fromTimestamp = $fromDate . '000000';

    $toDate = date( 'Ymd', time() );
    $filename = "activeEditors-$lang$project-$fromDate-$toDate.csv";

    $db = TSDatabase::getConnection( $lang, $project );
    $query = <<<SQL
        SELECT /* SLOW_OK */ 
            DISTINCT user_name, 
            (SELECT count(*) FROM revision 
                JOIN page ON page_id = rev_page 
                WHERE rev_user = user_id 
                    AND page_namespace = 0 
                    AND rev_timestamp > :afterTime
            ) AS mainspace_edits,
            user_editcount
        FROM user INNER JOIN user_groups ON user_id = ug_user 
        WHERE ug_group != 'bot'
        ORDER BY mainspace_edits DESC;
SQL;

    $statement = $db->prepare( $query );

    $statement->bindParam( ':afterTime', $fromTimestamp, PDO::PARAM_INT );
    $statement->setFetchMode( PDO::FETCH_NUM );
    $statement->execute();

    $response = $app->response();
    $response['Content-Type'] = "text/csv;charset=utf-8";
    $response['Content-disposition'] = "attachment;filename='$filename'";

    echo implode( ',', $headers ) . "\n";
    while( $row = $statement->fetch() ) {
        echo implode( ',', $row ) . "\n";
    }
}
