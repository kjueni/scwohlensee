<?php

namespace App\Service\Stats;

use Symfony\Component\DomCrawler\Crawler;

interface CrawlerInterface
{
    /**
     * @param string $url
     */
    public function setUrl(string $url);

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @return array
     */
    public function crawl(): array;

    /**
     * @return Crawler
     */
    public function getCrawler(): Crawler;

    /**
     * @param Crawler $crawler
     */
    public function setCrawler(Crawler $crawler);
}
