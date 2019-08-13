<?php

require_once 'libs/TwitterAPIExchange.php';
require_once 'class/connection.php';

$credentials = include 'includes/config.php';

$hashtags = $_GET['hashtags'];
$strings = explode(",",$hashtags);

$query = "#" . $hashtags;
if (count($strings) > 1) {
  $query = "#" . str_replace(",", "+OR+#",$hashtags);
}

$settings = array(
    'oauth_access_token' => "{$credentials['api-twitter']['oauth_access_token']}",
    'oauth_access_token_secret' => "{$credentials['api-twitter']['oauth_access_token_secret']}",
    'consumer_key' => "{$credentials['api-twitter']['consumer_key']}",
    'consumer_secret' => "{$credentials['api-twitter']['consumer_secret']}"
);

$url = "https://api.twitter.com/1.1/search/tweets.json";
$getfield = "?q={$query}&count=1000&result_type=recent";
$requestMethod = "GET";

$twitter = new TwitterAPIExchange($settings);
$json = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
$twitters = json_decode($json);

$prepare = array();
foreach ($twitters->statuses as $item) {
  $prepare[] = array(
		'name' => $item->user->name,
		'screen_name' => $item->user->screen_name,
		'followers_count' => $item->user->followers_count
             ); 
}

$connection = new Connection();

$sql = $connection->prepare($prepare);
$result = $connection->save($sql);

if ($result == 1) {
  $items = $connection->getList();
  echo "<table>";
  echo "<tr><td>Nome</td><td>Usuário</td><td>Seguidores</td></tr>";  
  foreach ($items as $item) {
    echo "<tr><td>{$item['name']}</td><td>{$item['screen_name']}</td><td>{$item['followers_count']}</td></tr>";
  }
  echo "</table>";
  exit;
}
die('Error: ' . print_r($result));
