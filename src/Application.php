<?php

namespace Strat;

use Strat\Cart\Item;
use Strat\Cart\ShoppingCart;
use Strat\Order\Order;
use Strat\Invoice\TextInvoiceStrategy;
use Strat\Invoice\PDFInvoiceStrategy;
use Strat\Payments\CashOnDeliveryStrategy;
use Strat\Payments\CreditCardStrategy;
use Strat\Payments\PaypalPayment;

class Application
{
	public static function run()
	{
		$cart = new ShoppingCart();
		$apple = new Item('APL', 'Apple', 'An apple fruit', 100);
		$orange = new Item('ORN', 'Orange', 'An orange fruit', 200);
		$kiwi = new Item('KIW', 'Kiwi', 'A kiwi fruit', 250);

		$cart->addItem($apple, 5);
		$cart->addItem($orange, 3);
		$cart->addItem($kiwi, 10);

		$cart->displayItems();

		// Generate Invoice
		$order = new Order('John Doe', 'johndoe@mail.com', $cart);

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$textInvoice = new TextInvoiceStrategy();
		$order->setInvoiceGenerator($textInvoice);
		$order->generateInvoice();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$pdfInvoice = new PDFInvoiceStrategy();
		$order->setInvoiceGenerator($textInvoice);
		$order->generateInvoice();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
	

		// Payment
		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$creditCard = new CreditCardStrategy('John Doe', '5432-1234-1231-3234', '331', '12/24');
		$order->setPaymentMethod($creditCard);
		$order->pay();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$paypal = new PaypalStrategy('johndoe@email.com', 'MYSecretPassword$$$');
		$order->setPaymentMethod($paypal);
		$order->pay();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$cod = new CashOnDeliveryStrategy('Jane Doe', '123 My Street, Suburb Town', 'Peaceful City', 777, 'Filipinas');
		$order->setPaymentMethod($cod);
		$order->pay();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$cod = new CashOnDeliveryStrategy('Jimmy Doe', '123 My Street, Suburb Town', 'Peaceful City', 777, 'Filipinas');
		

		$cod = new CashOnDeliveryStrategy('Kirsten Michaels', '456 My AU Street, Suburb Town', 'Peaceful City', 777, 'Straya');
		

		// Show Invoice
		$order->setInvoiceGenerator($textInvoice);
		$order->generateInvoice();

		$order->setPaymentMethod($cod);
		$order->pay();
	}
}