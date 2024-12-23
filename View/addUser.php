<h2>Ajouter un utilisateur</h2>
<form action="index.php?ctrl=user&action=doAddUser" method="POST">
    <label for="email">Email :</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="password">Mot de passe :</label><br>
    <input type="password" name="password" id="password" required><br><br>

    <label for="firstName">Prénom :</label><br>
    <input type="text" name="firstName" id="firstName" required><br><br>

    <label for="lastName">Nom :</label><br>
    <input type="text" name="lastName" id="lastName"><br><br>

    <label for="address">Adresse :</label><br>
    <input type="text" name="address" id="address"><br><br>

    <label for="postalCode">Code Postal :</label><br>
    <input type="text" name="postalCode" id="postalCode"><br><br>

    <label for="city">Ville :</label><br>
    <input type="text" name="city" id="city"><br><br>

    <label for="role">Rôle :</label><br>
    <select name="role" id="role">
        <option value="user" selected>Utilisateur</option>
        <option value="admin">Administrateur</option>
    </select><br><br>

    <button type="submit">Ajouter</button>
</form>
