<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("UserDetailsId")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserDetails", cascade={"persist", "remove"})
     * @ORM\Column(type="integer", unique=true, nullable=true)
     */
    private $UserDetailsId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getUserDetailsId(): ?int
    {
        return $this->UserDetailsId;
    }

    public function setUserDetailsId(?int $UserDetailsId): self
    {
        $this->UserDetailsId = $UserDetailsId;

        return $this;
    }
}
