<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/db.php';

$data = [];
foreach (FIELDS as $name => $field) {
    $data[$name] = request_value($name);
}

$message = '';
$error = '';

if (request_value('guardar') !== '') {
    $missing = missing_fields($data);

    if ($missing) {
        $error = 'Falten els camps: ' . implode(', ', $missing) . '.';
    } else {
        try {
            $columns = implode(', ', array_map(function ($name) {
                return '`' . $name . '`';
            }, array_keys(FIELDS)));
            $marks = implode(', ', array_fill(0, count(FIELDS), '?'));
            $statement = biblioteca_db()->prepare('INSERT INTO `' . TABLE_NAME . '` (' . $columns . ') VALUES (' . $marks . ')');
            $statement->execute(array_values($data));
            $message = 'Llibre afegit correctament.';
            $data = array_fill_keys(array_keys(FIELDS), '');
        } catch (PDOException $exception) {
            $error = 'No s\'ha pogut afegir el llibre. Inicialitza primer la base de dades.';
        }
    }
}
?>

<h2>Afegir registre</h2>
<?php if ($message): ?><p class="ok"><?= h($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?>

<form method="<?= h(FORM_METHOD) ?>">
    <?php foreach (FIELDS as $name => $field): ?>
        <p><?= field_input($name, $data[$name]) ?></p>
    <?php endforeach; ?>
    <button type="submit" name="guardar" value="1">Guardar</button>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>
