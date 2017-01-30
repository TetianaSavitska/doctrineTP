<?php 

namespace ImieBook\Repository;

class CommentRepository extends \Doctrine\ORM\EntityRepository
{
	public function findByPost($post)
	{
		return $this
			    ->createQueryBuilder('c')
		        ->where('c.post = :post')
		        ->orderBy('c.date', 'ASC')
		        ->setParameter('post', $post)
		        ->getQuery()
		        ->getResult();
	}

	public function findByUserAndComment($user, $comment)
	{
		return $this
			    ->createQueryBuilder('cl')
		        ->where('cl.user_id = :user_id')
		        ->andWhere('cl.comment = comment_id')
		        ->setParameter('user_id', $user->getId())
		        ->setParameter('comment_id', $comment->getId())
		        ->getQuery()
		        ->getOneOrNullResult();
	}

}