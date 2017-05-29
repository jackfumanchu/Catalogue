<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Jan Mühlig <mail@janmuehlig.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Table\AccessValidation;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Access validation, which can execute an anonymous 
 * function get the users access.
 * 
 * @author	Jan Mühlig <mail@janmuehlig.de>
 * @since	1.3
 */
class CallableAccessValidator implements AccessValidatorInterface
{
	/**
	 * @var callable
	 */
	private $callable;
	
	public function __construct($callable)
	{
		$this->callable = $callable;
	}
	
	public function isAccessGranted(AuthorizationCheckerInterface $checker)
	{
		if(is_callable($this->callable))
		{
			return call_user_func($this->callable, $checker);
		}
		
		return false;
	}
}
