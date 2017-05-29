<?php 
namespace AppBundle\Form;

use AppBundle\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use AppBundle\Entity\Category;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class CategoryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class, array(
				'label' => 'Nom de la catégorie',
			))
			->add('parent', EntityType::class, array(
				'class' => 'AppBundle:Category',
				'query_builder' => function(CategoryRepository $er) 
				{
					return $er->QueryBuilder_findAllWithoutParent();
				},
				'choice_label' => 'name',
				'multiple' => false,
				'required' => false,
			))
			->add('save', SubmitType::class, array(
				'label' => 'Ajouter la catégorie', 
//				'label_attr' => array('class'=>'btn-default btn',)
			))
		;
	}
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class' => Category::class,
			)
		);
	}
}
