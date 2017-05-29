<?php

namespace AppBundle\Table\Column;

use JGM\TableBundle\Table\Row\Row;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JGM\TableBundle\Table\Column\AbstractColumn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImageColumn extends AbstractColumn
{
    public function configureOptions(OptionsResolver $optionsResolver)
    {
        parent::configureOptions($optionsResolver);

        // Add a new option named 'alt_image' to the existing options 'label', 'attr', etc
        $optionsResolver->setDefaults(array(
			'pathToImageWithSlash' => 'img/',
            'alt_image' => 'img/tissus/not_found.png',
            'alt_text' => 'Image not found',
			'width' => '60px',
        ));
    }

    public function getContent(Row $row)
    {
        $value = $this->getValue($row); // Returns the value of the property with the same name as the column at this row.
        if($value === null || (is_string($value) && strlen($value) === 0))
        {
            $value = $this->options['alt_image']; // Get the value of the option 'alt_image', whose default is 'not_found.png'
        }
		$lien = $this->options['pathToImageWithSlash'].$value;
		$pouet = '<img src="'.$lien.'" alt="'.$this->options['alt_text'].'" width="'.$this->options['width'].'"/>';
        // Build the content of the column.
        return $pouet;
	}
}
?>