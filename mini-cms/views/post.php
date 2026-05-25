<!doctype html>
<html>
<head><meta charset="utf-8"><title><?php echo htmlspecialchars($post['title'] ?? 'Post'); ?></title></head>
<body>
<?php if (!$post): ?>
    <p>Post not found.</p>
<?php else: ?>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <div><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
<?php endif; ?>
<p><a href="?route=home">Back</a></p>
</body>
</html>
