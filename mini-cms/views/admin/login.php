<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Login</title></head>
<body>
<h1>Login</h1>
<?php if (!empty($error)): ?><p style="color:red"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
<form method="post">
    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars(csrf_token()); ?>">
    <label>Username: <input name="username"></label><br>
    <label>Password: <input type="password" name="password"></label><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
