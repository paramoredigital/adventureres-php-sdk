<?php
/**
 * Copyright 2017 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Services;


use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Models\Input\CustomerInputModel;
use AdventureRes\Models\Output\CustomerModel;
use AdventureRes\PersistentData\AdventureResSessionKeys;

class AdventureResCustomerService extends AbstractAdventureResService
{
    /**
     * {@inheritdoc}
     */
    const API_SERVICE = 'customer';
    const CREATE_CUSTOMER_ENDPOINT = '/Insert';

    /**
     * Provides the ability to insert a New Customer Record and optionally tie it to a Reservation.
     *
     * @param CustomerInputModel $inputModel
     * @return \AdventureRes\Models\Output\CustomerModel
     * @throws AdventureResSDKException
     */
    public function createCustomer(CustomerInputModel $inputModel)
    {
        $dataHandler = $this->app->getDataHandler();

        if (!$inputModel->ReservationId) {
            $inputModel->ReservationId = $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID, $defaultValue = 0);
        }

        if (!$inputModel->CustomerId) {
            $inputModel->CustomerId = $dataHandler->get(AdventureResSessionKeys::CUSTOMER_ID, $defaultValue = 0);
        }

        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $params['LocationId'] = $this->app->getLocation();
        $response = $this->makeApiCall('POST', self::CREATE_CUSTOMER_ENDPOINT, $params);
        $result = $response->getDecodedBody();

        $customer = CustomerModel::populateModel((array)$result[0]);

        if ($customer->isValid()) {
            $dataHandler->set(AdventureResSessionKeys::CUSTOMER_ID, $customer->getAttribute('CustomerId'));
        }

        return $customer;
    }
}