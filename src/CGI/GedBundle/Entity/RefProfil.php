<?php

namespace CGI\GedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * RefProfil
 *
 * @ORM\Table(name="ref_profil")
 * @ORM\Entity(repositoryClass="CGI\GedBundle\Repository\RefProfilRepository")
 */
class RefProfil implements RoleInterface

{
    /**
     * @var string
     *
     * @ORM\Column(name="profil_lib", type="string", length=50, nullable=false)
     */
    private $profilLib;



    /**
     * @var string
     *
     * @ORM\Column(name="profil_lib_court", type="string", length=128, nullable=false)
     */
    private $profilLibCourt;

    /**
     * @var integer
     *
     * @ORM\Column(name="profil_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $profilId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="CGI\GedBundle\Entity\TblUser", mappedBy="profil")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
        return $this->getProfilLibCourt();
    }


    /**
     * Set profilLib
     *
     * @param string $profilLib
     *
     * @return RefProfil
     */
    public function setProfilLib($profilLib)
    {
        $this->profilLib = $profilLib;

        return $this;
    }

    /**
     * Get profilLib
     *
     * @return string
     */
    public function getProfilLib()
    {
        return $this->profilLib;
    }


    /**
     * Set profilLibCourt
     *
     * @param string $profilLibCourt
     *
     * @return RefProfil
     */
    public function setProfilLibCourt($profilLibCourt)
    {
        $this->profilLibCourt = $profilLibCourt;

        return $this;
    }

    /**
     * Get profilLibCourt
     *
     * @return string
     */
    public function getProfilLibCourt()
    {
        return $this->profilLibCourt;
    }

    /**
     * Get profilId
     *
     * @return integer
     */
    public function getProfilId()
    {
        return $this->profilId;
    }

    /**
     * Add user
     *
     * @param \CGI\GedBundle\Entity\TblUser $user
     *
     * @return RefProfil
     */
    public function addUser(\CGI\GedBundle\Entity\TblUser $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \CGI\GedBundle\Entity\TblUser $user
     */
    public function removeUser(\CGI\GedBundle\Entity\TblUser $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return $this->getProfilLibCourt();
    }
}

