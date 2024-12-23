<h2>Liste des utilisateurs</h2>
<link href="css/style.css" rel="stylesheet" type="text/css">

<?php if (isset($info)): ?>
    <p><?= htmlspecialchars($info); ?></p>
<?php endif; ?>

<table border="1" style="width: 100%; text-align: left;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Code Postal</th>
            <th>Ville</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['firstName']); ?></td>
                    <td><?= htmlspecialchars($user['lastName']); ?></td>
                    <td><?= htmlspecialchars($user['address']); ?></td>
                    <td><?= htmlspecialchars($user['postalCode']); ?></td>
                    <td><?= htmlspecialchars($user['city']); ?></td>
                    <td><?= htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="index.php?ctrl=user&action=editUser&id=<?= $user['id']; ?>">Modifier</a> |
                        <a href="index.php?ctrl=user&action=deleteUser&id=<?= $user['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">Aucun utilisateur trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
