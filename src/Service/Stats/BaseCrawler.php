<?php

namespace App\Service\Stats;

use Goutte\Client;

use Symfony\Component\DomCrawler\Crawler;

abstract class BaseCrawler implements
    CrawlerInterface
{
    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var string
     */
    protected $url;

    /**
     * BaseCrawler constructor.
     *
     * @param string|null $url
     */
    public function __construct(string $url = null)
    {
        if ($url !== null) {
            $this->setUrl($url);
        }
    }

    /**
     * @return Crawler
     */
    private function initCrawler(): Crawler
    {
        $client = new Client();
        $crawler = $client->request(
            'GET',
            $this->getUrl()
        );

        return $crawler;
    }

    /**
     * @return Crawler
     */
    public function getCrawler(): Crawler
    {
        if (!$this->crawler) {
            $this->setCrawler(
                $this->initCrawler()
            );
        }

        return $this->crawler;
    }

    /**
     * @param Crawler $crawler
     */
    public function setCrawler(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }
}
