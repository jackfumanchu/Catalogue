<?php
// src/AppBundle/Entity/Product.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Options
{
	private $id;
    private $name; // Le nom (label) associé à l'option. Par exemple, "Bande du haut" pour un carnet de santé à trois bandes
	private $category; //Une catégorie seulement par option => Une catégorie a plusieurs options
//	private $product;
	private $optiontissuproduit;
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
     * Set name
     *
     * @param string $name
     *
     * @return Options
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Options
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
	
	public function __toString()
	{
		return $this->name;
	}

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Options
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

    /**
     * Add optiontissuproduit
     *
     * @param \AppBundle\Entity\OptionTissuProduit $optiontissuproduit
     *
     * @return Options
     */
    public function addOptiontissuproduit(\AppBundle\Entity\OptionTissuProduit $optiontissuproduit)
    {
        $this->optiontissuproduit[] = $optiontissuproduit;

        return $this;
    }

    /**
     * Remove optiontissuproduit
     *
     * @param \AppBundle\Entity\OptionTissuProduit $optiontissuproduit
     */
    public function removeOptiontissuproduit(\AppBundle\Entity\OptionTissuProduit $optiontissuproduit)
    {
        $this->optiontissuproduit->removeElement($optiontissuproduit);
    }

    /**
     * Get optiontissuproduit
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptiontissuproduit()
    {
        return $this->optiontissuproduit;
    }
}
