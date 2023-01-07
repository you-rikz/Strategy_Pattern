<?php

namespace Strat\Invoice;

use Strat\Order\Order;

interface InvoiceStrategy
{
	public function generate(Order $order);
}