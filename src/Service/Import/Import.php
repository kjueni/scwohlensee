<?php

namespace App\Service\Import;

use GuzzleHttp\Client as GuzzleCLient;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Psr\Http\Message\StreamInterface;

class Import implements
    ImportInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * Import constructor.
     *
     * @param $url
     */
    public function __construct($url)
    {
        $this->setUrl($url);
    }

    /**
     * @return array
     */
    public function import()
    {
        $requestData = $this->requestData();
        $items = $this->decodeJson($requestData);

        return $items;
    }

    /**
     * @return StreamInterface
     * @throws \Exception
     */
    protected function requestData()
    {
        $client = new GuzzleCLient();
        $response = $client->request(
            'GET',
            $this->getUrl()
        );

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Request failed');
        }

        return $response->getBody();
    }

    /**
     * @param StreamInterface $data
     * @return array
     */
    protected function decodeJson($data)
    {
        $decoder = new JsonEncoder();
        return $decoder->decode($data, JsonEncoder::FORMAT);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
