<?php

namespace FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\Expander;

use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(
        RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        $restPaymentTransfers = $restSplittableCheckoutRequestTransfer->getPayments();

        if (!$restPaymentTransfers->count()) {
            return $quoteTransfer;
        }

        $restPaymentTransfer = $restPaymentTransfers->offsetGet(0);

        $paymentTransfer = (new PaymentTransfer())->fromArray($restPaymentTransfer->toArray(), true)
            ->setPaymentProvider($restPaymentTransfer->getPaymentProviderName())
            ->setPaymentMethod($restPaymentTransfer->getPaymentMethodName());

        return $quoteTransfer->setPayment($paymentTransfer);
    }
}
