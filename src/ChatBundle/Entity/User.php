<?php

namespace ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
* @ORM\Entity
* @ORM\Table(name="user")
* @UniqueEntity("username")
*/
class User
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
    * @ORM\Column(type="string", length=100, unique=true)
    */
    protected $username;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="recipient")
     */
    protected $received_messages;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->received_messages = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Add received_messages
     *
     * @param \ChatBundle\Entity\Message $receivedMessages
     * @return User
     */
    public function addReceivedMessage(\ChatBundle\Entity\Message $receivedMessages)
    {
        $this->received_messages[] = $receivedMessages;

        return $this;
    }

    /**
     * Remove received_messages
     *
     * @param \ChatBundle\Entity\Message $receivedMessages
     */
    public function removeReceivedMessage(\ChatBundle\Entity\Message $receivedMessages)
    {
        $this->received_messages->removeElement($receivedMessages);
    }

    /**
     * Get received_messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReceivedMessages()
    {
        return $this->received_messages;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->username;
    }
}
