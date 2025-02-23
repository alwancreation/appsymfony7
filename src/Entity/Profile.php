<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: "profile")]
class Profile
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    protected int $id;

    #[ORM\Column(name: "name", type: "string", length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(name: "roles", type: "text", nullable: true)]
    private $roles = null;

    public function __construct()
    {
    }

    public function __toString(): string
    {
        return $this->name . "";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getRoles(): array|string|null
    {
        return $this->roles;
    }

    public function getArrayRoles(): array|string|null
    {
        return json_decode($this->roles, true);
    }

    public function setRoles(array|string|null $roles): void
    {
        $this->roles = $roles;
    }

    public function removeRole($key): self
    {
        if ($key && isset($this->roles[$key])) {
            unset($this->roles[$key]);
        }
        return $this;
    }

    public function getRolesArrayKies(): array
    {
        $roles = [];
        foreach (self::getRolesArray() as $key => $roleName) {
            $roles[$key] = $key;
        }
        return $roles;
    }

    public function removeAllRoles(): self
    {
        foreach (self::getRolesArray() as $key => $role) {
            $this->removeRole($key);
        }
        return $this;
    }

    public static function getRolesArray(): array
    {
        return User::getRolesArray();
    }
}
