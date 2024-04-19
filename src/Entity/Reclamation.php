<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $email = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="typereclamation", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $typereclamation = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptionr", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $descriptionr = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $etat = 'NULL';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTypereclamation(): ?string
    {
        return $this->typereclamation;
    }

    public function setTypereclamation(?string $typereclamation): static
    {
        $this->typereclamation = $typereclamation;

        return $this;
    }

    public function getDescriptionr(): ?string
    {
        return $this->descriptionr;
    }

    public function setDescriptionr(?string $descriptionr): static
    {
        $this->descriptionr = $descriptionr;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }


}
