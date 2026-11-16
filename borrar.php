<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/db.php';

$message = '';
$error = '';

try {
    $pdo = biblioteca_db();

    if (request_value('borrar') !== '') {
        $ids = array_map('intval', request_array('ids'));
        $statement = $pdo->prepare('DELETE FROM `' . TABLE_NAME . '` WHERE id = ?');

        foreach ($ids as $id) {
            if ($id > 0) {
                $statement->execute([$id]);
            }
        }

        $message = $ids ? 'Registres esborrats.' : 'No has seleccionat cap registre.';
    }

    $books = $pdo->query('SELECT * FROM `' . TABLE_NAME . '` ORDER BY id')->fetchAll();
} catch (PDOException $exception) {
    $books = [];
    $error = 'No hi ha una base de dades disponible. Utilitza l\'opció Inicialitzar.';
}
?>

<h2>Borrar registres</h2>
<?php if ($message): ?><p class="ok"><?= h($message) ?></p><?php endif; ?>
<?php if ($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?>

<?php if ($books): ?>
<form method="<?= h(FORM_METHOD) ?>">
    <table>
        <thead><tr><th>Triar</th><th>ID</th><?php foreach (FIELDS as $field): ?><th><?= h($field['label']) ?></th><?php endforeach; ?></tr></thead>
        <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><input type="checkbox" name="ids[]" value="<?= h($book['id']) ?>"></td>
                <td><?= h($book['id']) ?></td>
                <?php foreach (FIELDS as $name => $field): ?><td><?= h($book[$name]) ?></td><?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" name="borrar" value="1">Borrar seleccionats</button>
</form>
<?php elseif (!$error): ?>
<p>No hi ha llibres per esborrar.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
