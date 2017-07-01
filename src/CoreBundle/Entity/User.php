<?php
/**
 * Created by PhpStorm.
 * User: ACantero
 * Date: 30/6/17
 * Time: 16:41
 */

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;


/**
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\UserRepository")
 * @ORM\Table(name="users")
 */

class User {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Kiefernwald\DoctrineUuid\Doctrine\ORM\UuidGenerator")
     * @JMS\Groups({"news", "new"})
     *
     *
     */
    protected $id;

    /**
     * @ORM\Column(name="username", type="string", length=255)
     * @JMS\Groups({"message", "messages"})
     */
    protected $username;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function __toString()
    {
        return $this->getUsername();
    }


}