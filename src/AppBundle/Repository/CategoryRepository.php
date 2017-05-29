<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
	public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Category p ORDER BY p.name ASC'
            )
            ->getResult();
    }
	
	public function Result_getNumberOfChild(Category $parent)
	{
		return $this->getEntityManager()
			->createQuery(
				'SELECT COUNT(c) FROM AppBundle:Category c WHERE c.parent = :numparent'
			)
			->setParameter('numparent', $parent.id)
			->getSingleScalarResult();
	}
	
	public function getAvailableOptions(Category $cat)
	{
		return $this->getEntityManager()
			->createQuery(
				'SELECT o FROM AppBundle:Options o WHERE o.category = :cate'
			)
			->setParameter('cate', $cat->getId())
			->getResult();
	}
	public function getAvailableOptionsFromId($cat)
	{
		return $this->getEntityManager()
			->createQuery(
				'SELECT o FROM AppBundle:Options o WHERE o.category = :cate'
			)
			->setParameter('cate', $cat)
			->getResult();
	}
	
	public function QueryBuilder_findAllWithParent()
	{
		return $this->createQueryBuilder('c')
			->where('c.parent IS NOT NULL');
	}
	public function QueryBuilder_findAllWithoutParent()
	{
		return $this->createQueryBuilder('c')
			->where('c.parent IS NULL');
	}
}