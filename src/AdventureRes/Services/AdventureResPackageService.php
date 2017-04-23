<?php
/**
 * Copyright 2017 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Services;

use AdventureRes\Exceptions\AdventureResSDKException;
use AdventureRes\Models\Input\GroupListInputModel;
use AdventureRes\Models\Input\PackageAvailabilityInputModel;
use AdventureRes\Models\Output\GroupModel;
use AdventureRes\Models\Output\PackageModel;


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
            $models[] = GroupModel::populateModel((array) $group);
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
            $options[] = PackageModel::populateModel((array) $option);
        }

        return $options;
    }
}