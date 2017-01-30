<?php 

namespace ImieBook\Repository;

class CommentLikeRepository extends \Doctrine\ORM\EntityRepository
{
	
	public function findOneByUserAndComment($user, $comment)
	{
		return $this
			    ->createQueryBuilder('cl')
		        ->where('cl.user = :user')
		        ->andWhere('cl.comment = :comment')
		        ->setParameter('user', $user)
		        ->setParameter('comment', $comment)
		        ->getQuery()
		        ->getOneOrNullResult();
	}

}