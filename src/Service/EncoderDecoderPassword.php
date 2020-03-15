<?php
namespace App\Service;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;



class EncoderDecoderPassword implements PasswordEncoderInterface
{
    private $salt;
    public function __construct($salt)
    {
        $this->salt= $salt;
    }
    public function encodePassword($raw, $salt = "tefTdu-*/hxd64$#%")
    {
        return hash('sha256', $salt . $raw); // Custom function for encrypt with sha256
    }
    public function isPasswordValid($encoded,$raw,$salt = "tefTdu-*/hxd64$#%")
    {
        return $encoded === $this->encodePassword($raw,$salt);
    }
    public function makeCrfToken(){
        $salt = "tefTdu-*/hxd64$#%";
        $crfToken = random_int(1, 900)."mortezaShabani".random_int(1, 99);
        return hash('sha256', $salt . $crfToken); // Custom function for encrypt with sha256
    }
}