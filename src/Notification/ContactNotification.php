<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(\Swift_Mailer $mailer, Environment $environment)
    {

        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Sujet :' .$contact->getSubject()))
            ->setFrom('info@marabout-chiva.com')
            ->setTo('info@marabout-chiva.com')
            ->setReplyTo($contact->getEmail())
            ->setBody(
                $this->environment->render('emails/mail.html.twig',[
                    'contact' => $contact,
                    'name' => $contact,
                ]), 'text/html'
            );

        $this->mailer->send($message);
    }

}