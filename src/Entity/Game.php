<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity
 */
class Game
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
     * @var string
     *
     * @ORM\Column(name="equipeA", type="string", length=250, nullable=false)
     */
    private $equipea;

    /**
     * @var string
     *
     * @ORM\Column(name="equipeB", type="string", length=250, nullable=false)
     */
    private $equipeb;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=250, nullable=false)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipea(): ?string
    {
        return $this->equipea;
    }

    public function setEquipea(string $equipea): static
    {
        $this->equipea = $equipea;

        return $this;
    }

    public function getEquipeb(): ?string
    {
        return $this->equipeb;
    }

    public function setEquipeb(string $equipeb): static
    {
        $this->equipeb = $equipeb;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): static
    {
        $this->date = $date;

        return $this;
    }


}
