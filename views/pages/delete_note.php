<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Note</title>
    <link rel='stylesheet' href='../../styles/delete_note.css'>
</head>
<body>
    <main>
        <?php require_once realpath(__DIR__ . '/../partials/navbar.html'); ?>
        <?php require_once realpath(__DIR__ . '/../partials/delete_note_form.html'); ?>
        <?php require_once realpath(__DIR__ . '/../partials/clear_notes_form.html'); ?>
    </main>
    <aside>
        <?php require_once realpath(__DIR__ . '/../partials/data_table.php'); ?>
    </aside>
</body>
</html>