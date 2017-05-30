<?php 
namespace AppBundle\Form;

use AppBundle\Repository\CategoryRepository;
use AppBundle\Repository\OptionsRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManager;

use AppBundle\Entity\Tissu;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use AppBundle\Entity\Options;

use AppBundle\Controller\TissusController;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;


class ProductType extends AbstractType
{
	// Utilisé pour récupérer l'entityManager qui va bien
	protected $opt;
	private $em;
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$this->em = $options['em'];
		$builder
			->add('name', TextType::class, array(
				'label' => 'Nom court',
			))
//			->add('description', CKEditorType::class, array(
//				'config' => array('toolbar' => 'basic'),
			->add('description', TextareaType::class, array(
				'label' => 'Description',
			))
			->add('picturepath', FileType::class, array(
				'label' => 'Image',
			))
			->add('prixPublic', NumberType::class, array(
				'label' => 'Prix public conseillé',
			))
			->add('prixPro', NumberType::class, array(
				'label' => 'Prix aux professionnels',
			))
			->add('prixMarche', NumberType::class, array(
				'label' => 'Prix pratiqué sur les marchés',
			))
			->add('category', EntityType::class, array(
				'class' => 'AppBundle:Category',
				'query_builder' => function(CategoryRepository $er) 
				{
					return $er->QueryBuilder_findAllWithParent();
				},
				'choice_label' => 'name',
				'multiple' => false,
				'group_by' => function($category)
				{
					return ($category->getParent())?($category->getParent()->getName()):"";
				},
				'placeholder' => '',
			))
			->add('optiontissuproduit', CollectionType::class, array(
				'entry_type'   => OptionTissuProduitType::class,
				'allow_add'    => true,
				'allow_delete' => true,
			))
			->add('save', SubmitType::class, array(
				'label' => 'Ajouter le produit', 
			))
			;
/*			$formModifier = function (FormInterface $form, Category $category = null) {
				$positions = null === $category ? array() : $this->em->getRepository('AppBundle:Category')->getAvailableOptions($category);
				$form->add('option', EntityType::class, array(
					'class'       => 'AppBundle:Options',
					'placeholder' => '',
					'choices'     => $positions,
					'choice_label' => 'name',
				));
			};
			$builder->addEventListener(
				FormEvents::PRE_SET_DATA,
				function (FormEvent $event) use ($formModifier) {
					$data = $event->getData();
					$formModifier($event->getForm(), $data->getCategory());
				}
			);
			$builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $category = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $category);
            }
        );
*/			
	}
	public function __construct(array $options = array())
    {
		$resolver = new OptionsResolver();
        $this->configureOptions($resolver); 
		$this->opt = $resolver->resolve($options);
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class' => Product::class,
				'em' => null,
			)
		);
	}
	

}
