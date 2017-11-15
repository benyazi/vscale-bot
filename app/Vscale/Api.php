<?php
namespace App\Vscale;

class Api {
    /**
     * @var string|null The access token to use for this request.
     */
    protected $accessToken;

    /**
     * @var string The method for this request.
     */
    protected $method;

    /**
     * @var string The API endpoint for this request.
     */
    protected $endpoint;

    /**
     * @var array The headers to send with this request.
     */
    protected $headers = [];

    /**
     * @var array The parameters to send with this request.
     */
    protected $params = [];

    /**
     * @var array The files to send with this request.
     */
    protected $files = [];

    /**
     * Indicates if the request to Telegram will be asynchronous (non-blocking).
     *
     * @var bool
     */
    protected $isAsyncRequest = false;

    /**
     * Timeout of the request in seconds.
     *
     * @var int
     */
    protected $timeOut = 30;

    /**
     * Connection timeout of the request in seconds.
     *
     * @var int
     */
    protected $connectTimeOut = 10;

    protected $client;

    const API_URL = 'https://api.vscale.io/v1/';
    const METHOD_BILLING_PRICES = 'BILLING_PRICES';
    const METHOD_BILLING_BALANCE = 'BILLING_BALANCE';
    const METHOD_SCARLETS = 'SCARLETS';

    protected $method_urls = array(
        self::METHOD_BILLING_PRICES => "billing/prices",
        self::METHOD_BILLING_BALANCE => "billing/balance",
        self::METHOD_SCARLETS => "scalets",
    );

    /**
     * Creates a new Request entity.
     *
     * @param string|null $accessToken
     * @param string|null $method
     * @param string|null $endpoint
     * @param array|null  $params
     * @param bool        $isAsyncRequest
     * @param int         $timeOut
     * @param int         $connectTimeOut
     */
    public function __construct(
        $accessToken = null,
        $method = null,
        $endpoint = null,
        array $params = [],
        $isAsyncRequest = false,
        $timeOut = 60,
        $connectTimeOut = 10
    ) {
        $this->setAccessToken($accessToken);
        $this->setMethod($method);
        //$this->setEndpoint($endpoint);
        //$this->setParams($params);
        //$this->setAsyncRequest($isAsyncRequest);
        //$this->setTimeOut($timeOut);
        //$this->setConnectTimeOut($connectTimeOut);
        $this->client = new \GuzzleHttp\Client();
    }

    public function getParams() {
        return array(
            "headers" => $this->getHeaders()
        );
    }


    /**
     * Set the HTTP method for this request.
     *
     * @param string
     *
     * @return Api
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Return the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function getHeaders() {
        return array(
            'X-Token' => $this->getAccessToken(),
            'Accept' => 'application/json',
        );
    }
    
    public function getUrl() {
        return self::API_URL.$this->method_urls[$this->getMethod()];
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */

    public function request() {
        $res = $this->client->request(
            'GET',
            $this->getUrl(),
            $this->getParams()
        );
        return $res;
    }

    /**
     * Set the access token for this request.
     *
     * @param string
     *
     * @return Api
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Return the access token for this request.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Validate that bot access token exists for this request.
     *
     * @throws Exception
     */
    public function validateAccessToken()
    {
        $accessToken = $this->getAccessToken();
        if ($accessToken === null) {
            //throw new TelegramSDKException('You must provide your bot access token to make any API requests.');
        }
    }
}