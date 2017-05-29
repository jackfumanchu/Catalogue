<?php
// src/AppBundle/Entity/Product.php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
	private $id;
    private $name;
    private $description;
	
	/**
     * @ORM\Column(type="string")
     * @Assert\NotNull(message="Merci de remplir ce champ !")
     * @Assert\File(mimeTypes={ "image/png", "image/jpg", "image/jpeg", "image/bmp" })
     */
	private $picturepath;
	private $reference;
	private $category;
	private $prixPublic;
	private $prixPro;
	private $prixMarche;
	private $option;
	private $tissu;
	
	public function __toString()
	{
		return "Mon nom est ".$name;
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
     * @return Product
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set picturepath
     *
     * @param string $picturepath
     *
     * @return Product
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
	
   /**
     * Constructor
     */
    public function __construct()
    {
        $this->tissu = new \Doctrine\Common\Collections\ArrayCollection();
		$this->optiontissu = new \Doctrine\Common\Collections\ArrayCollection();
		
    }

    /**
     * Add tissu
     *
     * @param \AppBundle\Entity\Tissu $tissu
     *
     * @return Product
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

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
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

    /**
     * Set prixPublic
     *
     * @param string $prixPublic
     *
     * @return Product
     */
    public function setPrixPublic($prixPublic)
    {
        $this->prixPublic = $prixPublic;

        return $this;
    }

    /**
     * Get prixPublic
     *
     * @return string
     */
    public function getPrixPublic()
    {
        return $this->prixPublic;
    }

    /**
     * Set prixPro
     *
     * @param string $prixPro
     *
     * @return Product
     */
    public function setPrixPro($prixPro)
    {
        $this->prixPro = $prixPro;

        return $this;
    }

    /**
     * Get prixPro
     *
     * @return string
     */
    public function getPrixPro()
    {
        return $this->prixPro;
    }

    /**
     * Set prixMarche
     *
     * @param string $prixMarche
     *
     * @return Product
     */
    public function setPrixMarche($prixMarche)
    {
        $this->prixMarche = $prixMarche;

        return $this;
    }

    /**
     * Get prixMarche
     *
     * @return string
     */
    public function getPrixMarche()
    {
        return $this->prixMarche;
    }

    /**
     * Add optiontissu
     *
     * @param \AppBundle\Entity\OptionTissu $optiontissu
     *
     * @return Product
     */
    public function addOptiontissu(\AppBundle\Entity\OptionTissu $optiontissu)
    {
        $this->optiontissu[] = $optiontissu;

        return $this;
    }

    /**
     * Remove optiontissu
     *
     * @param \AppBundle\Entity\OptionTissu $optiontissu
     */
    public function removeOptiontissu(\AppBundle\Entity\OptionTissu $optiontissu)
    {
        $this->optiontissu->removeElement($optiontissu);
    }

    /**
     * Get optiontissu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptiontissu()
    {
        return $this->optiontissu;
    }

    /**
     * Set option
     *
     * @param string $option
     *
     * @return Product
     */
    public function setOption($option)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return string
     */
    public function getOption()
    {
        return $this->option;
    }
}