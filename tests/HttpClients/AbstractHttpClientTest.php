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

}
