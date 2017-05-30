<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OptionTissuProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('option', EntityType::class, array(
				'class' => 'AppBundle:Options',
				'choice_label' => 'name',
				'multiple' => false,
				'placeholder' => '',
			))
			->add('tissu', EntityType::class, array(
				'class' => 'AppBundle:Tissu',
				'choice_label' => 'name',
				'multiple' => false,
				'placeholder' => '',
			))
			;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\OptionTissuProduit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_optiontissuproduit';
    }


}
