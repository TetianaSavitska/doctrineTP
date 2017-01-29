<?php 
namespace ImieBook\Entity;

/** 
* @Entity(repositoryClass="ImieBook\Repository\PostRepository")
* @Table(name="post")
*/
class Post
{
	/**
     * @Id 
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(name="subject", type="string", length=255) */
    private $subject;

	/** @Column(name="date", type="datetime") */
    private $date;

    /** @Column(name="message", type="text") */
    private $message;

    /** @ManyToOne(targetEntity="User") */
    private $author;

    ///** @OneToMany(targetEntity="Comment", mappedBy="post") */
    //private $comments;

    /*public function __construct()
    {
        $this->comments = new ArrayCollection();
    }*/

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getSubject(){
        return $this->subject;
    }

    public function setSubject($subject){
        $this->subject = $subject;
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
}
