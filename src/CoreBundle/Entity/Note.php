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
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\NoteRepository")
 * @ORM\Table(name="notes")
 */

class Note {

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
     * @ORM\Column(name="message", type="string", length=255)
     * @JMS\Groups({"message", "messages"})
     */
    protected $message;

    /**
     * @ORM\Column(name="isFav", type="boolean")
     * @JMS\Groups({"message", "messages"})
     */
    protected $isFav;

    /**
     *
     * @ORM\Column(type="datetime")
     * @JMS\Groups({"message"})
     * @JMS\Type("DateTime<'d-m-Y'>"))
     */
    private $date_creation;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User", inversedBy="notes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @JMS\Groups({"messages", "message"})
     */
    private $user;


    function __construct()
    {
        $this->date_creation = new \DateTime();
        $this->isFav = false;
    }

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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getIsFav()
    {
        return $this->isFav;
    }

    /**
     * @param mixed $isFav
     */
    public function setIsFav($isFav)
    {
        $this->isFav = $isFav;
    }



    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }




    public function __toString()
    {
        return $this->getMessage();
    }


}