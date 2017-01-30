<?php 

namespace ImieBook\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
	public function findOneByEmail($email)
	{
		return $this
			    ->createQueryBuilder('u')
		        ->where('u.email=:email')
		        ->setParameter('email', "$email")
		        ->getQuery()
		        ->getOneOrNullResult(); //returns one if find and null if not
		        //getSingleResult() if doesn't find returns exception
	}

	public function findFriends($user)
	{
		return $this
			    ->createQueryBuilder('u')
		        ->where('u.myFriends=:friend')
		        ->setParameter('friend', $user)
		        ->getQuery()
		        ->getResult(); 
	}

}
