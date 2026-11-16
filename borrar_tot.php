<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/db.php';

$message = '';
$error = '';

if (request_value('confirmar') !== '') {
    try {
        drop_database();
        $message = 'La base de dades i tots els seus registres han estat esborrats.';
    } catch (PDOException $exception) {
        $error = 'No s\'ha pogut esborrar la base de dades: ' . $exception->getMessage();
    }
}
?>

<h2>Borrar tot</h2>
<p class="warning">Aquesta operació esborra la base de dades <code><?= h(DB_NAME) ?></code> completa.</p>
<?php if ($message): ?><p class="ok"><?= h($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?>

<form method="<?= h(FORM_METHOD) ?>">
    <button class="danger" type="submit" name="confirmar" value="1">Esborrar la base de dades</button>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>
