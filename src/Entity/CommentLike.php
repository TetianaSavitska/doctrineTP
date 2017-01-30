<?php 
namespace ImieBook\Entity;

/** 
* @Entity(repositoryClass="ImieBook\Repository\CommentLikeRepository")
* @Table(name="comment_like")
*/
class CommentLike
{
	/**
     * @Id 
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

	/** 
    * @ManyToOne(targetEntity="ImieBook\Entity\Comment")
    * @JoinColumn(name="comment_id", referencedColumnName="id")
    */
    private $comment;

    /** 
    * @ManyToOne(targetEntity="ImieBook\Entity\User") 
    * @JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /** @Column(name="score", type="integer") */
    private $score;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getComment(){
    	return $this->comment;
    }

    public function setComment($comment){
    	$this->comment = $comment;
    }

    public function getUser(){
    	return $this->user;
    }

    public function setUser($user){
    	$this->user = $user;
    }

    public function getScore(){
    	return $this->score;
    }

    public function setScore($score){
    	$this->score = $score;
    }

    public function like(){
    	$this->score = 1;
    }

    public function dislike(){
    	$this->score = -1;
    }

}