<?php

namespace FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business;

use FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\Expander\QuoteExpander;
use FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\Expander\QuoteExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class SplittableCheckoutRestApiPaymentConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\Expander\QuoteExpanderInterface
     */
    public function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander();
    }
}
