<?php

namespace Strat\Payments;

use Strat\Payments\PaymentStrategy;

class CashOnDelivery implements PaymentStrategy
{
	protected $name;
	protected $address;
	protected $email;

	public function __construct($customer)
	{
		$this->name = $name;
		$this->address = $address;
		$this->email = $email;
	
	}

	public function pay($amount)
	{
		echo "Payment for the amount {$amount} would be paid on delivery\n";
		echo "C.O.D. Details\n";
		echo "Payee: {$this->name} \n";
		echo "Address: {$this->address}, {$this->email}\n";
	}
}