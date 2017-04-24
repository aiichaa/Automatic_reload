<?php

namespace CGI\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentNotification
 *
 * @ORM\Table(name="comment_notification")
 * @ORM\Entity(repositoryClass="CGI\CommentBundle\Repository\CommentNotificationRepository")
 */
class CommentNotification
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="vue", type="boolean")
     */
    private $vue;

    /**
     * NotificationCommentaire constructor.
     * @param bool $vue
     */
    public function __construct()
    {
        $this->vue = false;
    }


    /**
     * @ORM\OneToOne(targetEntity="CGI\CommentBundle\Entity\Comment",cascade={"persist","remove"})
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
     */
    private $comment;

    /**
     * @return boolean
     */
    public function isVue()
    {
        return $this->vue;
    }

    /**
     * @param boolean $vue
     */
    public function setVue($vue)
    {
        $this->vue = $vue;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }


}

