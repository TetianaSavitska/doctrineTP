<?php 

namespace ImieBook\Repository;

class PostLikeRepository extends \Doctrine\ORM\EntityRepository
{

	public function countPostLikes($post)
	{
		return $this
			    ->createQueryBuilder('pl')
			    ->select('COUNT(pl.score)')
			    //->from('comment', 'cl')
		        ->where('pl.post = :post')
		        ->andWhere('pl.score = 1')
		        ->setParameter('post', $post)
		        ->getQuery()
		        ->getSingleScalarResult();
	}

	public function countPostDislikes($post)
	{
		return $this
			    ->createQueryBuilder('pl')
			    ->select('COUNT(pl.score)')
			    //->from('comment', 'cl')
		        ->where('pl.post = :post')
		        ->andWhere('pl.score = -1')
		        ->setParameter('post', $post)
		        ->getQuery()
		        ->getSingleScalarResult();
	}

}

?>