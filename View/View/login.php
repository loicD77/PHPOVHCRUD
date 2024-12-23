<h2>Connexion</h2>
<link href="css/style.css" rel="stylesheet" type="text/css">

<?php if (isset($info)): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($info); ?></p>
<?php endif; ?>

<form action="index.php?ctrl=user&action=doLogin" method="POST">
    <label>Email :</label>
    <input type="email" name="email" required><br>
    <label>Mot de passe :</label>
    <input type="password" name="password" required><br>
    <button type="submit">Se connecter</button>
</form>
