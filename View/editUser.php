<h2>Modifier un utilisateur</h2>
<link href="css/style.css" rel="stylesheet" type="text/css">

<?php if (isset($info)): ?>
    <p><?= htmlspecialchars($info); ?></p>
<?php endif; ?>

<form action="index.php?ctrl=user&action=doEditUser" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">
    
    <label>Email :</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required><br>

    <label>Prénom :</label>
    <input type="text" name="firstName" value="<?= htmlspecialchars($user['firstName']); ?>" required><br>

    <label>Nom :</label>
    <input type="text" name="lastName" value="<?= htmlspecialchars($user['lastName']); ?>" required><br>

    <label>Adresse :</label>
    <input type="text" name="address" value="<?= htmlspecialchars($user['address']); ?>" required><br>

    <label>Code Postal :</label>
    <input type="text" name="postalCode" value="<?= htmlspecialchars($user['postalCode']); ?>" required><br>

    <label>Ville :</label>
    <input type="text" name="city" value="<?= htmlspecialchars($user['city']); ?>" required><br>

    <label>Rôle :</label>
    <select name="role" required>
        <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
    </select><br>

    <button type="submit">Modifier</button>
</form>
