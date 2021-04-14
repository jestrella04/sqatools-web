<?php

$sqlite = 'log/log.sqlite';

function truncateLog()
{
    global $sqlite;

    $db = new SQLite3($sqlite);
    $db->exec('DELETE FROM "log"');
}

function logResponse($type, $body)
{
    global $sqlite;

    $db = new SQLite3($sqlite);
    $db->exec('CREATE TABLE IF NOT EXISTS "log" ("date" TEXT, "type" TEXT, "response" TEXT)');

    $log = $db->prepare('INSERT INTO "log" ("date", "type", "response") VALUES(?, ?, ?)');
    $log->bindValue(1, date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $log->bindValue(2, $type, SQLITE3_TEXT);
    $log->bindValue(3, $body, SQLITE3_TEXT);
    $log->execute()->finalize();
}

function getResponseReport($p = 1, $limit = 50)
{
    global $sqlite;

    $db = new SQLite3($sqlite);

    // Calculate SQL offset based on current page
    if (1 == $p) {
        $offset = 0;
    } else {
        $offset = ((intval($p) - 1) * intval($limit)) + 1;
    }

    //Query database
    $res = $db->query('SELECT rowid, * FROM "log" ORDER BY "date" DESC LIMIT ' . $offset . ', ' . $limit);
    $all = array();
    $i = 0;

    while ($row = $res->fetchArray()) {
        $all[$i] = $row;
        $i++;
    }

    return $all;
}

function getResponseLogCount()
{
    global $sqlite;

    $db = new SQLite3($sqlite);

    return $db->querySingle('SELECT count("id") AS "counter" FROM log');
}
