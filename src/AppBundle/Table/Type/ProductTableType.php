<?php

namespace AppBundle\Table\Type;

//use JGM\TableBundle\Table\Type\TableTypeInterface;
use JGM\TableBundle\Table\TableBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JGM\TableBundle\Table\Type\AbstractTableType;
use JGM\TableBundle\Table\DataSource\EntityDataSource;
use JGM\TableBundle\Table\Order\Type\OrderTypeInterface;

class ProductTableType extends AbstractTableType implements OrderTypeInterface
{
	public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults(array(
			'attr' => array('width' => '100%', 'class' => 'table'),
			'empty_value' => 'There is no student...',
		));
	}
	public function configureOrderOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class_asc' => 'glyphicon glyphicon-arrow-up',
            'class_desc' => 'glyphicon glyphicon-arrow-down',
			'empty_direction' => 'asc',
        ));
    }

	public function getDataSource(ContainerInterface $container)
    {
      return new EntityDataSource('AppBundle:Product');
    }

	public function buildTable(TableBuilder $builder)
	{
		$builder
			->add('text', 'reference', array('label'=>'Référence', 'sortable'=>true))
			->add('text', 'name', array('label' => 'Nom', 'sortable'=>true))
//			->add('text', 'description', array('label' => 'Description', 'sortable'=>true))
			->add('image', 'picturepath', array('label' => 'Image', 'pathToImageWithSlash'=>'img/produits/', 'sortable'=>true))
			->add('text', 'category.name', array('label' => 'Catégorie', 'sortable'=>true))
			->add('number', 'prixPublic', array('label' => 'Prix public', 'sortable'=>true))
			->add('number', 'prixPro', array('label' => 'Prix pro', 'sortable'=>true))
			->add('number', 'prixMarche', array('label' => 'Prix marche', 'sortable'=>true))
			
			;
    }

    public function getName()
    {
        return 'product_table';
    }

}
?>