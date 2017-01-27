<?php 
namespace ImieBook\Entity;

/** 
* @Entity 
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
}