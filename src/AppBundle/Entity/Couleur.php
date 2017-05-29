<?php
// src/AppBundle/Entity/Couleur.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Couleur
{
	private $id;
    private $name;
    private $htmlvalue;
	private $tissu;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tissu = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Couleur
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set htmlvalue
     *
     * @param string $htmlvalue
     *
     * @return Couleur
     */
    public function setHtmlvalue($htmlvalue)
    {
        $this->htmlvalue = $htmlvalue;

        return $this;
    }

    /**
     * Get htmlvalue
     *
     * @return string
     */
    public function getHtmlvalue()
    {
        return $this->htmlvalue;
    }

    /**
     * Add tissu
     *
     * @param \AppBundle\Entity\Tissu $tissu
     *
     * @return Couleur
     */
    public function addTissu(\AppBundle\Entity\Tissu $tissu)
    {
        $this->tissu[] = $tissu;

        return $this;
    }

    /**
     * Remove tissu
     *
     * @param \AppBundle\Entity\Tissu $tissu
     */
    public function removeTissu(\AppBundle\Entity\Tissu $tissu)
    {
        $this->tissu->removeElement($tissu);
    }

    /**
     * Get tissu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTissu()
    {
        return $this->tissu;
    }
}
