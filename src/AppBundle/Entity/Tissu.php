<?php
// src/AppBundle/Entity/Tissu.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Tissu
{
	private $id;
	private $name;
	private $couleur;
//	private $product;
	/**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Merci d'utiliser un fichier JPG or PNG file.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpg", "image/jpeg", "image/bmp" })
     */
	private $picturepath;
	private $optiontissuproduit;
		
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->couleur = new \Doctrine\Common\Collections\ArrayCollection();
    }

	public function __toString()
	{
		return $this->$name;
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
     * @return Tissu
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
     * Set picturepath
     *
     * @param string $picturepath
     *
     * @return Tissu
     */
    public function setPicturepath($picturepath)
    {
        $this->picturepath = $picturepath;

        return $this;
    }

    /**
     * Get picturepath
     *
     * @return string
     */
    public function getPicturepath()
    {
        return $this->picturepath;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Tissu
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
     * Add couleur
     *
     * @param \AppBundle\Entity\Couleur $couleur
     *
     * @return Tissu
     */
    public function addCouleur(\AppBundle\Entity\Couleur $couleur)
    {
        $this->couleur[] = $couleur;

        return $this;
    }

    /**
     * Remove couleur
     *
     * @param \AppBundle\Entity\Couleur $couleur
     */
    public function removeCouleur(\AppBundle\Entity\Couleur $couleur)
    {
        $this->couleur->removeElement($couleur);
    }

    /**
     * Get couleur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCouleur()
    {
        return $this->couleur;
    }


    /**
     * Add optiontissuproduit
     *
     * @param \AppBundle\Entity\OptionTissuProduit $optiontissuproduit
     *
     * @return Tissu
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
