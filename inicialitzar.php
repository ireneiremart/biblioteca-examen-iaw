<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/db.php';

$message = '';
$error = '';

if (request_value('crear') !== '') {
    try {
        initialize_database();
        $message = 'La base de dades biblioteca i la taula Llibres ja estan inicialitzades.';
    } catch (PDOException $exception) {
        $error = 'No s\'ha pogut inicialitzar: ' . $exception->getMessage();
    }
}
?>

<h2>Inicialitzar</h2>
<p>Aquesta opció crea la base de dades <code><?= h(DB_NAME) ?></code> i la taula <code><?= h(TABLE_NAME) ?></code>.</p>

<?php if ($message): ?><p class="ok"><?= h($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?>

<form method="<?= h(FORM_METHOD) ?>">
    <button type="submit" name="crear" value="1">Crear base de dades i taula</button>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>
