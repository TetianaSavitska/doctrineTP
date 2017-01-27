<?php 

namespace ImieBook\Repository;

class PostRepository extends \Doctrine\ORM\EntityRepository
{
	public function findSubjectsByWord($word)
	{
		//$posts = $entityManager->getRepository("ImieBook\Entity\Post")
		return $this
			    ->createQueryBuilder('p')
		        ->where('p.subject LIKE :word')
		        ->orderBy('p.date', 'DESC')
		        ->setParameter('word', "%$word%")
		        ->getQuery()
		        ->getResult();
	}


	//the same function with Dql
	public function searchDql($word)
	{
		return $this
			->_em
			->createQuery('
				SELECT p FROM ImieBook\Entity\Post p 
				WHERE p.subject LIKE :word
				ORDER BY p.date DESC
				')
			->setParameter('word', '%'.$word.'%')
			->getResult;

	}

}