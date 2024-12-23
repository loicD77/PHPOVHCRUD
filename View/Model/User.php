<?php
class User {
    private ?int $id;
    private string $email;
    private string $password;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $address;
    private ?string $postalCode;
    private ?string $city;
    private string $role;

    public function __construct(array $data = []) {
        $this->hydrate($data);
    }

    public function hydrate(array $data): void {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters et setters
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(?string $firstName): void { $this->firstName = $firstName; }

    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(?string $lastName): void { $this->lastName = $lastName; }

    public function getAddress(): ?string { return $this->address; }
    public function setAddress(?string $address): void { $this->address = $address; }

    public function getPostalCode(): ?string { return $this->postalCode; }
    public function setPostalCode(?string $postalCode): void { $this->postalCode = $postalCode; }

    public function getCity(): ?string { return $this->city; }
    public function setCity(?string $city): void { $this->city = $city; }

    public function getRole(): string { return $this->role; }
    public function setRole(string $role): void { $this->role = $role; }
}
