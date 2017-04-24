<?php

namespace CGI\GedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblSimulation
 *
 * @ORM\Table(name="tbl_simulation")
 * @ORM\Entity(repositoryClass="CGI\GedBundle\Repository\TblSimulationRepository")
 */
class TblSimulation
{
    /**
     * @var int
     *
     * @ORM\Column(name="simulation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $simulationId;


    /**
     * Get id
     *
     * @return int
     */
    public function getSimulationId()
    {
        return $this->simulationId;
    }


}

