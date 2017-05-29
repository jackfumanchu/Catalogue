<?php
// src/AppBundle/Entity/OptionTissu.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class OptionTissu
{
	// Cette entité est "virtuelle" et lie une catégorie avec un tissu, permettant de dire par exemple que la bande du haut est avec le tissu Stars Bleu.
	// Cette entité est utilisée par la classe produit pour gérer les options d'un produit.
	private $id;
    private $option; // Le nom (label) associé à l'option. Par exemple, "Bande du haut" pour un carnet de santé à trois bandes
	private $tissu; //Une catégorie seulement par option => Une catégorie a plusieurs options
	private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set option
     *
     * @param \AppBundle\Entity\Options $option
     *
     * @return OptionTissu
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
     * @return OptionTissu
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

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return OptionTissu
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }
}
