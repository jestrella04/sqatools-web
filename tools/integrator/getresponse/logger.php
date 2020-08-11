<?php

function truncateLog() {
    $db = new SQLite3('log.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
    $db->exec('DELETE FROM "log"');
}

function logResponse($type, $body) {
    $db = new SQLite3('log.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
    $log = $db->prepare('INSERT INTO "log" ("date", "type", "response") VALUES(?, ?, ?)');
    $log->bindValue(1, date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $log->bindValue(2, $type, SQLITE3_TEXT);
    $log->bindValue(3, $body, SQLITE3_TEXT);
    $log->execute()->finalize();
}

function getResponseReport($p = 1, $limit = 50) {
    $db = new SQLite3('log.sqlite');
    
    // Calculate SQL offset pased on current page
    if (1 == $p) {
        $offset = 0;
    } else {
        $offset = ((intval($p) - 1) * intval($limit)) + 1;
    }
    
    //Query database
    $res = $db->query('SELECT * FROM "log" ORDER BY "date" DESC LIMIT '. $offset.', '. $limit .'');
    $all = array();
    $i = 0;
    
    while ($row = $res->fetchArray()) {
        $all[$i] = $row;
        $i++;
    }
    
    return $all;
}

function getResponseLogCount() {
    $db = new SQLite3('log.sqlite');
    
    return $db->querySingle('SELECT count("id") AS "counter" FROM log');
}
