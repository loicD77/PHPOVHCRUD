<?php if (isset($info)): ?>
    <div style="color: red; font-weight: bold; text-align: center; margin: 20px;">
        <?= htmlspecialchars($info); ?>
    </div>
<?php endif; ?>


<?php include_once "header.php"; ?>

<section id="main-section">
    <?php
    if (isset($page)) {
        if ($page == 'home') {
            require './View/home.php';
        } elseif ($page == 'usersList') {
            require './View/usersList.php';
        } elseif ($page == 'addUser') {
            require './View/addUser.php';
        } elseif ($page == 'editUser') { // Ajout de la vue editUser
            require './View/editUser.php';
        } elseif ($page == 'login') {
            require './View/login.php';
        } elseif ($page == 'createAccount') {
            require './View/createAccount.php';
        } elseif ($page == 'unauthorized') {
            require './View/unauthorized.php';
        } else {
            echo "Erreur : la page demandée n'existe pas.";
        }
    }
    ?>
</section>

<?php include_once "footer.php"; ?>
