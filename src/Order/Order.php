<?php

namespace Strat\Order;

use Exception;
use Strat\Invoice\InvoiceStrategy;
use Strat\Payments\PaymentStrategy;

class Order
{
	protected $name;
	protected $email;
	protected $address;
	protected $items;
	protected $paymentMethod;
	protected $invoiceGenerator;
    protected $total;


	public function __construct(Customer $customer, ShoppingCart $cart)
	{
		$this->name = $name;
		$this->email = $email;
        $this->address = $address;
		$this->items = $cart->getItems();
		$this->total = $cart->getTotal();

	}

	public function getName()
	{
		return $this->name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getItems()
	{
		return $this->items;
	}

	public function getTotal()
	{
		if ($this->isTaxEnabled) {
			if (empty($this->taxType)) {
				throw new Exception('Invalid Tax Type configuration');
			}

			$this->totalWithTax = $this->taxType->computeTotalWithTax($this->total);
			return $this->totalWithTax;
		}
		return $this->total;
	}

	
	public function setPaymentMethod(PaymentStrategy $method)
	{
		$this->paymentMethod = $method;
	}

	public function pay()
	{
		try {
			if (empty($this->paymentMethod)) {
				throw new Exception('Invalid payment method');
			}
	
			$total = $this->total;
			if ($this->isTaxEnabled) {
				$total = $this->totalWithTax;
			}
			$this->paymentMethod->pay($total);
		} catch (Exception $e) {
			error_log($e->getMessage());
		}
	}

	public function setInvoiceGenerator(InvoiceStrategy $generator)
	{
		$this->invoiceGenerator = $generator;
	}

	public function generateInvoice()
	{
		try {
			if (empty($this->invoiceGenerator)) {
				throw new Exception("Invoice generator is missing");
			}
			$this->invoiceGenerator->generate($this);
		} catch (Exception $e) {
			error_log($e->getMessage());
		}
	}
}