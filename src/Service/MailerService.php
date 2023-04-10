<?php

namespace App\Service;

use App\Entity\Rental;
use App\Repository\RentalReceiptsRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
Class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {}
    public function sendRentalReceiptsEmail(Rental $rental, RentalReceiptsRepository $rentalReceiptsRepository, ): void
    {
        $from= $rental->getUserAgency()->getEmail();// get UserAgency email from rental object
        $rentalReceipts = $rentalReceiptsRepository->findbyRental($rental);
        $to = 'tenant@studi.fr'; 
        $subject = 'Quittance de loyers pour'.$rental->getId();
        
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate('rental/receipts/email.html.twig')
            //pass variables (name => value) to the template 
            ->context([
                'rental_receipts' => $rentalReceipts,
            ]);
        $this->mailer->send($email);

    }
}
