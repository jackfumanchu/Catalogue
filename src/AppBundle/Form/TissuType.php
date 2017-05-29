<?php 
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Tissu;
use AppBundle\Entity\Couleur;
use AppBundle\Controller\TissusController;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\Mapping as ORM;

class TissuType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//$couleurs = new Couleur();
		$builder
			->add('name', TextType::class, array('label' => 'Nom court'))
			->add('picturepath', FileType::class, array('label' => 'Image'))
			->add('couleur', EntityType::class, array(
				'class' => 'AppBundle:Couleur',
				'choice_label' => 'htmlvalue',
				'multiple' => true,
				'expanded' => true,
			))
			->add('save', SubmitType::class, array('label' => 'Ajouter le tissu'))
			
		;
	}
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class' => Tissu::class,
				'possible_color' => Couleur::class,
			)
		);
	}
}
?>