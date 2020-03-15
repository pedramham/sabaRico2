<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="ایمیل قبلا استفاده شده است توسط کاربر دیگر")
 * @UniqueEntity(fields="username", message="نام کاربری قبلا استفاده شده است توسط کاربر دیگر")
 */
class User implements UserInterface , \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     * @Assert\Length(
     *      min = 2,
     *      max = 60,
     *      minMessage = "نام کاربر کمتر از ۲ کارکتر است این مقدار قابل قبول نیست",
     *      maxMessage = "شما نمی توانید بیشتر از 60 کارکتر برای نام کاربر استفاده کنید"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="family", type="string", length=60)
     * @Assert\NotBlank(message ="لطفا نام کاربر را وارد کنید")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "نام انتخابی کمتر از ۳ کارکتر است ",
     *      maxMessage = "نام انتخابی بیشتر از 60 کاراکتر است"
     * )

     */
    private $family;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,unique=true)
     * @Assert\NotBlank(message ="برا ثبت نام کاربری وارد کردن ایمیل ضروری است")
     * @Assert\Email(message ="ایمیل شما معتبر نیست")
     * @Assert\Length(
     *      min = 5,
     *      max = 60,
     *      minMessage = "ایمیل کمتر از ۵ کارکتر قابل قبول نیست",
     *      maxMessage = "ایمیل شما بیشتر از 60 کاراکتر است "
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50)
     * @Assert\NotBlank(message = "")
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "نام کاربری باید بیشتر از ۵ کراکتر باشد",
     *      maxMessage = "نام کاربری نباید بیشتر از 50 کارکتر باشد"
     * )
     */
    private $username;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */

    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "پسورد انتخابی نباید کمتر از 5 کاراکتر باشد",
     *      maxMessage = "پسورد انتخابی نباید بیشتر از 60 کراکتر باشد"
     * )
     */
    private $password;
    /**
     * @ORM\Column(type="array")
     */
    private $roles ;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "آدرس نباید کمتر از 5 کارکتر باشد",
     *      maxMessage = "ادرس نباید بیشتر از 255 کارکتر باشد"
     * )
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="telephon", type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "شماره تلفن نباید کمتر از 4 رقم باشد",
     *      maxMessage = "شماره تلفن نباید بیشتر از 50 کارکتر باشد"
     * )
     */
    private $telephon;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "شماره موبایل نباید کمتر از 6 رقم باشد",
     *      maxMessage = "شماره موباید بیشتر از 30 کارکتر است "
     * )
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="picUser", type="string", length=255)
     */
    private $picUser;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="text")
     */
    private $subject;
    /**
     * Get id
     *
     * @return int
     */
    public function __construct() {
        //  $this->roles = array('ROLE_USER');
    }
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set family
     *
     * @param string $family
     *
     * @return User
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family
     *
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }
    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }
    public function getRoles()
    {
        //  $roles = $this->roles;
//        $roles = $this->roles;
//        var_dump($roles);
//        if ($roles != NULL) {
//            return explode(" ",$roles);
//        }else {
//            return $this->roles;
//        }
        //  return $this->roles->toArray();
        return array('ROLE_ADMIN');
      //  return $this->roles;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;

    }
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set telephon
     *
     * @param string $telephon
     *
     * @return User
     */
    public function setTelephon($telephon)
    {
        $this->telephon = $telephon;

        return $this;
    }

    /**
     * Get telephon
     *
     * @return string
     */
    public function getTelephon()
    {
        return $this->telephon;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set picUser
     *
     * @param string $picUser
     *
     * @return User
     */
    public function setPicUser($picUser)
    {
        $this->picUser = $picUser;

        return $this;
    }

    /**
     * Get picUser
     *
     * @return string
     */
    public function getPicUser()
    {
        return $this->picUser;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return User
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

}
