<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function numberAction()
    {
		$session = new Session();
		$session->getId();
		$affichage = "";
		foreach ($session->getFlashBag()->get('success', array()) as $message) {
			$affichage = $affichage .'<div class="alert alert-success" role="alert">'.$message.'</div>';
		}
		return $this->render('accueil.html.twig', array('message' => $affichage,));
    }
}
?>