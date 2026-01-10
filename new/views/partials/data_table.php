<h2>Table</h2>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Publish Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notes as $note): ?>
        <tr>
            <td><?= $note['ID'] ?></td>
            <td><?= $note['title'] ?></td>
            <td><?= $note['content'] ?></td>
            <td><?= $note['publish_date'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>