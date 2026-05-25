<!doctype html>
<html>
<head><meta charset="utf-8"><title>Home - Mini CMS</title></head>
<body>
<h1>Posts</h1>
<?php foreach ($posts as $p): ?>
    <article>
        <h2><a href="?route=post&id=<?php echo htmlspecialchars($p['id']); ?>"><?php echo htmlspecialchars($p['title']); ?></a></h2>
        <p><?php echo nl2br(htmlspecialchars(substr($p['content'], 0, 200))); ?>...</p>
    </article>
<?php endforeach; ?>

<p><a href="?route=admin/login">Admin login</a></p>
</body>
</html>
