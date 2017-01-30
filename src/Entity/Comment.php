<?php 
namespace ImieBook\Entity;

/** 
* @Entity(repositoryClass="ImieBook\Repository\CommentRepository")
* @Table(name="comment")
*/
class Comment
{
	/**
     * @Id 
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

	/** @Column(name="date", type="datetime") */
    private $date;

    /** @Column(name="message", type="text") */
    private $message;

    /** 
    * @ManyToOne(targetEntity="ImieBook\Entity\User") 
    * @JoinColumn(name="author_id", referencedColumnName="id")
    */
    private $author;

    /** @ManyToOne(targetEntity="ImieBook\Entity\Post", inversedBy="comments") */
    private $post;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function setAuthor($author){
        $this->author = $author;
    }

    public function getPost(){
        return $this->post;
    }

    public function setPost($post){
        $this->post = $post;
    }
}