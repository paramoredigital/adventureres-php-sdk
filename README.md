# AdventureRes SDK for PHP

This repository contains the open source PHP SDK that provides an easy way for PHP developers to access the AdventureRes SDK.

## Installation

```sh
composer require facebook/php-sdk-v4
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

### Services and Reservations

The SDK is segmented in the same way as the API - by service methods and reservation methods:

```php
$serviceAvailability = $advRes->service()->getServiceAvailability($inputModel);

$costSummary = $advRes->reservation()->getCostSummary($inputModel);
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