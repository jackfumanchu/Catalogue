<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use AppBundle\Entity\Couleur;
use AppBundle\Entity\Tissu;
use AppBundle\Form\CategoryType;
use AppBundle\Table\Type\TissuTableType;
use AppBundle\Table\Type\ProductTableType;
use AppBundle\Table\Type\CategoryTableType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\Repository\CategoryRepository;

class CategoryController extends Controller
{
	/**
	 * @Route("testCategories")
	 */
	public function testCategory()
	{
		$numparent = "1";
		$em = $this->getDoctrine()->getEntityManager();
		$parent = $em
			->createQuery(
				'SELECT COUNT(c) FROM AppBundle:Category c WHERE c.parent = :numparent'
			)
			->setParameter('numparent', $numparent)
			->getSingleScalarResult();
//		$truc = $parent[0];
		return $this->render('tests/testNombreCategorie.php.twig', array('name' => $numparent, 'nb' => $parent));
	}
	
	/**
	 * @Route("voirCategories")
	 */
	public function voirCategory()
	{
		$table = $this->get('jgm.table')->createTable(new CategoryTableType());
		return $this->render('default/visibilitecategory.php.twig', array('categoryTable' => $table->createView()));
	}
    /**
     * @Route("creerCategorie", name="creerCategory")
     */
    public function createCategory(Request $request)
    {
		$session = new Session();
		$session->getId();

		$category = new Category();

		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$category = $form->getData();
			
			$em = $this->getDoctrine()->getManager();
			if ($category->getParent())
			{

				$bidule = $this->calculateSubCategoryNumber($category);
				$category->setNumberSubCategory($bidule);
			}
			$em->persist($category);
			$em->flush();
			$session->getFlashBag()->add('success','La catégorie ayant pour Id '.$category->getId().' a bien été ajoutée !');
			return $this->redirectToRoute('index');
		}

    return $this->render('form/ajoutCategory.html.twig', array('form' => $form->createView(),));
    }
	
	private function calculateSubCategoryNumber(Category $category)
	{
		$em = $this->getDoctrine()->getManager();
		$numberSousCategory = $em->createQuery('SELECT c.numberSubCategory FROM AppBundle:Category c WHERE c.parent = :numparent')
					->setParameter('numparent', $category->getParent()->getId())
					->getResult();
		$max = 0;
		foreach ($numberSousCategory as $nb)
		{
			if ($nb['numberSubCategory'])
			{
				if ($nb['numberSubCategory'] > $max)
				{
					$max = $nb['numberSubCategory'];
				}
			}
		}
		return ($max + 1);
	}
	
}