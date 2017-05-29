<?php

namespace AppBundle\Table\Type;

//use JGM\TableBundle\Table\Type\TableTypeInterface;
use JGM\TableBundle\Table\TableBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JGM\TableBundle\Table\Type\AbstractTableType;
use JGM\TableBundle\Table\DataSource\EntityDataSource;
use JGM\TableBundle\Table\Order\Type\OrderTypeInterface;

class TissuTableType extends AbstractTableType implements OrderTypeInterface
{
	public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults(array(
			'attr' => array('width' => '600px', 'class' => 'table'),
			'empty_value' => 'There is no student...'
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
      return new EntityDataSource('AppBundle:Tissu');
    }

	public function buildTable(TableBuilder $builder)
	{
		$builder
			->add('image', 'picturepath', array('label' => 'Image', 'pathToImageWithSlash'=>'img/tissus/', 'width'=>'60px', 'sortable'=>true))
			->add('number', 'id', array('label' => 'Id', 'sortable'=>true, 'decimals' => 0))
			->add('text', 'name', ['label' => 'Name', 'sortable'=>true])
			->add('text', 'description', array('label' => 'Description', 'sortable'=>true))
		;
    }

    public function getName()
    {
        return 'tissu_table';
    }

}
?>