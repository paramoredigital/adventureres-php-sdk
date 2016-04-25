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
    protected $fakeRawBodySessionInvalid = '{"ValidSessionResult": "[{\"Session\":\"sampleSessionId\",\"ValidSession\":false,\"Result\":\"SUCCESS\"}]"
}';

}
