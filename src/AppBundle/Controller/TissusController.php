<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tissu;
use AppBundle\Entity\Couleur;
use AppBundle\Form\TissuType;
use AppBundle\Table\Type\TissuTableType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;

class TissusController extends Controller
{
	/**
	 * @Route("testTissus")
	 */
	public function testTissus()
	{
		$table = $this->get('jgm.table')->createTable(new TissuTableType());
		return $this->render('default/visibilitetissus_2.php.twig', array('tissuTable' => $table->createView()));
    }
    /**
     * @Route("creerTissu", name="creerTissu")
     */
    public function createTissus(Request $request)
    {
		$session = new Session();
		$session->getId();
		
		$tissu = new Tissu();

		$form = $this->createForm(TissuType::class, $tissu);
		$form->handleRequest($request);
		// display warnings
		$session->getFlashBag()->clear();
		if ($form->isSubmitted() && $form->isValid()) {
			$tissu = $form->getData();
			
			$file = $tissu->getPicturepath();
			$fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('img_tissus_directory'),
                $fileName
            );
			$tissu->setPicturepath($fileName);
			$em = $this->getDoctrine()->getManager();
			$em->persist($tissu);
			$em->flush();
			$session->getFlashBag()->add('success','Le tissu a bien été ajouté !');
			return $this->redirectToRoute('index');
		}

    return $this->render('form/ajoutTissu.html.twig', array('form' => $form->createView(),));
    }

	/**
	* @Route("creationTissusReussie", name="creationTissuReussie")
	*/
	public function voirReussite()
	{
		return $this->render('base.html.twig');
	}
	
	/**
     * @Route("voirTissus", name="voirTissus")
     */
    public function voirTissus()
    {
		$tissus = $this->getDoctrine()
			->getRepository('AppBundle:Tissu')
			->findAll();

		if (!$tissus) {
			return $this->render('default/visibilitetissus.php.twig', array('no_data' => true));
		}
		
		//$col = new Tissu();
		$couleurs = new \Doctrine\Common\Collections\ArrayCollection();
		$max = 0;
		foreach ($tissus as $col)
		{
			$couleurs[] = $col->getCouleur();
			$max = max($col->getCouleur()->count(), $max);
		}
		$plop = $couleurs->toArray();
		return $this->render('default/visibilitetissus.php.twig', array('no_data' => false,'tissus' => $tissus, 'couleurs' => $plop, 'couleursMax' => $max));
	}
}
?>