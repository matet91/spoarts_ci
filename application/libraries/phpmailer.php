<?php 
 require_once APPPATH."third_party/phpmailer/PHPMailerAutoload.php"; 

class PHPMailer extends PHPMailer{ 
    public function __construct() { 
        parent::__construct(); 
        
    } 
}