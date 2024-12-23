<?php
class UserManager {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Crée un nouvel utilisateur
    public function create(User $user): void {
        if ($this->findByEmail($user->getEmail())) {
            throw new Exception("Cet email est déjà utilisé.");
        }

        $stmt = $this->db->prepare("
            INSERT INTO tableuser (email, password, firstName, lastName, address, postalCode, city, role)
            VALUES (:email, :password, :firstName, :lastName, :address, :postalCode, :city, :role)
        ");
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR); // Le mot de passe est déjà haché
        $stmt->bindValue(':firstName', $user->getFirstName(), PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $user->getLastName(), PDO::PARAM_STR);
        $stmt->bindValue(':address', $user->getAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':postalCode', $user->getPostalCode(), PDO::PARAM_STR);
        $stmt->bindValue(':city', $user->getCity(), PDO::PARAM_STR);
        $stmt->bindValue(':role', $user->getRole(), PDO::PARAM_STR);
        $stmt->execute();
    }

    // Vérifie l'utilisateur avec email et mot de passe
    public function findByEmailAndPassword(string $email, string $password): ?array {
        error_log("Recherche d'utilisateur avec l'email : $email");

        $stmt = $this->db->prepare("SELECT * FROM tableuser WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            error_log("Utilisateur trouvé : " . print_r($user, true));

            // Vérifiez si le mot de passe correspond
            if (password_verify($password, $user['password'])) {
                error_log("Mot de passe correct pour : $email");
                return $user;
            } else {
                error_log("Mot de passe incorrect pour : $email");
            }
        } else {
            error_log("Aucun utilisateur trouvé avec l'email : $email");
        }

        return null;
    }

    // Trouve un utilisateur par email
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM tableuser WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Trouve un utilisateur par ID
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM tableuser WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Récupère tous les utilisateurs
    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM tableuser ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Met à jour un utilisateur
    public function update(User $user): void {
        $stmt = $this->db->prepare("
            UPDATE tableuser
            SET email = :email, firstName = :firstName, lastName = :lastName,
                address = :address, postalCode = :postalCode, city = :city, role = :role
            WHERE id = :id
        ");
        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':firstName', $user->getFirstName(), PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $user->getLastName(), PDO::PARAM_STR);
        $stmt->bindValue(':address', $user->getAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':postalCode', $user->getPostalCode(), PDO::PARAM_STR);
        $stmt->bindValue(':city', $user->getCity(), PDO::PARAM_STR);
        $stmt->bindValue(':role', $user->getRole(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    // Supprime un utilisateur
    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM tableuser WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
