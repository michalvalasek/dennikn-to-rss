<?php

require 'vendor/autoload.php';

use Sunra\PhpSimple\HtmlDomParser;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Item;

const ENTRIES_LIMIT = 10;

date_default_timezone_set('Europe/Bratislava');

$dom = HtmlDomParser::file_get_html('https://dennikn.sk/');
$entries = $dom->find('#tricode-homepage-aktualne p');
$entries = array_slice($entries, 0, ENTRIES_LIMIT);

$feed = new Feed();
$channel = new Channel();
$channel
  ->title("DenníkN - Aktuálne")
  ->url('https://dennikn.sk')
  ->lastBuildDate(time())
  ->appendTo($feed);

foreach ($entries as $entry) {
  $time = $entry->find('strong',0)->plaintext;
  $pubdate = strtotime(preg_replace('/\d{2}:\d{2}:\d{2}/', $time.':00', date(DATE_RSS)));
  $text = preg_replace("/^[\d]{1,2}:[\d]{1,2}\s*&#8211;/i",'',$entry->plaintext);
  $guid = md5($text);
  if (!empty($time) && !empty($text)) {
    $item = new Item();
    $item
      ->title($time)
      ->description($text)
      ->url('https://dennikn.sk/'.$guid)
      ->guid($guid)
      ->pubDate($pubdate)
      ->appendTo($channel);
  }
}

file_put_contents('feed.xml', $feed->render());
