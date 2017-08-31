# AdventureRes SDK for PHP

This repository contains the open source PHP Software Development Kit that provides an easy way for PHP developers to communicate with the AdventureRes API. Full class reference is available [here](http://paramoredigital.github.io/adventureres-php-sdk/docs/).

> **Important Note**

This is NOT a plug-and-play store integration with the AdventureRes API. It cannot be used directly with WordPress for instance. To make use of this repository, a developer will be needed to create the store interface and manage the user's path through the checkout experience. There are no design assets, HTML, styles or javascript included in this repository.

Our aim instead is to lay the ground work for accomplishing these things by providing a simple and consistent way to pass data back and forth from your website/application to the AdventureRes system. What we do provide in this repository is a cohesive PHP class that can be used in a wide variety of PHP-based content management systems and PHP platforms. It handles input validation, API endpoint requests, response formatting, error handling, and browser sessions. This allieviates most of the potential errors and addresses many common needs involved with working with the AdventureRes API directly, while preserving the full functionality.

Put simply, this repository is not an ecommerce store -- it's the halfway mark. We built all the pieces to fit, but there is some assembly required.


## Installation

```sh
composer require adventureres/php-sdk-v1
```

## Usage 

> **Note:** This SDK requires PHP version 5.4 or greater. 

### Setting up the SDK

To set up the SDK, pass in the required configuration parameters:

```php
$advRes = new AdventureRes\AdventureRes(
    $baseDomain = 'http://reservations.domain.com',
    $apiKey     = '12345abcde', // <- Comes from your AdventureRes installation
    $username   = 'theuser', 
    $password   = 'opensesame',
    $location   = 10
);
```

### Models

All data passed into and retrieved from the API should be in a model. The SDK will validate all input models when calling the API, but developers will be responsible for validating output models.

#### Creating input models and setting attributes

Models can be created by either using the static `populateModel` method, or by using the class constructor.

```php
use AdventureRes\Models\Input\ServiceAvailabilityInputModel;

// Static declaration:
$input = ServiceAvailabilityModel::populateModel([
    'AdultQty'   => 2,
    'YouthQty'   => 0,
    'Units'      => 0,
    'StartDate'  => '06/01/2016',
    'Display'    => 'ITEM'
]);

// Class declaration with attributes passed via the constructor:
$input = new ServiceAvailabilityModel([
    'AdultQty'   => 2,
    'YouthQty'   => 0,
    'Units'      => 0,
    'StartDate'  => '06/01/2016',
    'Display'    => 'ITEM'
]);
```

Attributes can also be set after the model has been instantiated by using the `setAttribute` method:

```php
$input->setAttribute('AdultQty', 5);
```

#### Validating models and getting errors

To validate a model, use the `isValid` method. You can also retrive errors from the model if it's invalid by using the `getErrors` method.

> **Note:** `isValid` must be run before `getErrors`.

```php
if (! $model->isValid()) {
    // Get errors as an array
    $errors = $model->getErrors();

    // Get errors as a concatenated string
    $errorString = $model->getErrorsAsString();
}
```

#### Getting values from model attributes

Model attributes can be accessed in a few different ways:

```php
// Gets an array of all attributes and their values
$attributes = $model->getAttributes();

// Gets the value of one attribute
$attribute = $model->getAttribute('AdultPrice');

// Gets the value of one attribute using magic method
$attribute = $model->AdultPrice;
```

### Talking to API Endpoints

The SDK is segmented in the same way as the API - by service methods, package methods, reservation methods and customer methods:

```php
$serviceAvailability = $advRes->service()->getServiceAvailability($inputModel);
$package = $advRes->package()->getPackage($inputModel);
$costSummary = $advRes->reservation()->getCostSummary($inputModel);
$newCustomer = $advRes->customer()->createCustomer($inputModel);
```

## Full example

```php
use AdventureRes\AdventureRes;
use AdventureRes\Models\Input\ServiceAvailabilityInputModel;

$advRes = new AdventureRes($config['baseDomain'], $config['apiKey'], $config['username'], $config['password'], $config['location']);

try {
    $input = ServiceAvailabilityInputModel::populateModel([
        'ServiceId' => 123,
        'AdultQty'  => 2,
        'YouthQty'  => 0,
        'Units'     => 0,
        'StartDate' => '06/01/2016',
        'Display'   => 'ITEM'
    ]);

    $serviceAvailability = $advRes->service()->getServiceAvailability($input);

    if (! $serviceAvailability->isValid()) {
        throw new \Exception($serviceAvailability->getErrorsAsString());
    }

} catch (AdventureRes\Exceptions\AdventureResSDKException $ex) {
    return $ex->getMessage();
}
```