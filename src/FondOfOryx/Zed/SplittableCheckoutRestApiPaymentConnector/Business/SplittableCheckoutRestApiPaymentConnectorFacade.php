<?php

namespace FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\SplittableCheckoutRestApiPaymentConnectorBusinessFactory getFactory()
 */
class SplittableCheckoutRestApiPaymentConnectorFacade extends AbstractFacade implements SplittableCheckoutRestApiPaymentConnectorFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(
        RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        return $this->getFactory()
            ->createQuoteExpander()
            ->expand($restSplittableCheckoutRequestTransfer, $quoteTransfer);
    }
}
