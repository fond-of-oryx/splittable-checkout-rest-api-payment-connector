<?php

namespace FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\Expander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestPaymentTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use Laminas\Stdlib\ArrayObject;

class QuoteExpanderTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restSplittableCheckoutRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestPaymentTransfer[]|\PHPUnit\Framework\MockObject\MockObject[]
     */
    protected $restPaymentTransferMocks;

    /**
     * @var \FondOfOryx\Zed\SplittableCheckoutRestApiPaymentConnector\Business\Expander\QuoteExpander
     */
    protected $quoteExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->restSplittableCheckoutRequestTransferMock = $this->getMockBuilder(RestSplittableCheckoutRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restPaymentTransferMocks = [
            $this->getMockBuilder(RestPaymentTransfer::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        $this->quoteExpander = new QuoteExpander();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $paymentProviderName = 'foo';
        $paymentMethodName = 'bar';

        $this->restSplittableCheckoutRequestTransferMock->expects(static::atLeastOnce())
            ->method('getPayments')
            ->willReturn(new ArrayObject($this->restPaymentTransferMocks));

        $this->restPaymentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getPaymentProviderName')
            ->willReturn($paymentProviderName);

        $this->restPaymentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('getPaymentMethodName')
            ->willReturn($paymentMethodName);

        $this->restPaymentTransferMocks[0]->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('setPayment')
            ->with(
                static::callback(
                    static function (PaymentTransfer $paymentTransfer) use ($paymentProviderName, $paymentMethodName) {
                        return $paymentTransfer->getPaymentProvider() === $paymentProviderName
                            && $paymentTransfer->getPaymentMethod() === $paymentMethodName;
                    }
                )
            )->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteExpander->expand($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock)
        );
    }

    /**
     * @return void
     */
    public function testExpandWithoutRestPayments(): void
    {
        $this->restSplittableCheckoutRequestTransferMock->expects(static::atLeastOnce())
            ->method('getPayments')
            ->willReturn(new ArrayObject());

        $this->quoteTransferMock->expects(static::never())
            ->method('setPayment');

        static::assertEquals(
            $this->quoteTransferMock,
            $this->quoteExpander->expand($this->restSplittableCheckoutRequestTransferMock, $this->quoteTransferMock)
        );
    }
}
