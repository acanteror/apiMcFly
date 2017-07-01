<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class NoteRepository extends EntityRepository
{

    public function findById($id)
    {
        $sql = $this->createQueryBuilder('c');
        $sql
            ->andWhere('c.id = :id')
            ->setParameter('id', $id);

        $query = $sql->getQuery();
        return $query->getOneOrNullResult();
    }

    public function findByUserId($idUser)
    {
        $sql = $this->createQueryBuilder('c');
        $sql
            ->andWhere('c.user = :user')
            ->setParameter('user', $idUser)
            ->orderBy('c.date_creation', 'DESC')
        ;

        $query = $sql->getQuery();
        return $query->getResult();
    }

    public function findByIsFav($isFav)
    {
        $sql = $this->createQueryBuilder('c');
        $sql
            ->andWhere('c.isFav = :isFav')
            ->setParameter('isFav', $isFav)
            ->orderBy('c.date_creation', 'DESC')
        ;

        $query = $sql->getQuery();
        return $query->getResult();
    }

    public function findAll()
    {
        $sql = $this->createQueryBuilder('c')
            ->orderBy('c.date_creation', 'DESC');

        $query = $sql->getQuery();
        return $query->getResult();
    }



}//class