<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/db.php';

$id = (int) request_value('id');
$data = array_fill_keys(array_keys(FIELDS), '');
$message = '';
$error = '';

try {
    $pdo = biblioteca_db();

    if (request_value('guardar') !== '' && $id > 0) {
        foreach (FIELDS as $name => $field) {
            $data[$name] = request_value($name);
        }

        $missing = missing_fields($data);
        if ($missing) {
            $error = 'Falten els camps: ' . implode(', ', $missing) . '.';
        } else {
            $assignments = [];
            foreach (FIELDS as $name => $field) {
                $assignments[] = '`' . $name . '` = ?';
            }

            $statement = $pdo->prepare('UPDATE `' . TABLE_NAME . '` SET ' . implode(', ', $assignments) . ' WHERE id = ?');
            $statement->execute(array_merge(array_values($data), [$id]));
            $message = 'Llibre modificat correctament.';
        }
    } elseif ($id > 0) {
        $statement = $pdo->prepare('SELECT * FROM `' . TABLE_NAME . '` WHERE id = ?');
        $statement->execute([$id]);
        $book = $statement->fetch();
        if ($book) {
            foreach (FIELDS as $name => $field) {
                $data[$name] = $book[$name];
            }
        } else {
            $error = 'No s\'ha trobat el registre.';
        }
    }

    $books = $pdo->query('SELECT * FROM `' . TABLE_NAME . '` ORDER BY id')->fetchAll();
} catch (PDOException $exception) {
    $books = [];
    $error = 'No hi ha una base de dades disponible. Utilitza l\'opció Inicialitzar.';
}
?>

<h2>Modificar registre</h2>
<?php if ($message): ?><p class="ok"><?= h($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?>

<?php if ($id > 0 && !$error): ?>
<form method="<?= h(FORM_METHOD) ?>">
    <input type="hidden" name="id" value="<?= h($id) ?>">
    <?php foreach (FIELDS as $name => $field): ?>
        <p><?= field_input($name, $data[$name]) ?></p>
    <?php endforeach; ?>
    <button type="submit" name="guardar" value="1">Guardar canvis</button>
</form>
<?php elseif ($books): ?>
<p>Selecciona el llibre que vols modificar:</p>
<ul>
    <?php foreach ($books as $book): ?>
        <li><a href="<?= h(page_url('modificar.php', ['id' => $book['id']])) ?>">Modificar #<?= h($book['id']) ?> - <?= h($book['titol']) ?></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
