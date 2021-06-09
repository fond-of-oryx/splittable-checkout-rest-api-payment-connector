<?php

namespace FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business;

use Codeception\Test\Unit;
use FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\Expander\QuoteExpander;

class SplittableCheckoutRestApiPaymentConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\SplittableCheckoutRestApiPaymentConnectorBusinessFactory
     */
    protected $businessFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->businessFactory = new SplittableCheckoutRestApiPaymentConnectorBusinessFactory();
    }

    /**
     * @return void
     */
    public function testCreateQuoteExpander(): void
    {
        static::assertInstanceOf(
            QuoteExpander::class,
            $this->businessFactory->createQuoteExpander()
        );
    }
}
