<?php
// src/AppBundle/Entity/Product.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class OptionTissuProduit
{
	private $id;
    private $option;
	private $tissu; 
	private $produit;

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
     * Set produit
     *
     * @param \AppBundle\Entity\Product $produit
     *
     * @return OptionTissuProduit
     */
    public function setProduit(\AppBundle\Entity\Product $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set option
     *
     * @param \AppBundle\Entity\Options $option
     *
     * @return OptionTissuProduit
     */
    public function setOption(\AppBundle\Entity\Options $option = null)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return \AppBundle\Entity\Options
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Set tissu
     *
     * @param \AppBundle\Entity\Tissu $tissu
     *
     * @return OptionTissuProduit
     */
    public function setTissu(\AppBundle\Entity\Tissu $tissu = null)
    {
        $this->tissu = $tissu;

        return $this;
    }

    /**
     * Get tissu
     *
     * @return \AppBundle\Entity\Tissu
     */
    public function getTissu()
    {
        return $this->tissu;
    }
}
