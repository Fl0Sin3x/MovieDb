<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
     * 1

public function findWithFullCategory($id)
    {
        // je crée un querybuilder sur l'objet Movie avec l'alias 'movie'
        $builder = $this->createQueryBuilder('category');
        // je met ma condition de recherche
        $builder->where("category.id = :id");
        // J'ajoute la valeur du parametre utilisé dans ma condition
        $builder->setParameter('id', $id);
        // je crée une jointure avec la table movieactor
        $builder->leftJoin('category.movie', 'movie');
        // J'ajoute l'acteur au select pour que doctrine alimente les objets associés
        $builder->addSelect('movie');
        // j'execute la requete
        $query = $builder->getQuery();
        // je recupére le resultat non pas sous la forme d'un tableau mais un ou 0 objets
        $result = $query->getOneOrNullResult();

        return $result;
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
