<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $index;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $index_start_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $some_number;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $floater;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bully;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function setIndex(int $index): self
    {
        $this->index = $index;

        return $this;
    }

    public function getIndexStartAt(): ?int
    {
        return $this->index_start_at;
    }

    public function setIndexStartAt(?int $index_start_at): self
    {
        $this->index_start_at = $index_start_at;

        return $this;
    }

    public function getSomeNumber(): ?int
    {
        return $this->some_number;
    }

    public function setSomeNumber(?int $some_number): self
    {
        $this->some_number = $some_number;

        return $this;
    }

    public function getFloater(): ?float
    {
        return $this->floater;
    }

    public function setFloater(?float $floater): self
    {
        $this->floater = $floater;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBully(): ?bool
    {
        return $this->bully;
    }

    public function setBully(?bool $bully): self
    {
        $this->bully = $bully;

        return $this;
    }
}
