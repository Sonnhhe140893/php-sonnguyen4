<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin - Posts</title></head>
<body>
<h1>Manage Posts</h1>
<p>Logged in as <?php echo htmlspecialchars($_SESSION['user'] ?? ''); ?> - <a href="?route=home">View site</a></p>

<h2>Create</h2>
<form method="post">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
    <input name="title" placeholder="Title"><br>
    <textarea name="content" placeholder="Content"></textarea><br>
    <button name="create">Create</button>
</form>

<h2>Existing</h2>
<?php foreach ($posts as $p): ?>
    <form method="post" style="border:1px solid #ccc;padding:8px;margin:8px 0;">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
        <input type="hidden" name="id" value="<?php echo (int)$p['id']; ?>">
        <input name="title" value="<?php echo htmlspecialchars($p['title']); ?>"><br>
        <textarea name="content"><?php echo htmlspecialchars($p['content']); ?></textarea><br>
        <button name="update">Update</button>
        <button name="delete" onclick="return confirm('Delete?')">Delete</button>
    </form>
<?php endforeach; ?>
</body>
</html>
