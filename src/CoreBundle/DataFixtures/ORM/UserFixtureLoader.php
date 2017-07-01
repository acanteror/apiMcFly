<?php
use CoreBundle\Entity\Company;
use CoreBundle\Entity\GroupCC;
use CoreBundle\Entity\Role;
use CoreBundle\Entity\TypeStatus;
use CoreBundle\Entity\TypeOffer;
use CoreBundle\Entity\TypeProvince;
use CoreBundle\Model\TypeStatusModel;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\FixtureInterface;
use CoreBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtureLoader implements FixtureInterface, ContainerAwareInterface
{

    private $container;


    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        $usernames = ['user1@mail.com', 'user2@mail.com', 'user3@mail.com'];

        foreach ($usernames as $username){
            $user = new User();
            $user->setUsername($username);
            $manager->persist($user);
        }

        $manager->flush();



    }

}