<?php

require_once __DIR__ . '/config.php';

function mysql_connection($with_database = true)
{
    $database = $with_database ? ';dbname=' . DB_NAME : '';
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . $database . ';charset=utf8mb4';

    return new PDO($dsn, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

function biblioteca_db()
{
    return mysql_connection(true);
}

function initialize_database()
{
    $pdo = mysql_connection(false);
    $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . DB_NAME . '`');

    $columns = [
        '`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY'
    ];

    foreach (FIELDS as $name => $field) {
        $columns[] = '`' . $name . '` ' . $field['sql'] . ' NOT NULL';
    }

    $sql = 'CREATE TABLE IF NOT EXISTS `' . TABLE_NAME . '` (' . implode(', ', $columns) . ') ENGINE=InnoDB';
    $pdo->exec($sql);

    return $pdo;
}

function drop_database()
{
    $pdo = mysql_connection(false);
    $pdo->exec('DROP DATABASE IF EXISTS `' . DB_NAME . '`');
}
