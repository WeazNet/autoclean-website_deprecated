<?php 
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     *  pattern="/[0-9]{10}/"
     * )
     */
    private $tel;

    /**
     * @var string|null
     * @Assert\Length(min=3, minMessage = "Votre objet est trop court")
     */
    private $subject;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     *  min=15,
     *  minMessage = "Votre message est trop court"
     * )
     */
    private $message;

    /**
     * @return  string|null
     */ 
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param  string|null  $email
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return  string|null
     */ 
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @param  string|null  $tel  pattern="/[0-9]{10}/"
     * @return  self
     */ 
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return  string|null
     */ 
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param  string|null  $subject
     * @return  self
     */ 
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return  string|null
     */ 
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param  string|null  $message  min=15,
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

}