<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Services;

use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Models\Input\ItineraryInputModel;
use AdventureRes\Models\Input\PaymentInputModel;
use AdventureRes\Models\Input\PromoCodeInputModel;
use AdventureRes\Models\Output\CostSummaryModel;
use AdventureRes\Models\Output\PaymentDueModel;
use AdventureRes\Models\Output\PaymentMethodModel;
use AdventureRes\Models\Output\ReservationConfirmationModel;
use AdventureRes\Models\Output\ReservationItemModel;
use AdventureRes\Models\Output\ReservationModel;
use AdventureRes\Models\Output\ReservationPolicyModel;

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

    /**
     * Gets applicable policies for a reservations.
     *
     * @param ItineraryInputModel $input
     * @return array [\AdventureRes\Models\Output\ReservationPolicyModel]
     * @throws AdventureResSDKException
     */
    public function getReservationPolicies(ItineraryInputModel $input)
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
     * @param ItineraryInputModel $inputModel
     * @return array [\AdventureRes\Models\Output\ReservationItemModel]
     * @throws AdventureResSDKException
     */
    public function getItinerary(ItineraryInputModel $inputModel)
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
     * @param ItineraryInputModel $inputModel
     * @return \AdventureRes\Models\Output\CostSummaryModel
     * @throws AdventureResSDKException
     */
    public function getCostSummary(ItineraryInputModel $inputModel)
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
     * @return array [\AdventureRes\Models\Output\PaymentMethodModel]
     */
    public function getPaymentMethods()
    {
        $params = [
          'LocationId' => $this->app->getLocation(),
          'Session'    => $this->getSessionId()
        ];

        $response       = $this->makeApiCall('GET', self::PAYMENT_METHODS_ENDPOINT, $params);
        $paymentMethods = $response->getDecodedBody();
        $models         = [];

        foreach ($paymentMethods as $method) {
            $models[] = PaymentMethodModel::populateModel((array)$method);
        }

        return $models;
    }

    /**
     * Adds a payment to the reservation.
     *
     * @param PaymentInputModel $inputModel
     * @return \AdventureRes\Models\Output\ReservationModel
     * @throws AdventureResSDKException
     */
    public function addPayment(PaymentInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('POST', self::PAYMENT_ADD_ENDPOINT, $params);
        $result            = $response->getDecodedBody();

        return ReservationModel::populateModel((array)$result[0]);
    }

    /**
     * Gets the payment due for a reservation.
     *
     * @param ItineraryInputModel $inputModel
     * @return \AdventureRes\Models\Output\PaymentDueModel
     * @throws AdventureResSDKException
     */
    public function getPaymentDue(ItineraryInputModel $inputModel)
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
     * @param PromoCodeInputModel $inputModel
     * @return \AdventureRes\Models\AbstractAdventureResModel
     * @throws AdventureResSDKException
     */
    public function addPromoCode(PromoCodeInputModel $inputModel)
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
     * @param ItineraryInputModel $inputModel
     * @return \AdventureRes\Models\AbstractAdventureResModel
     * @throws AdventureResSDKException
     */
    public function getConfirmationMessage(ItineraryInputModel $inputModel)
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
}

/* End of AdventureResReservationService.php */