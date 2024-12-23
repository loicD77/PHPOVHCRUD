<?php
class userController {
    private $userManager;

    // Constructeur pour initialiser le UserManager
    public function __construct($db) {
        require_once './Model/User.php';
        require_once './Model/UserManager.php';
        $this->userManager = new UserManager($db);
    }

    // Affiche la page de connexion
    public function login() {
        $page = 'login';
        require './View/default.php';
    }

    // Gère la tentative de connexion
    public function doLogin() {
        if (isset($_POST['email'], $_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            error_log("Tentative de connexion pour : $email");

            $result = $this->userManager->findByEmailAndPassword($email, $password);

            if ($result) {
                // Stocke les informations utilisateur dans la session
                $_SESSION['user'] = $result;
                error_log("Connexion réussie pour : $email");
                $page = 'home';
                $info = "Connexion réussie.";
            } else {
                error_log("Échec de connexion pour : $email");
                $page = 'login';
                $info = "Identifiants incorrects : le mot de passe est erroné ou l'email n'existe pas.";
            }
        } else {
            $page = 'login';
            $info = "Veuillez remplir tous les champs.";
        }
        require './View/default.php';
    }

    // Affiche la page de création d'un compte
    public function create() {
        $page = 'createAccount';
        require './View/default.php';
    }

    // Gère la création d'un compte utilisateur
    public function doCreate() {
        if (isset($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['address'], $_POST['postalCode'], $_POST['city'], $_POST['role'])) {
            $alreadyExist = $this->userManager->findByEmail($_POST['email']);
            if (!$alreadyExist) {
                // Hachage sécurisé du mot de passe
                $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $newUser = new User([
                    'email' => $_POST['email'],
                    'password' => $hashedPassword,
                    'firstName' => $_POST['firstName'],
                    'lastName' => $_POST['lastName'],
                    'address' => $_POST['address'],
                    'postalCode' => $_POST['postalCode'],
                    'city' => $_POST['city'],
                    'role' => $_POST['role']
                ]);

                // Ajout de l'utilisateur dans la base
                $this->userManager->create($newUser);
                error_log("Nouvel utilisateur créé : " . print_r($newUser, true));

                $info = "Compte créé avec succès.";
                $page = 'login';
            } else {
                $info = "L'email est déjà utilisé.";
                $page = 'createAccount';
            }
        } else {
            $info = "Tous les champs sont requis.";
            $page = 'createAccount';
        }
        require './View/default.php';
    }

    // Liste les utilisateurs pour un administrateur
    public function listUser() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $page = 'unauthorized';
            $info = "Vous n'êtes pas autorisé à accéder à cette page.";
        } else {
            $users = $this->userManager->findAll();
            $info = $users ? null : "Aucun utilisateur trouvé dans la base de données.";
            $page = 'usersList';
        }
        require './View/default.php';
    }

    // Supprime un utilisateur (admin uniquement)
    public function deleteUser() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $page = 'unauthorized';
            $info = "Vous n'êtes pas autorisé à supprimer cet utilisateur.";
        } elseif (isset($_GET['id'])) {
            $userId = intval($_GET['id']);
            try {
                $this->userManager->delete($userId);
                $info = "Utilisateur supprimé avec succès.";
            } catch (Exception $e) {
                $info = "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
            }
            $users = $this->userManager->findAll();
            $page = 'usersList';
        } else {
            $info = "Aucun ID d'utilisateur fourni.";
            $page = 'usersList';
        }
        require './View/default.php';
    }

    // Affiche le formulaire de modification d'un utilisateur
    public function editUser() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $page = 'unauthorized';
            $info = "Vous n'êtes pas autorisé à modifier cet utilisateur.";
        } elseif (isset($_GET['id'])) {
            $userId = intval($_GET['id']);
            $user = $this->userManager->findById($userId);
            if ($user) {
                $page = 'editUser';
            } else {
                $info = "Utilisateur non trouvé.";
                $page = 'usersList';
            }
        } else {
            $info = "Aucun ID d'utilisateur fourni.";
            $page = 'usersList';
        }
        require './View/default.php';
    }

    // Met à jour les informations d'un utilisateur
  public function doEditUser() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $page = 'unauthorized';
        $info = "Vous n'êtes pas autorisé à modifier cet utilisateur.";
    } elseif (isset($_POST['id'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['address'], $_POST['postalCode'], $_POST['city'], $_POST['role'])) {
        $updatedUser = new User([
            'id' => intval($_POST['id']),
            'email' => $_POST['email'],
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'address' => $_POST['address'],
            'postalCode' => $_POST['postalCode'],
            'city' => $_POST['city'],
            'role' => $_POST['role']
        ]);

        try {
            $this->userManager->update($updatedUser);
            $info = "Utilisateur modifié avec succès.";

            // Mettre à jour la session si l'utilisateur modifié est celui actuellement connecté
            if ($_SESSION['user']['id'] === $updatedUser->getId()) {
                $_SESSION['user']['firstName'] = $updatedUser->getFirstName();
                $_SESSION['user']['lastName'] = $updatedUser->getLastName();
                $_SESSION['user']['email'] = $updatedUser->getEmail();
                $_SESSION['user']['address'] = $updatedUser->getAddress();
                $_SESSION['user']['postalCode'] = $updatedUser->getPostalCode();
                $_SESSION['user']['city'] = $updatedUser->getCity();
                $_SESSION['user']['role'] = $updatedUser->getRole();
            }

            $users = $this->userManager->findAll();
            $page = 'usersList';
        } catch (Exception $e) {
            $info = "Erreur lors de la mise à jour : " . $e->getMessage();
            $page = 'usersList';
        }
    } else {
        $info = "Tous les champs sont requis pour modifier l'utilisateur.";
        $page = 'usersList';
    }
    require './View/default.php';
}


    // Page d'accueil pour les utilisateurs connectés
    public function home() {
        if (isset($_SESSION['user'])) {
            $page = 'home';
        } else {
            $page = 'login';
        }
        require './View/default.php';
    }

    // Ajout d'un utilisateur par un admin
    public function addUser() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $page = 'unauthorized';
        } else {
            $page = 'addUser';
        }
        require './View/default.php';
    }

    public function doAddUser() {
    // Vérifie si l'utilisateur actuel est un administrateur
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $page = 'unauthorized';
        $info = "Vous n'êtes pas autorisé à ajouter un utilisateur.";
    } elseif (isset($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['address'], $_POST['postalCode'], $_POST['city'], $_POST['role'])) {
        // Vérifie si l'email existe déjà
        $alreadyExist = $this->userManager->findByEmail($_POST['email']);
        if (!$alreadyExist) {
            // Hachage sécurisé du mot de passe
            $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Création de l'objet utilisateur
            $newUser = new User([
                'email' => $_POST['email'],
                'password' => $hashedPassword,
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'address' => $_POST['address'],
                'postalCode' => $_POST['postalCode'],
                'city' => $_POST['city'],
                'role' => $_POST['role']
            ]);

            try {
                // Ajoute l'utilisateur dans la base de données
                $this->userManager->create($newUser);
                $info = "Utilisateur ajouté avec succès.";
            } catch (Exception $e) {
                $info = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            }

            // Recharge la liste des utilisateurs
            $users = $this->userManager->findAll();
            $page = 'usersList';
        } else {
            $info = "L'email est déjà utilisé.";
            $page = 'addUser';
        }
    } else {
        $info = "Tous les champs sont requis pour ajouter un utilisateur.";
        $page = 'addUser';
    }
    require './View/default.php';
}


    // Gère la déconnexion
    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        $info = "Vous avez été déconnecté avec succès.";
        $page = 'login';
        require './View/default.php';
    }
}
