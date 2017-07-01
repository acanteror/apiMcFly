<?php
namespace CoreBundle\Manager;


use CoreBundle\Entity\User;
use CoreBundle\Entity\UserRepository;
use Doctrine\ORM\EntityManagerInterface;


class UserManager {

    /** @var  UserRepository */
    private $repository;

    /** @var  EntityManagerInterface */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository("CoreBundle:User");
        $this->entityManager = $entityManager;
    }

    public function add(User $new){
        $this->entityManager->persist($new);
    }

    public function update(User $new){
        $this->entityManager->persist($new);
    }

    public function applyChanges(){
        $this->entityManager->flush();
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    public function findAll(){
        return $this->repository->findAll();
    }

}