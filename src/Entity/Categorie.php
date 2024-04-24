<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    public function __toString() {
        // Retourne la représentation textuelle de l'objet
        // Par exemple, vous pourriez retourner le nom de la catégorie
        return $this->getNomcategorie   (); // Remplacez getNom() par la méthode qui renvoie le nom de la catégorie
    }
    /**
     * @var int
     *
     * @ORM\Column(name="idCategorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCategorie", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Le nom ne doit pas être vide.")
     */
    private $nomcategorie;

    public function getIdcategorie(): ?int
    {
        return $this->idcategorie;
    }

    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    public function setNomcategorie(string $nomcategorie): static
    {
        $this->nomcategorie = $nomcategorie;

        return $this;
    }


}