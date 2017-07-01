<?php
namespace CoreBundle\Manager;


use CoreBundle\Entity\Note;
use CoreBundle\Entity\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;


class NoteManager {

    /** @var  NoteRepository */
    private $repository;

    /** @var  EntityManagerInterface */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository("CoreBundle:Note");
        $this->entityManager = $entityManager;
    }

    public function add(Note $new){
        $this->entityManager->persist($new);
    }

    public function update(Note $new){
        $this->entityManager->persist($new);
    }

    public function applyChanges(){
        $this->entityManager->flush();
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    public function findByUserId($userId){
        return $this->repository->findByUserId($userId);
    }

    public function findByIsFav($isFav)
    {
        return $this->repository->findByIsFav($isFav);
    }

    public function findFavourites()
    {
        return $this->repository->findByIsFav(true);
    }

    public function findAll(){
        return $this->repository->findAll();
    }



}