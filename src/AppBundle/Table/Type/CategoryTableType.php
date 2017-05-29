<?php

namespace AppBundle\Table\Type;

use JGM\TableBundle\Table\TableBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JGM\TableBundle\Table\Type\AbstractTableType;
use JGM\TableBundle\Table\DataSource\EntityDataSource;
use JGM\TableBundle\Table\Order\Type\OrderTypeInterface;

class CategoryTableType extends AbstractTableType implements OrderTypeInterface
{
	public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults(array(
			'attr' => array('width' => '100%', 'class' => 'table'),
			'empty_value' => 'Il n\'y a pas de catégorie pour le moment...',
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
      return new EntityDataSource('AppBundle:Category');
    }

	public function buildTable(TableBuilder $builder)
	{
		$builder
			->add('number', 'id', array('label' => 'Id', 'sortable'=>true, 'decimals' => 0))
			->add('text', 'name', array('label' => 'Nom', 'sortable'=>true))
			->add('text', 'parent.name', array('label'=>'Catégorie parente', 'sortable'=>true, ))
			->add('number', 'numberSubCategory', array('label' => 'Numéro dans la catégorie', 'sortable'=>true, 'decimals' => 0))
			;
    }

    public function getName()
    {
        return 'category_table';
    }

}
?>