<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Jan Mühlig <mail@janmuehlig.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Controller;

use JGM\TableBundle\Table\Table;
use JGM\TableBundle\Table\TableTypeBuilder;
use JGM\TableBundle\Table\Type\AbstractTableType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;

/**
 * Extending the Symfony Controller with methods
 * for creating tables.
 *
 * @author	Jan Mühlig <mail@janmuehlig.de>
 * @since	1.0
 */
class Controller extends SymfonyController
{
	/**
	 * Builds a table by a table type.
	 * 
	 * @param AbstractTableType $tableType	TableType.
	 * @return	Table
	 */
	protected function createTable(AbstractTableType $tableType, array $options = array())
	{
		return $this->get('jgm.table_factory')->createTable($tableType, $options);
	}
	
	/**
	 * Creats a table type builder, which is used to create
	 * tables without implementing a table type.
	 * 
	 * @since	1.2
	 * 
	 * @param string $name	Name of the table.
	 * @param array $options	Options of the table.
	 * 
	 * @return TableTypeBuilder
	 */
	protected function createTableTypeBuilder($name, array $options = array())
	{
		return $this->get('jgm.table_factory')->createTableTypeBuilder($name, $options);
	}
}
