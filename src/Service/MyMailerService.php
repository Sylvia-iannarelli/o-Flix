<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MyMailerService{
    private $mailer;
    private $adminMail;

    public function __construct(MailerInterface $mailer, string $adminMail){
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
    }

    /**
     * method that use the mailerInterface to send an email
     *
     * @param string $subject Title of the mail
     * @param string $template The template
     * @param array $template Variables needed by the template
     */
    public function send(string $subject, string $template, array $context){

        $email = (new TemplatedEmail())
        ->from($this->adminMail)
        ->to($this->adminMail)
        ->subject($subject)
        ->htmlTemplate($template)
        ->context($context);

        $this->mailer->send($email);

    }
}
