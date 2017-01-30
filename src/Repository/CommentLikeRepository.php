<?php 

namespace ImieBook\Repository;

class CommentLikeRepository extends \Doctrine\ORM\EntityRepository
{
	
	public function findByUserAndComment($user, $comment)
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

	public function countCommentLikes($comment)
	{
		return $this
			    ->createQueryBuilder('cl')
			    ->select('COUNT(cl.score)')
			    //->from('comment', 'cl')
		        ->where('cl.comment = :comment')
		        ->andWhere('cl.score = 1')
		        ->setParameter('comment', $comment)
		        ->getQuery()
		        ->getSingleScalarResult();
	}

	public function countCommentDislikes($comment)
	{
		return $this
			    ->createQueryBuilder('cl')
			    ->select('COUNT(cl.score)')
		        ->where('cl.comment = :comment')
		        ->andWhere('cl.score = -1')
		        ->setParameter('comment', $comment)
		        ->getQuery()
		        ->getSingleScalarResult();
	}

}