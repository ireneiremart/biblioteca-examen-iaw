<?php

require_once __DIR__ . '/helpers.php';
?><!doctype html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h(APP_TITLE) ?></title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
<header>
    <h1><?= h(APP_TITLE) ?></h1>
    <nav>
        <a href="index.php">Inici</a>
        <a href="afegir.php">Afegir registre</a>
        <a href="llistar.php">Llistar</a>
        <a href="borrar.php">Borrar</a>
        <a href="modificar.php">Modificar</a>
        <a href="borrar_tot.php">Borrar tot</a>
        <a href="inicialitzar.php">Inicialitzar</a>
    </nav>
</header>
<main>
