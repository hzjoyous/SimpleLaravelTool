<?php


namespace App\Utils\XPath;


use Symfony\Component\DomCrawler\Crawler;

class DouBanGroupXPath
{
    private string $content;

    public function __construct(string $content)
    {
        new Crawler($content);
    }


}
