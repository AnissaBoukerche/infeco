<?php

namespace App\Tests\Unit;

use App\Entity\Payment;
use DateTime;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    public function testIsTrue()
    {
        $payment = new Payment;
        $paymentAt = new DateTime();

        $payment->setPaymentAt($paymentAt)
        ->setAmount(550.1)
        ->setType('APL')
        ->setPaymentMethod('Virement');
        $this->assertTrue($payment->getPaymentAt() === $paymentAt);
        $this->assertTrue($payment->getAmount() === 550.1);
        $this->assertTrue($payment->getType()=== 'APL');
        $this->assertTrue($payment->getPaymentMethod()=== 'Virement');
    }


public function testIsFalse()
{
    $payment = new Payment;
    $paymentAt = new DateTime();

    $payment->setPaymentAt($paymentAt)
        ->setAmount(550)
        ->setType('APL')
        ->setPaymentMethod('Virement');
    $this->assertFalse($payment->getPaymentAt() === new DateTime());
    $this->assertFalse($payment->getAmount() === '650');
    $this->assertFalse($payment->getType()=== 'false');
    $this->assertFalse($payment->getPaymentMethod()=== 'false');
}

public function testIsEmpty()
{
    $payment = new Payment;

    $this->assertEmpty($payment->getPaymentAt());
    $this->assertEmpty($payment->getAmount());
    $this->assertEmpty($payment->getType());
    $this->assertEmpty($payment->getPaymentMethod());
}
}
