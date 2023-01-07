<?php

namespace Strat\Payments;

interface PaymentStrategy
{
	public function pay($amount);
}