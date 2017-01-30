<?php 
namespace ImieBook\Entity;

/** 
* @Entity(repositoryClass="ImieBook\Repository\UserRepository")
* @Table(name="user")
*/
class User
{
	/**
     * @Id 
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(name="email", type="string", length=200) */
    private $email;

	/** @Column(name="password", type="string", length=255) */
    private $password;

    /** @Column(name="description", type="text") */
    private $description;

    /** @Column(name="firstname", type="string", length=255) */
    private $firstname;

	/** @Column(name="lastname", type="string", length=255) */
    private $lastname;

    /** @Column(name="birth_date", type="date") */
    private $birthDate;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
    }

    public function getLastname(){
        return $this->lastname;
    }

    public function setLastname($lastname){
        $this->lastname = $lastname;
    }

    public function getBirthDate(){
        return $this->birthDate;
    }

    public function setBirthDate($birthDate){
        $this->birthDate = $birthDate;
    }
}