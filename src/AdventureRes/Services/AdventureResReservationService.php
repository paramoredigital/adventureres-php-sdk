<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Services;

use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Models\Input\ReservationConfirmationInputModel;
use AdventureRes\Models\Input\ReservationItineraryInputModel;
use AdventureRes\Models\Input\ReservationPaymentAddInputModel;
use AdventureRes\Models\Input\ReservationPromoCodeAddInputModel;
use AdventureRes\Models\Input\ReservationFeesInputModel;
use AdventureRes\Models\Input\ReservationFeeRemoveInputModel;
use AdventureRes\Models\Input\ReservationQuoteInputModel;
use AdventureRes\Models\Output\CostSummaryModel;
use AdventureRes\Models\Output\FeeModel;
use AdventureRes\Models\Output\PaymentDueModel;
use AdventureRes\Models\Output\PaymentMethodModel;
use AdventureRes\Models\Output\ReservationConfirmationModel;
use AdventureRes\Models\Output\ReservationItemModel;
use AdventureRes\Models\Output\ReservationModel;
use AdventureRes\Models\Output\ReservationPolicyModel;
use AdventureRes\PersistentData\AdventureResSessionKeys;

/**
 * Class AdventureResReservationService
 *
 * @package AdventureRes\Services
 */
class AdventureResReservationService extends AbstractAdventureResService
{
    /**
     * {@inheritdoc}
     */
    const API_SERVICE = 'reservation';
    const POLICIES_ENDPOINT = '/Policies';
    const ITINERARY_DISPLAY_ENDPOINT = '/Itinerary';
    const COST_SUMMARY_ENDPOINT = '/CostSummary';
    const PAYMENT_METHODS_ENDPOINT = '/PaymentMethods';
    const PAYMENT_ADD_ENDPOINT = '/Payment';
    const PAYMENT_DUE_ENDPOINT = '/PaymentDue';
    const PROMO_CODE_ENDPOINT = '/PromoCodeAdd';
    const CONFIRMATION_ENDPOINT = '/Confirmation';
    const SAVE_AS_QUOTE_ENDPOINT = '/Quote';
    const LIST_FEES_ENDPOINT = '/FeesList';
    const REMOVE_FEES_ENDPOINT = '/FeesRemove';

    /**
     * Gets applicable policies for a reservations.
     *
     * @param ReservationItineraryInputModel $input
     * @return array [\AdventureRes\Models\Output\ReservationPolicyModel]
     * @throws AdventureResSDKException
     */
    public function getReservationPolicies(ReservationItineraryInputModel $input)
    {
        if (!$input->isValid()) {
            throw new AdventureResSDKException($input->getErrorsAsString());
        }

        $params            = $input->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('GET', self::POLICIES_ENDPOINT, $params);
        $policies          = $response->getDecodedBody();
        $models            = [];

        foreach ($policies as $policy) {
            $models[] = ReservationPolicyModel::populateModel((array)$policy);
        }

        return $models;
    }

    /**
     * Gets the items stored in the user's itinerary.
     *
     * @param ReservationItineraryInputModel $inputModel
     * @return array [\AdventureRes\Models\Output\ReservationItemModel]
     * @throws AdventureResSDKException
     */
    public function getItinerary(ReservationItineraryInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('GET', self::ITINERARY_DISPLAY_ENDPOINT, $params);
        $itineraryItems    = $response->getDecodedBody();
        $models            = [];

        foreach ($itineraryItems as $item) {
            $models[] = ReservationItemModel::populateModel((array)$item);
        }

        return $models;
    }

    /**
     * Gets the cost summary for an itinerary.
     *
     * @param ReservationItineraryInputModel $inputModel
     * @return \AdventureRes\Models\Output\CostSummaryModel
     * @throws AdventureResSDKException
     */
    public function getCostSummary(ReservationItineraryInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('GET', self::COST_SUMMARY_ENDPOINT, $params);
        $summary           = $response->getDecodedBody();

        return CostSummaryModel::populateModel((array)$summary[0]);
    }

    /**
     * Gets the accepted payment methods for the configured location.
     *
     * @param ServiceClassificationInputModel $inputModel
     * @return array [\AdventureRes\Models\Output\PaymentMethodModel]
     * @throws AdventureResSDKException
     */
    public function getPaymentMethods(ServiceClassificationInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('GET', self::PAYMENT_METHODS_ENDPOINT, $params);
        $result            = $response->getDecodedBody();
        $models            = [];

        foreach ($result as $method) {
            $models[] = PaymentMethodModel::populateModel((array)$method);
        }

        return $models;
    }

    /**
     * Adds a payment to the reservation.
     *
     * @param ReservationPaymentAddInputModel $inputModel
     * @return \AdventureRes\Models\Output\ReservationModel
     * @throws AdventureResSDKException
     */
    public function addPayment(ReservationPaymentAddInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        if(!$params['CustomerId'])
            unset($params['CustomerId']);
        unset($params['Comments']);
        unset($params['PromoCode']);

        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('POST', self::PAYMENT_ADD_ENDPOINT, $params);
        $result            = $response->getDecodedBody();

        return ReservationModel::populateModel((array)$result[0]);
    }

    /**
     * Gets the payment due for a reservation.
     *
     * @param ReservationItineraryInputModel $inputModel
     * @return \AdventureRes\Models\Output\PaymentDueModel
     * @throws AdventureResSDKException
     */
    public function getPaymentDue(ReservationItineraryInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('GET', self::PAYMENT_DUE_ENDPOINT, $params);
        $paymentDue        = $response->getDecodedBody();

        return PaymentDueModel::populateModel((array)$paymentDue[0]);
    }

    /**
     * Adds a promo code to a reservation.
     *
     * @param ReservationPromoCodeAddInputModel $inputModel
     * @return \AdventureRes\Models\AbstractAdventureResModel
     * @throws AdventureResSDKException
     */
    public function addPromoCode(ReservationPromoCodeAddInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('POST', self::PROMO_CODE_ENDPOINT, $params);
        $result            = $response->getDecodedBody();

        return ReservationModel::populateModel((array)$result[0]);
    }

    /**
     * Gets the confirmation message for a reservation.
     *
     * @param ReservationConfirmationInputModel $inputModel
     * @return \AdventureRes\Models\AbstractAdventureResModel
     * @throws AdventureResSDKException
     */
    public function getConfirmationMessage(ReservationConfirmationInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params             = $inputModel->getAttributes();
        $params['Location'] = $this->app->getLocation();
        $params['Session']  = $this->getSessionId();
        $response           = $this->makeApiCall('GET', self::CONFIRMATION_ENDPOINT, $params);
        $confirmation       = $response->getDecodedBody();

        return ReservationConfirmationModel::populateModel((array)$confirmation[0]);
    }

    /**
     * Provides the ability to Save a Reservation as a Quote.
     *
     * @param ReservationQuoteInputModel $inputModel
     * @return \AdventureRes\Models\Output\ReservationModel
     * @throws AdventureResSDKException
     */
    public function saveReservationAsQuote(ReservationQuoteInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params             = $inputModel->getAttributes();
        $params['Location'] = $this->app->getLocation();
        $params['Session']  = $this->getSessionId();
        $response           = $this->makeApiCall('POST', self::SAVE_AS_QUOTE_ENDPOINT, $params);
        $result             = $response->getDecodedBody();

        if(empty($result))
            return false;

        return ReservationModel::populateModel((array)$result[0]);
    }

    /**
     * Provides the ability to list online fees for Cancellation or Insurance, etc.
     *
     * @param ReservationItineraryInputModel $inputModel
     * @return array [AdventureRes\Models\Output\FeeModel]
     * @throws AdventureResSDKException
     */
    public function listFees(ReservationFeesInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params             = $inputModel->getAttributes();
        $params['Session']  = $this->getSessionId();
        $response           = $this->makeApiCall('GET', self::LIST_FEES_ENDPOINT, $params);
        $result             = $response->getDecodedBody();
        $fees               = [];

        foreach ($result as $fee) {
            $fees[] = FeeModel::populateModel((array)$fee);
        }

        return $fees;
    }

    /**
     * Provides ability to remove online fees for cancellation or insurance, etc.
     *
     * @param ReservationFeeRemoveInputModel $inputModel
     * @return \AdventureRes\Models\Output\FeeModel
     * @throws AdventureResSDKException
     */
    public function removeFee(ReservationFeeRemoveInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params             = $inputModel->getAttributes();
        $params['Session']  = $this->getSessionId();
        $response           = $this->makeApiCall('POST', self::REMOVE_FEES_ENDPOINT, $params);
        $result             = $response->getDecodedBody();

        return FeeModel::populateModel((array)$result[0]);
    }
}

/* End of AdventureResReservationService.php */