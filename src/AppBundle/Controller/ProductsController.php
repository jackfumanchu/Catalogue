<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use AppBundle\Entity\Couleur;
use AppBundle\Entity\Tissu;
use AppBundle\Entity\Options;
use AppBundle\Form\ProductType;
use AppBundle\Table\Type\TissuTableType;
use AppBundle\Table\Type\ProductTableType;

class ProductsController extends Controller
{
	/**
	 * @Route("voirProduits")
	 */
	public function testProduits()
	{
		$table = $this->get('jgm.table')->createTable(new ProductTableType());
		return $this->render('default/visibiliteproduits_2.php.twig', array('productTable' => $table->createView()));
	}
    /**
     * @Route("creerProduit", name="creerProduit")
     */
    public function createProduit(Request $request)
    {
		$session = new Session();
		$session->getId();

		$produit = new Product();
		$em = $this->getDoctrine()->getManager();
		$er = $em->getRepository('AppBundle:Category');

		$form = $this->createForm(ProductType::class, $produit, ['em' => $em]);
		$form->handleRequest($request);
		// display warnings
		$session->getFlashBag()->clear();
		if ($form->isSubmitted() && $form->isValid()) {
			$produit = $form->getData();
			$optiontissuproduit = $produit->getOptionTissuProduit();
			dump($optiontissuproduit);
			$file = $produit->getPicturepath();
			if ($file)
			{
				$fileName = md5(uniqid()).'.'.$file->guessExtension();
				// Move the file to the directory where brochures are stored
				$file->move(
					$this->getParameter('img_produits_directory'),
					$fileName
				);
				$produit->setReference($this->calculateReference($produit));
				$produit->setPicturepath($fileName);
				foreach ($optiontissuproduit as $otp)
				{
					$otp->setProduit($produit);
					$em->persist($otp);
				}
				
				$em->persist($produit);
//				$em->persist($tissu);
//				$em->persist($option)
//				$em->persist($optiontissuproduit);
				$em->flush();
				$session->getFlashBag()->add('success','Le produit de référence '.$produit->getReference().' et ayant pour Id '.$produit->getId().' a bien été ajouté !');
				return $this->redirectToRoute('index');
			} 
			else
			{
				$session->getFlashBag()->add('error','Une erreur sur le fichier est parvenue <br/>Veuillez réessayer.');
			}
		}
		elseif ($form->isSubmitted() && !$form->isValid())
		{
			$session->getFlashBag()->add('error','Aucun produit n\'a été ajouté');
			return $this->redirectToRoute('index');
		}
		return $this->render('form/ajoutProduct.html.twig', array('form' => $form->createView(),));
    }

	/**
	* @Route("creationProduitsReussie", name="creationProduitReussie")
	*/
	public function voirReussite()
	{
		return $this->render('base.html.twig');
	}
	
	/**
	* @Route("/jsonGetOptions")
	*/
	public function jsonGetOptions(Request $request)
	{
		$catid = $request->query->get('product')['category'];
		dump($request);
		dump($catid);
		$em = $this->getDoctrine()->getManager();
		$er = $em->getRepository('AppBundle:Category');
		$options = new Options();
		$options = $er->getAvailableOptionsFromId($catid);
		
		$i = 0;
		$message = "<html><body><div id=\"product_option\">";
		$tissus = $this->getDoctrine()->getRepository('AppBundle:Tissu')->findAll();
		foreach ($options as $plop)
		{
			$message = $message . "<div class=\"form-group\">
				<label class=\"col-sm-2 control-label required\" for=\"product_optiontissuproduit_tissu_".$i."\">".$plop->getName()."</label>
				<input class=\"hidden\" type=\"textarea\" value=\"".$plop->getId()."\" name=\"product[optiontissuproduit][".$i."][option]\" id=\"product_optiontissuproduit_tissu_".$i."\"></input>
				<div class=\"col-sm-10\">";
				//Ici, la boucle avec les tissus.
				$j = 0;
				foreach ($tissus as $tissu)
				{
					$message = $message . "<input type=\"radio\" name=\"product[optiontissuproduit][".$i."][tissu]\" value=\"".$tissu->getId()."\" id=\"optiontissuproduit_option_".$i."_".$tissu->getId()."\"><label for=\"optiontissuproduit_option_".$i."_".$tissu->getId()."\" width=\"50px\" height=\"50px\"><span></span><img src=\"img/tissus/".$tissu->getPicturepath()."\" width=\"50px\" height=\"50px\"></label></input>";
					$j = $j + 1;
				}
			$message = $message . "</div></div>";
			$i = $i + 1;
		}
		
		$message = $message."</div></body></html>";
		
		dump($message);
		return Response::create($message, 200);
	}
	
	/**
     * Calculate reference
     *
	 * Reference is calculated as follow : 
	 *	- Category Id on two digits
	 *	- Subcategory Id on two digits
	 *	- First/Second/Third Tissu on two digits
	 *	- Version on one digit (start with 0)
     * @param string $reference
     *
     * @return Reference
     */
	 private function calculateReference(Product $product)
	 {
		$reference = "";
		if (!$product->getCategory())
		{
			throw new HttpException(400, "La catégorie n'est pas bonne.");
		}
		
		// On crée un EntityManager pour accéder aux données dans la base
		$em = $this->getDoctrine()->getManager();
		
		// On récupère la valeur de l'Id de la catégorie parent pour générer le modèle de calcul de la référence
		$parent_category_id = $product->getCategory()->getParent()->getId();
		// On récupère la valeur du numéro dans la catégorie pour l'inscrire en deuxième position
		$category_number = $product->getCategory()->getNumberSubCategory();
		
		// on récupère les ID des différentes catégories mères
		$catmereid = $em
			->createQuery(
				'SELECT c.id FROM AppBundle:Category c WHERE 
				(c.name = :doudouname) OR (c.name = :mobilename) OR (c.name = :santename)'
			)
			->setParameter('doudouname', "Doudou")
			->setParameter('mobilename', "Mobile")
			->setParameter('santename', "Carnet de santé")
			->getScalarResult();
		$doudou_id = $em
			->createQuery(
				'SELECT c.id FROM AppBundle:Category c WHERE 
				(c.name = :doudouname)'
			)
			->setParameter('doudouname', "Doudou")
			->getSingleScalarResult();
		$mobile_id = $em
			->createQuery(
				'SELECT c.id FROM AppBundle:Category c WHERE 
				(c.name = :mobilename)'
			)
			->setParameter('mobilename', "Mobile")
			->getSingleScalarResult();
		$sante_id = $em
			->createQuery(
				'SELECT c.id FROM AppBundle:Category c WHERE 
				(c.name = :santename)'
			)
			->setParameter('santename', "Carnet de santé")
			->getSingleScalarResult();
		
		// En fonction de la catégorie parent, on récupère la façon de générer le code
		$reference = sprintf("%'.02d%'.02d", $parent_category_id, $category_number);
		switch ($parent_category_id)
		{
			case $doudou_id: // Doudou
				break;
			case $mobile_id: // 
				break;
			case $sante_id:
				foreach ($product->getOptionTissuProduit() as $otp)
				{
					$reference = sprintf("%s%'.02d%'.02d", $reference, $otp->getOption()->getId(), $otp->getTissu()->getId());
				}
				break;
		}
		
//		$reference = sprintf("%'.02d%'.02d%'.02d", $this->category->getParent()->getId(), $this->getcategory->getId(), $this->tissu[0]->getId());
		
		return $reference;
	 }
 
}
