<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Portfolio")
     */
    private $portfolio;

    /**
     * @ORM\Column(type="string")
     */
    public $code;

    public function getId()
    {
        return $this->id;
    }

    public function getPortfolio()
    {
        return $this->portfolio;
    }

    public function setPortfolio(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }
}
