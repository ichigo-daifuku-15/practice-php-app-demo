<h1>Articles</h1>
<table>
    <tr>
        <th>Title</th>
        <th>Body</th>
        <th>Created</th>
        <th>Modified</th>
    </tr>
    <?php foreach ($articles as $article): ?>
    <tr>
        <td><?= h($article->title) ?></td>
        <td><?= h($article->body) ?></td>
        <td><?= h($article->created) ?></td>
        <td><?= h($article->modified) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
