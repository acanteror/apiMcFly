<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    //find one by id
    public function findById($id)
    {
        $sql = $this->createQueryBuilder('c');
        $sql
            ->andWhere('c.id = :id')
            ->setParameter('id', $id);

        $query = $sql->getQuery();
        return $query->getOneOrNullResult();
    }


    //find full list
    public function findAll()
    {
        $sql = $this->createQueryBuilder('c')
            ->orderBy('c.date_creation', 'DESC');

        $query = $sql->getQuery();
        return $query->getResult();
    }



}//class