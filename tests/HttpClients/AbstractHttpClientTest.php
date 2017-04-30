<?php

namespace AdventureRes\Tests\HttpClients;

use AdventureRes\Tests\AbstractAdventureResTest;

abstract class AbstractHttpClientTest extends \PHPUnit_Framework_TestCase
{
    const CURL_VERSION_STABLE = 0x072400;
    const CURL_VERSION_BUGGY = 0x071400;

    // HEADERS
    /**
     * @var string A default fake header
     */
    protected $fakeRawHeader = "HTTP/1.1 200 OK
Etag: \"9d86b21aa74d74e574bbb35ba13524a52deb96e3\"
Content-Type: text/javascript; charset=UTF-8
X-FB-Rev: 9244768
Pragma: no-cache
Expires: Sat, 01 Jan 2000 00:00:00 GMT
Connection: close
Date: Mon, 19 May 2014 18:37:17 GMT
X-FB-Debug: 02QQiffE7JG2rV6i/Agzd0gI2/OOQ2lk5UW0=
Content-Length: 29
Cache-Control: private, no-cache, no-store, must-revalidate
Access-Control-Allow-Origin: *\r\n\r\n";

    // BODIES
    /**
     * @var string A default fake body
     */
    protected $fakeRawBody = "{\"id\":\"123\",\"name\":\"Foo Bar\"}";
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyLogin = '{"LoginResult": "[{\"Session\":\"sampleSessionId\",\"ValidSession\":true,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyLoginInvalid = '{"LoginResult": "[{\"Session\":\"\",\"ValidSession\":false,\"Result\":\"ERROR: INVALID LOGIN\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodySessionValid = '{"ValidSessionResult": "[{\"Session\":\"sampleSessionId\",\"ValidSession\":true,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodySessionInvalid = '{"ValidSessionResult": "[{\"Session\":\"sampleSessionId\",\"ValidSession\":false,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyClassificationList = '{"ClassificationsResult": "[{\"ServiceId\":218,\"Description\":\"Lower New River Trips\",\"ClassId\":1}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyServiceDisplay = '{"ServiceDisplayResult": "[{\"ServiceId\":218,\"Description\":\"Lower New River Trips\",\"ClassId\":1,\"Image1\":\"\",\"Image2\":\"\",\"AdultRate\":129.0000,\"YouthRate\":129.0000,\"Comment\":\"The lower section of the New River...\",\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyServiceAvailability = "[{\"Result\":\"SUCCESS\",\"ServiceId\":43,\"ServiceDate\":\"8/11/2015\",\"ServiceTime\":\"06:50\",\"ServiceScheduleItemId\":0,\"Description\":\"MSA 1/2 Day Float Fish\",\"Comment\":\"Available in the morning of afternoon, our half-day smallmouth float will you give you a taste of why the New River is one of the best smallmouth fisheries in the East Coast!\\r\\n\\u003cp/\\u003e\\r\\nMinimum Age: 6 years old\\r\\n\\u003cp/\\u003e\\r\\nIf a trip appears to be unavailable, please call us at 888.650.1931 to check if there are any spots remaining. \",\"Image1\":\"/Online/images/ARS Online photos_325.jpg\",\"Image2\":\"\",\"ShowAvailability\":true,\"Availability\":\"0\",\"AvailabilityPercentage\":\"0\",\"DisplayType\":\"Unavailable\",\"AdultRate\":315.00,\"YouthRate\":0.00},{\"Result\":\"SUCCESS\",\"ServiceId\":43,\"ServiceDate\":\"8/11/2015\",\"ServiceTime\":\"14:50\",\"ServiceScheduleItemId\":0,\"Description\":\"MSA 1/2 Day Float Fish\",\"Comment\":\"Available in the morning of afternoon, our half-day smallmouth float will you give you a taste of why the New River is one of the best smallmouth fisheries in the East Coast!\\r\\n\\u003cp/\\u003e\\r\\nMinimum Age: 6 years old\\r\\n\\u003cp/\\u003e\\r\\nIf a trip appears to be unavailable, please call us at 888.650.1931 to check if there are any spots remaining. \",\"Image1\":\"/Online/images/ARS Online photos_325.jpg\",\"Image2\":\"\",\"ShowAvailability\":true,\"Availability\":\"0\",\"AvailabilityPercentage\":\"0\",\"DisplayType\":\"Unavailable\",\"AdultRate\":315.00,\"YouthRate\":0.00}]";
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyServiceAdd = '{"AddResult": "[{\"ReservationId\":123,\"CustomerId\":0,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyServiceRemove = '{"RemoveResult": "[{\"ReservationId\":0,\"ReservationItemId\":123,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyReservationPolicies = '{"PoliciesResult": "[{\"PolicyId\":111,\"Description\":\"Cabin rental 2-night minimum.\",\"Details\":\"Please note that there is a 2-night minimum for cabin rentals. You will be charged an additional fee after your reservation is confirmed by our staff if you only book for 1 night.\",\"Mandatory\":true,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyItineraryDisplay = "[{ \"ReservationItemId\":\"100403\", \"ServiceId\":2, \"Description\":\"Canyon Rim Lower New River\", \"ServiceTime\":\"09:35\", \"Comments\":\"The lower section of the... \", \"ServiceDate\":\"7/11/2016 12:00:00 AM\", \"AdultQty\":2, \"YouthQty\":0, \"TotalAdult\":258.0000, \"TotalYouth\":0.0000, \"TotalDiscounts\":80.0000, \"TotalTax\":23.3800, \"TotalCost\":201.3800, \"InvoiceComments\":\"This trip meets at the Canyon R..... \", \"Notes\":\"\",\"Result\":\"SUCCESS\"}, {\"ReservationItemId\":\"100404\", \"ServiceId\":10, \"Description\":\"CR Wetsuit Rental-Prepay\", \"ServiceTime\":\"\",\"Comments\":\"Our 3 mm wetsuits have tank-style .....\", \"ServiceDate\":\"6/1/2014\",\"AdultQty\":2,\"YouthQty\":0,\"TotalAdult\":0.0000, \"TotalYouth\":0.0000, \"TotalDiscounts\":0.0000, \"TotalTax\":0.0000, \"TotalCost\":0.0000, \"InvoiceComments\":\"\", \"Notes\":\"\", \"Result\":\"SUCCESS\"}]";
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyCostSummary = "{\"Result\": [{\"ReservationTotalAdult\":0, \"ReservationTotalYouth\":0, \"ReservationTotalSubTotal\":5370.00, \"ReservationTotalTax\":543.90, \"ReservationTotalDiscounts\":0.00, \"ReservationTotalCost\":5913.90, \"ReservationPayments\":0.00, \"ReservationBalance\":5913.90, \"Result\":\"SUCCESS\"}]}";
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPaymentMethods = "{\"Result\": [{\"PaymentMethodId\":8,\"CreditCard\":\"American Express\",\"Result\":\"SUCCESS\"}, {\"PaymentMethodId\":9,\"CreditCard\":\"Discover\",\"Result\":\"SUCCESS\"}, {\"PaymentMethodId\":7,\"CreditCard\":\"MasterCard\",\"Result\":\"SUCCESS\"}, {\"PaymentMethodId\":6,\"CreditCard\":\"Visa\",\"Result\":\"SUCCESS\"}]}";
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPaymentAdd = '{"AddResult": "[{\"ReservationId\":10001,\"CustomerId\":0,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPaymentDue = '{"Result": "[{\"ReservationId\":10001,\"PaymentDue\":118.50,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPromoCodeAdd = '{"Result": "[{\"ReservationId\":10001,\"Result\":\"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyConfirmationMessage = '{"Result": "[{\"ReservationId\": 10001, \"Confirmation\":\"An email has been sent to you with important details regarding your itinerary.<p><b>PLEASE READ IT CAREFULLY!<\/b><\/p><p> If there are any problems with the details on your quote please contact our office as soon as possible. <\/p><p><b>PLEASE BE AWARE. YOU HAVE NOT MADE A RESERVATION. THIS IS ONLY A QUOTE.<\/b><\/p><p> IF YOU WANT TO CONVERT YOUR QUOTE INTO A RESERVATION PLEASE CONTACT OUR OFFICE.<\/p><p><br><\/p>\", \"Result\":\"SUCCESS\" }]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPackageGroupList = '{"Result": "[{\"PackageGroupId\": \"23\", \"Description\" : \"Fall Upper Gauley Splash Dash\", \"Result\": \"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPackageAvailability = "[{ \"PackageId\": \"23\", \"Description\" : \"Fall Upper Gauley Splash Dash\", \"AdultRate\": 179.00, \"YouthRate\": 169.00, \"Comment\": \" \", \"Available\": true, \"Result\": \"SUCCESS\"}]";
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPackageDisplay = '{"Result": "[{ \"PackageId\": \"23\", \"Description\" : \"Fall Upper Gauley Splash Dash\", \"URL\": \"Fall Upper Gauley Splash Dash\", \"AdultRate\": 179.00, \"YouthRate\": 169.00, \"Comment\": \"Fall Upper Gauley Splash Dash\", \"Result\": \"SUCCESS\" }]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPackageAdd = '{"Result": "[{\"ReservationId\":0,\"CustomerId\":0, \"PackageString\":\"512,7/4/2014,00:00:00,1,0,1\", \"Available\":true,\"Result\": \"SUCCESS\"}]"}';
    /**
     * @var string A default fake body
     */
    protected $fakeRawBodyPackageRemove = '{"Result": "[{\"ReservationId\": 0, \"PackageId\": 23, \"Result\": \"SUCCESS\"}]"}';
}
