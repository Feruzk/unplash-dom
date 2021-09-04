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

$file = fopen('images.csv', 'w');

$i = 1; //counter
foreach ($items as $item) {
    //grab the images
    $file_name = 'images/'.$i.'.png';
    //get the content
    $image_content = file_get_content($item(['image']));
    //add the content
    file_put_contents($file_name, $image_content);
    //update path
    $item['image'] = $file_name;
    //write to the csv
    fputcsv($file, $item);

    //count
    $i++;

}

fclose($file);

echo 'File saved';

?>
