<?php 
namespace ImieBook\Entity;

/** 
* @Entity(repositoryClass="ImieBook\Repository\PostLikeRepository")
* @Table(name="post_like")
*/
class PostLike
{
	/**
     * @Id 
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

	/** 
    * @ManyToOne(targetEntity="ImieBook\Entity\Post") 
    * @JoinColumn(name="post_id", referencedColumnName="id")
    */
    private $post;

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

    public function getPost(){
    	return $this->post;
    }

    public function setPost($post){
    	$this->post = $post;
    }

    public function getUser(){
    	return $this->user;
    }

    public function setUser($user){
    	$this->user = $user;
    }

    public function getScore(){
    	return $this->$score;
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