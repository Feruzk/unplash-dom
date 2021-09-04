<?php

require 'vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;

$keyword = 'cat';

$url = 'https://navigatioh.com/s/photos/'.$keyword;

$client = new \GuzzleHttp\Client();

$res = $client->request('GET', $url);

$html = ''.$res->getBody();

$crawler = new Crawler($html);

//loop through the data
$items = $crawler->filter('.content > div > div')->each(function (Crawler $node, $i) {

    $text = $node->text();
    $image = $node->filter('img')->attr('src');
    $item = [
      'image' => $image,
      'text' => $text
    ];

    return $item;
});

foreach ($items as $item) {

    echo '<img src="'.$item['image'].'"/>';
    echo '<p>'.$item['text'].'</p>';

}

?>
