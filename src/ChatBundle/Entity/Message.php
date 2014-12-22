<?php

namespace ChatBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use ChatBundle\Entity\User;


/**
 * @ORM\Entity(repositoryClass="ChatBundle\Entity\MessageRepository")
 * @ORM\Table(name="message")
 */
class Message
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Serializer\Groups({"received"})
     */
    private $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     * @Serializer\Type("ChatBundle\Entity\User")
     */
    private $author;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="received_messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    /**
     * @var \datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Serializer\Groups({"received"})
     */
    private $created;

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
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set author
     *
     * @param \ChatBundle\Entity\User $author
     * @return Message
     */
    public function setAuthor(\ChatBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \ChatBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set recipient
     *
     * @param \ChatBundle\Entity\User $recipient
     * @return Message
     */
    public function setRecipient(\ChatBundle\Entity\User $recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return \ChatBundle\Entity\User
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Message
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("author")
     * @Serializer\Type("string")
     * @Serializer\Groups({"received"})
     */
    public function author_username()
    {
        return $this->author->__toString();
    }
}
