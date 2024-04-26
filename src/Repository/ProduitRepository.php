<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
    public function countProduitsByCategorie(): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('categorie', 'categorie');
        $rsm->addScalarResult('nombreProduits', 'nombreProduits');

        $query = $this->getEntityManager()->createNativeQuery('
            SELECT c.nomCategorie as categorie, COUNT(p.id) as nombreProduits
            FROM produit p
            LEFT JOIN categorie c ON p.idCategorie = c.idCategorie
            GROUP BY c.nomCategorie
        ', $rsm);

        return $query->getResult();
    }
}
