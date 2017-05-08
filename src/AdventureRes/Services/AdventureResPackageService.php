<?php
/**
 * Copyright 2017 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Services;

use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Models\Input\GroupListInputModel;
use AdventureRes\Models\Input\PackageAddInputModel;
use AdventureRes\Models\Input\PackageAvailabilityInputModel;
use AdventureRes\Models\Input\PackageDisplayInputModel;
use AdventureRes\Models\Input\PackageRemoveInputModel;
use AdventureRes\Models\Output\GroupModel;
use AdventureRes\Models\Output\PackageModel;
use AdventureRes\Models\Output\ReservationModel;
use AdventureRes\PersistentData\AdventureResSessionKeys;


/**
 * Class AdventureResPackageService
 * @package AdventureRes\Services
 */
class AdventureResPackageService extends AbstractAdventureResService
{
    /**
     * {@inheritdoc}
     */
    const API_SERVICE = 'package';
    const GROUP_LIST_ENDPOINT = '/Groups';
    const PACKAGE_AVAILABILITY_ENDPOINT = '/Availability';
    const PACKAGE_DISPLAY_ENDPOINT = '/Display';
    const PACKAGE_ADD_ENDPOINT = '/Add';
    const PACKAGE_REMOVE_ENDPOINT = '/Remove';

    /**
     * Provides the ability to display the Package Groups that are available for a certain date.
     *
     * @param GroupListInputModel $inputModel
     * @return array
     * @throws AdventureResSDKException
     */
    public function getGroups(GroupListInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $params['LocationId'] = $this->app->getLocation();

        $response = $this->makeApiCall('GET', self::GROUP_LIST_ENDPOINT, $params);
        $groups = $response->getDecodedBody();
        $models = [];

        foreach ($groups as $group) {
            $models[] = GroupModel::populateModel((array)$group);
        }

        return $models;
    }

    /**
     * Provides the ability to display the Package Availability for a certain date.
     *
     * @param PackageAvailabilityInputModel $inputModel
     * @return array
     * @throws AdventureResSDKException
     */
    public function getPackageAvailability(PackageAvailabilityInputModel $inputModel)
    {
        $options = [];

        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $params['LocationId'] = $this->app->getLocation();
        $response = $this->makeApiCall('GET', self::PACKAGE_AVAILABILITY_ENDPOINT, $params);
        $availability = $response->getDecodedBody();

        foreach ($availability as $option) {
            $options[] = PackageModel::populateModel((array)$option);
        }

        return $options;
    }

    /**
     * Provides the ability to display the Package.
     *
     * @param PackageDisplayInputModel $inputModel
     * @return \AdventureRes\Models\AbstractAdventureResModel|mixed
     * @throws AdventureResSDKException
     */
    public function getPackage(PackageDisplayInputModel $inputModel)
    {
        if (!$inputModel->isValid()) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params = $inputModel->getAttributes();
        $params['Session'] = $this->getSessionId();
        $response = $this->makeApiCall('GET', self::PACKAGE_DISPLAY_ENDPOINT, $params);
        $packages = $response->getDecodedBody();

        return PackageModel::populateModel((array) $packages[0]);
    }

    /**
     * Adds a package to a customer's reservation. If the reservation hasn't been set, it creates a new reservation ID.
     *
     * @param PackageAddInputModel $inputModel
     * @return \AdventureRes\Models\AbstractAdventureResModel
     * @throws AdventureResSDKException
     */
    public function addPackageToReservation(PackageAddInputModel $inputModel)
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
        $response          = $this->makeApiCall('POST', self::PACKAGE_ADD_ENDPOINT, $params);
        $result            = $response->getDecodedBody();

        /** @var ReservationModel $reservation */
        $reservation = ReservationModel::populateModel((array)$result[0]);

        if ($reservation->isValid()) {
            $dataHandler->set(AdventureResSessionKeys::RESERVATION_ID, $reservation->getAttribute('ReservationId'));
        }

        return $reservation;
    }

    /**
     * Removes a package from a reservation. If the result of the call leaves the reservation with zero
     * services/packages, the reservation id in the session is set back to 0.
     *
     * @param PackageRemoveInputModel $inputModel
     * @return mixed
     * @throws AdventureResSDKException
     */
    public function removePackageFromReservation(PackageRemoveInputModel $inputModel)
    {
        $dataHandler = $this->app->getDataHandler();
        $reservationId = $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID);

        if (!$inputModel->isValid() || is_null($reservationId)) {
            throw new AdventureResSDKException($inputModel->getErrorsAsString());
        }

        $params = $inputModel->getAttributes();
        $params['ReservationId'] = $reservationId;
        $params['Session'] = $this->getSessionId();
        $response = $this->makeApiCall('POST', self::PACKAGE_REMOVE_ENDPOINT, $params);
        $result = $response->getDecodedBody()[0];

        if ($result->ReservationId !== $dataHandler->get(AdventureResSessionKeys::RESERVATION_ID)) {
            $dataHandler->set(AdventureResSessionKeys::RESERVATION_ID, $result->ReservationId);
        }

        return $result->PackageId;
    }
}