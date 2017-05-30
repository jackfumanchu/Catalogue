<?php 
namespace AppBundle\Form;

use AppBundle\Repository\CategoryRepository;
use AppBundle\Form\OptionsType;
use AppBundle\Entity\Category;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
			->add('options', CollectionType::class, array(
				'entry_type'   => OptionsType::class,
				'allow_add'    => true,
				'allow_delete' => true,
			))
			->add('save', SubmitType::class, array(
				'label' => 'Ajouter la catégorie', 
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
