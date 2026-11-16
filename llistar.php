<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/db.php';

$books = [];
$error = '';

try {
    $books = biblioteca_db()->query('SELECT * FROM `' . TABLE_NAME . '` ORDER BY id')->fetchAll();
} catch (PDOException $exception) {
    $error = 'No hi ha una base de dades disponible. Utilitza l\'opció Inicialitzar.';
}
?>

<h2>Llistat de llibres</h2>
<?php if ($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?>

<?php if ($books): ?>
<table>
    <thead>
        <tr><th>ID</th><?php foreach (FIELDS as $field): ?><th><?= h($field['label']) ?></th><?php endforeach; ?></tr>
    </thead>
    <tbody>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= h($book['id']) ?></td>
            <?php foreach (FIELDS as $name => $field): ?><td><?= h($book[$name]) ?></td><?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php elseif (!$error): ?>
<p>No hi ha llibres registrats.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
