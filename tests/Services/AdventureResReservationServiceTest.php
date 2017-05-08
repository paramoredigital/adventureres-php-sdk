<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Tests;

use AdventureRes\Exceptions\AdventureResModelException;
use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Models\Input\ItineraryInputModel;
use AdventureRes\Models\Input\PaymentInputModel;
use AdventureRes\Models\Input\PromoCodeInputModel;
use AdventureRes\Models\Output\CostSummaryModel;
use AdventureRes\Models\Output\FeeModel;
use AdventureRes\Models\Output\PaymentDueModel;
use AdventureRes\Models\Output\ReservationModel;
use AdventureRes\Services\AdventureResReservationService;
use AdventureRes\Tests\HttpClients\AbstractHttpClientTest;
use Mockery as m;
use AdventureRes\HttpClients\AdventureResCurlHttpClient;
use AdventureRes\AdventureResApp;

class AdventureResReservationServiceTest extends AbstractHttpClientTest
{
    /**
     * @var \AdventureRes\HttpClients\AdventureResCurl
     */
    protected $curlMock;
    /**
     * @var \AdventureRes\HttpClients\AdventureResCurlHttpClient
     */
    protected $curlClient;
    /**
     * @var \AdventureRes\AdventureResApp
     */
    protected $app;
    /**
     * @var \AdventureRes\Services\AdventureResReservationService
     */
    protected $service;

    public function setUp()
    {
        $this->curlMock   = m::mock('AdventureRes\HttpClients\AdventureResCurl');
        $this->curlClient = new AdventureResCurlHttpClient($this->curlMock);
        $this->app        = new AdventureResApp('http://foo.com', 'myApiKey', 'myUser', 'myPass', 10);
        $this->service    = new AdventureResReservationService($this->app, $this->curlClient, false);

        $this->service->setSessionId('mySessionId');

        parent::setUp();
    }

    public function testGetReservationPolicies()
    {
        $this->setupCurlMock($this->fakeRawBodyReservationPolicies);

        /** @var ItineraryInputModel $inputModel */
        $inputModel = ItineraryInputModel::populateModel(['ReservationId' => 123]);
        $policies   = $this->service->getReservationPolicies($inputModel);

        $this->assertInternalType('array', $policies);
        $this->assertNotEmpty($policies);
        $this->assertInstanceOf('\AdventureRes\Models\Output\ReservationPolicyModel', $policies[0]);
        $this->assertTrue($policies[0]->isValid());
    }

    public function testGetItinerary()
    {
        $this->setupCurlMock($this->fakeRawBodyItineraryDisplay);

        /** @var ItineraryInputModel $inputModel */
        $inputModel = ItineraryInputModel::populateModel(['ReservationId' => 123]);
        $itinerary  = $this->service->getItinerary($inputModel);

        $this->assertInternalType('array', $itinerary);
        $this->assertNotEmpty($itinerary);
        $this->assertInstanceOf('\AdventureRes\Models\Output\ReservationItemModel', $itinerary[0]);
        $this->assertTrue($itinerary[0]->isValid());
    }

    public function testGetCostSummary()
    {
        $this->setupCurlMock($this->fakeRawBodyCostSummary);

        /** @var ItineraryInputModel $inputModel */
        $inputModel = ItineraryInputModel::populateModel(['ReservationId' => 123]);
        /** @var CostSummaryModel $summary */
        $summary = $this->service->getCostSummary($inputModel);

        $this->assertInstanceOf('\AdventureRes\Models\Output\CostSummaryModel', $summary);
        $this->assertTrue($summary->isValid());
    }

    public function testGetPaymentMethods()
    {
        $this->setupCurlMock($this->fakeRawBodyPaymentMethods);

        $paymentMethods = $this->service->getPaymentMethods();

        $this->assertInternalType('array', $paymentMethods);
        $this->assertNotEmpty($paymentMethods);
        $this->assertInstanceOf('\AdventureRes\Models\Output\PaymentMethodModel', $paymentMethods[0]);
        $this->assertTrue($paymentMethods[0]->isValid());
    }

    public function testPaymentAdd()
    {
        $this->setupCurlMock($this->fakeRawBodyPaymentAdd);

        /** @var PaymentInputModel $inputModel */
        $inputModel = PaymentInputModel::populateModel([
          'ReservationId'   => 123,
          'CustomerId'      => 456,
          'PaymentMethodId' => 1,
          'Address'         => '555 Main Street',
          'Address2'        => '',
          'City'            => 'Nashville',
          'State'           => 'TN',
          'Zip'             => 37211,
          'HomePhone'       => '6155551234',
          'WorkPhone'       => '',
          'CellPhone'       => '',
          'Email'           => 'joe@adventureres.com',
          'Organization'    => '',
          'CreditCard'      => 4111111111111111,
          'ExpirationDate'  => '06/19',
          'CID'             => '001',
          'Amount'          => 200.00,
          'PromoCode'       => ''
        ]);

        /** @var ReservationModel $result */
        $result = $this->service->addPayment($inputModel);

        $this->assertInstanceOf('\AdventureRes\Models\Output\ReservationModel', $result);
        $this->assertTrue($result->isValid());
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResSDKException
     */
    public function testPaymentAddWithInvalidInputThrowsException()
    {
        $inputModel = new PaymentInputModel();
        $this->service->addPayment($inputModel);
    }

    public function testGetPaymentDue()
    {
        $this->setupCurlMock($this->fakeRawBodyPaymentDue);

        /** @var ItineraryInputModel $inputModel */
        $inputModel = ItineraryInputModel::populateModel(['ReservationId' => 123]);
        /** @var PaymentDueModel $paymentDue */
        $paymentDue = $this->service->getPaymentDue($inputModel);

        $this->assertInstanceOf('\AdventureRes\Models\Output\PaymentDueModel', $paymentDue);
        $this->assertTrue($paymentDue->isValid());
    }

    public function testAddPromoCode()
    {
        $this->setupCurlMock($this->fakeRawBodyPromoCodeAdd);

        /** @var PromoCodeInputModel $inputModel */
        $inputModel = PromoCodeInputModel::populateModel([
          'ReservationId' => 123,
          'PromoCode'     => 'foobar'
        ]);

        $result = $this->service->addPromoCode($inputModel);

        $this->assertInstanceOf('\AdventureRes\Models\Output\ReservationModel', $result);
        $this->assertTrue($result->isValid());
    }

    public function testGetConfirmationMessage()
    {
        $this->setupCurlMock($this->fakeRawBodyConfirmationMessage);

        /** @var ItineraryInputModel $inputModel */
        $inputModel   = ItineraryInputModel::populateModel(['ReservationId' => 123]);
        $confirmation = $this->service->getConfirmationMessage($inputModel);

        $this->assertInstanceOf('\AdventureRes\Models\Output\ReservationConfirmationModel', $confirmation);
        $this->assertTrue($confirmation->isValid());
    }

    public function testSaveReservationAsQuote()
    {
        $this->setupCurlMock($this->fakeRawBodySaveAsQuote);

        $result = $this->service->saveReservationAsQuote();

        $this->assertInstanceOf(ReservationModel::class, $result);
        $this->assertTrue($result->isValid());
    }

    public function testListFees()
    {
        $this->setupCurlMock($this->fakeRawBodyListFees);

        $fees = $this->service->listFees();

        $this->assertInternalType('array', $fees);
        $this->assertNotEmpty($fees);
        $this->assertInstanceOf(FeeModel::class, $fees[0]);
        $this->assertTrue($fees[0]->isValid());
    }

    private function setupCurlMock($body)
    {
        $this->curlMock
          ->shouldReceive('init')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('setoptArray')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('exec')
          ->once()
          ->andReturn($this->fakeRawHeader . $body);
        $this->curlMock
          ->shouldReceive('errno')
          ->once()
          ->andReturn(null);
        $this->curlMock
          ->shouldReceive('getinfo')
          ->with(CURLINFO_HEADER_SIZE)
          ->once()
          ->andReturn(mb_strlen($this->fakeRawHeader));
        $this->curlMock
          ->shouldReceive('getinfo')
          ->with(CURLINFO_HTTP_CODE)
          ->once()
          ->andReturn(200);
        $this->curlMock
          ->shouldReceive('version')
          ->once()
          ->andReturn(['version_number' => self::CURL_VERSION_STABLE]);
        $this->curlMock
          ->shouldReceive('close')
          ->once()
          ->andReturn(null);
    }
}
