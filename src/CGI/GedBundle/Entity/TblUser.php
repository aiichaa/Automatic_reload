<?php

namespace CGI\GedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * TblUser
 *
 * @ORM\Table(name="tbl_user")
 * @ORM\Entity(repositoryClass="CGI\GedBundle\Repository\TblUserRepository")
 */
class TblUser implements UserInterface, \Serializable

{

    /**
     * @var string
     *
     * @ORM\Column(name="user_nom", type="string", length=50, nullable=false)
     */
    private $userNom;

    /**
     * @var string
     *
     * @ORM\Column(name="user_prenom", type="string", length=50, nullable=true)
     */
    private $userPrenom;

    /**
     * @var string
     *
     * @ORM\Column(name="user_login", type="string", length=50, nullable=false)
     */
    private $userLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pw", type="string", length=50, nullable=false)
     */
    private $userPw;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="CGI\GedBundle\Entity\RefProfil", inversedBy="user")
     * @ORM\JoinTable(name="lnk_user_profil",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="profil_id", referencedColumnName="profil_id")
     *   }
     * )
     */
    private $profil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profil = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getUserNom()
    {
        return $this->userNom;
    }

    /**
     * @param string $userNom
     */
    public function setUserNom($userNom)
    {
        $this->userNom = $userNom;
    }

    /**
     * @return string
     */
    public function getUserPrenom()
    {
        return $this->userPrenom;
    }

    /**
     * @param string $userPrenom
     */
    public function setUserPrenom($userPrenom)
    {
        $this->userPrenom = $userPrenom;
    }

    /**
     * @return string
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * @param string $userLogin
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;
    }

    /**
     * @return string
     */
    public function getUserPw()
    {
        return $this->userPw;
    }

    /**
     * @param string $userPw
     */
    public function setUserPw($userPw)
    {
        $this->userPw = $userPw;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $profil
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;
    }


    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->userId,
            $this->userLogin,
            $this->userPw,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->userId,
            $this->userLogin,
            $this->userPw,
            ) = unserialize($serialized);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->profil->toArray();
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->userPw;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->userLogin;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    function __toString()
    {
        return $this->getUserNom()." ".$this->getUserPrenom();
    }
}
