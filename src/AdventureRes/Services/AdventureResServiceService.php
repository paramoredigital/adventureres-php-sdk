<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Services;

use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Models\Input\ServiceClassificationInputModel;
use AdventureRes\Models\Input\ServiceAddInputModel;
use AdventureRes\Models\Input\ServiceAvailabilityInputModel;
use AdventureRes\Models\Input\ServiceDisplayInputModel;
use AdventureRes\Models\Input\ServiceRemoveInputModel;
use AdventureRes\Models\Output\ServiceClassificationModel;
use AdventureRes\Models\Output\ReservationModel;
use AdventureRes\Models\Output\ServiceModel;
use AdventureRes\PersistentData\AdventureResSessionKeys;

/**
 * Class AdventureResServiceService
 *
 * @package AdventureRes\Services
 */
class AdventureResServiceService extends AbstractAdventureResService
{
    /**
     * {@inheritdoc}
     */
    const API_SERVICE = 'service';
    const CLASSIFICATION_ENDPOINT = '/Classifications';
    const SERVICE_GROUP_ENDPOINT = '/Groups';
    const SERVICE_DISPLAY_ENDPOINT = '/Display';
    const SERVICE_AVAILABILITY_ENDPOINT = '/Availability';
    const SERVICE_ADD_ENDPOINT = '/Add';
    const SERVICE_REMOVE_ENDPOINT = '/Remove';

    /**
     * Gets service classifications from the API.
     *
     * @param ServiceClassificationInputModel $inputModel
     * @return array [AdventureRes\Models\Output\ServiceClassificationModel]
     * @throws \AdventureRes\Exceptions\AdventureResResponseException
     */
    public function getClassifications(ServiceClassificationInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response        = $this->makeApiCall('GET', self::CLASSIFICATION_ENDPOINT, $params);
        $classifications = $response->getDecodedBody();
        $models          = [];

        foreach ($classifications as $classification) {
            $models[] = ServiceClassificationModel::populateModel((array)$classification);
        }

        return $models;
    }

    /**
     * Gets service groups from the API. Nearly identical to `getClassifications`.
     *
     * @param ServiceClassificationInputModel $inputModel
     * @return array [AdventureRes\Models\Output\ServiceClassificationModel]
     * @throws \AdventureRes\Exceptions\AdventureResResponseException
     */
    public function getServiceGroups(ServiceClassificationInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response        = $this->makeApiCall('GET', self::SERVICE_GROUP_ENDPOINT, $params);
        $serviceGroups = $response->getDecodedBody();
        $models          = [];

        foreach ($serviceGroups as $serviceGroup) {
            $models[] = ServiceClassificationModel::populateModel((array)$serviceGroup);
        }

        return $models;
    }

    /**
     * Gets information about a service.
     *
     * @param ServiceDisplayInputModel $inputModel
     * @return \AdventureRes\Models\ServiceModel
     * @throws AdventureResSDKException
     */
    public function getService(ServiceDisplayInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('GET', self::SERVICE_DISPLAY_ENDPOINT, $params);
        $services          = $response->getDecodedBody();

        return ServiceModel::populateModel((array)$services[0]);
    }

    /**
     * Gets all availability options for a service by provided date.
     *
     * @param ServiceAvailabilityInputModel $inputModel
     * @return array [AdventureRes\Models\Output\ServiceModel]
     * @throws AdventureResSDKException
     */
    public function getServiceAvailability(ServiceAvailabilityInputModel $inputModel)
    {
        $options = [];

        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params               = $inputModel->getAttributes();
        $params['Session']    = $this->getSessionId();
        $response             = $this->makeApiCall('GET', self::SERVICE_AVAILABILITY_ENDPOINT, $params);
        $availability         = $response->getDecodedBody();

        foreach ($availability as $option) {
            $options[] = ServiceModel::populateModel((array)$option);
        }

        return $options;
    }

    /**
     * Adds a service to a customer's reservation. If the reservation hasn't been set, it creates a new reservation ID.
     *
     * @param ServiceAddInputModel $inputModel
     * @return \AdventureRes\Models\AbstractAdventureResModel
     * @throws AdventureResSDKException
     */
    public function addServiceToReservation(ServiceAddInputModel $inputModel)
    {
        $dataHandler = $this->app->getDataHandler();

        if (! $inputModel->ReservationId) {
            $inputModel->ReservationId = $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID, $defaultValue = 0);
        }

        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('POST', self::SERVICE_ADD_ENDPOINT, $params);
        $result            = $response->getDecodedBody();

        /** @var ReservationModel $reservation */
        $reservation = ReservationModel::populateModel((array)$result[0]);

        if ($reservation->isValid() && $reservation->ReservationId
          && $reservation->ReservationId !== $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID)) {
            $dataHandler->set(AdventureResSessionKeys::RESERVATION_ID, $reservation->getAttribute('ReservationId'));
        }

        return $reservation;
    }

    /**
     * Removes a service from a reservation. If the result of the call leaves the reservation with zero
     * services, the reservation id in the session is set back to 0.
     *
     * @param ServiceRemoveInputModel $inputModel
     * @return mixed
     * @throws AdventureResSDKException
     */
    public function removeServiceFromReservation(ServiceRemoveInputModel $inputModel)
    {
        $dataHandler = $this->app->getDataHandler();

        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params            = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response          = $this->makeApiCall('POST', self::SERVICE_REMOVE_ENDPOINT, $params);
        $result            = $response->getDecodedBody()[0];

        if ($result->ReservationId && $result->ReservationId !== $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID)) {
            $dataHandler->set(AdventureResSessionKeys::RESERVATION_ID, $result->ReservationId);
        }

        return $result->ReservationItemId;
    }
}

/* End of AdventureResServiceService.php */