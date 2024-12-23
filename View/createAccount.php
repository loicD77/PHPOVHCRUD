<h2>Créer un compte</h2>
<form action="index.php?ctrl=user&action=doCreate" method="POST">
    <label for="email">Email :</label><br>
    <input type="email" name="email" required><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" required><br>

    <label for="firstName">Prénom :</label><br>
    <input type="text" name="firstName"><br>

    <label for="lastName">Nom :</label><br>
    <input type="text" name="lastName"><br>

    <label for="address">Adresse :</label><br>
    <input type="text" name="address"><br>

    <label for="postalCode">Code Postal :</label><br>
    <input type="text" name="postalCode"><br>

    <label for="city">Ville :</label><br>
    <input type="text" name="city"><br>

    <label for="role">Rôle :</label><br>
    <select name="role">
        <option value="user" selected>Utilisateur</option>
        <option value="admin">Administrateur</option>
    </select><br><br>

    <button type="submit">Créer un compte</button>
</form>
