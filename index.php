<?php

require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('Unicorns');
$log->pushHandler(new StreamHandler('greetings.log', Logger::INFO));

//ini_set("allow_url_fopen", 1);

//$url = "http://unicorns.idioti.se/";
//$data = json_decode(file_get_contents($url), true);
//echo $data['name'];

//$returnInfo = file_get_contents("http://unicorns.idioti.se/3");

//$json = json_decode($returnInfo,true);

//$url = 'http://unicorns.idioti.se/';

/*$context = stream_context_create(array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-type: application/json',
        'header' => 'Accept: application/json',
        'timeout' => 60
    )
));*/

//$resp = file_get_contents($url, true, $context);
//print_r($resp);

//This is where i star using guzzle



//for ($i=0; $i < count($json); $i++) {
  //echo($json[$i]['name']);
//}

//echo($json[0]['name']);

//echo $json[6];

//$client = new \GuzzleHttp\Client();
//$res = $client->request('GET', 'Accept: application/json', 'http://unicorns.idioti.se/');

//echo $res->getHeaderLine('application/json; charset=utf8');

//$greeting = "Thank you!";
//$name = $_POST['name'];
//$age = $_POST['age'];
//$email = $_POST['email'];

//$name2 = $argv[1];

//"<div align='right'>" . "<button type='button' onclick='alert('Hello World!')'>Läs mer</button>" .
//"</div>"

//echo $json['name'];

//$log->info("Requested info about: " . );

?>

<!doctype html>
<html>
    <head>
        <title>Example form</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h1>Enhörningar</h1>
            <form action="index.php" method="get">
              <hr>
                <div class="form-group">
                    <label for="id">id för enhörning: </label>
                    <input type="number" id="id" name="id" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Visa enhörning" class="btn btn-success">
                    <a href="index.php" class="btn btn-primary">Visa alla enhörningar</a>
                </div>
              <hr>
              <?php
                if (isset($_GET['id']) && $_GET['id'] != NULL) {

                  $client = new \GuzzleHttp\Client();

                  $res = $client->request('GET', 'http://unicorns.idioti.se/' . $_GET['id'], [
                      'headers' => [
                          'Accept'     => 'application/json'
                      ]
                  ]);

                  $json = json_decode($res->getBody(), true);

                  $log->info("Requested info about: " . $json['name']);

                  //echo "<h1>" . $json['name'] . "</h1>" . "<br>";
                  //echo "<h1>" . "<i>" . $json['description'] . "</i>" . "</h1>" . "<br>";

                  $image = file_get_contents('http://unicorns.idioti.se/' . $_GET['id']);

                  echo $image;

                } else {
              ?>
              <h1>Alla enhörningar</h1>
              <p>
                  <?php
                  $client = new \GuzzleHttp\Client();

                  $res = $client->request('GET', 'http://unicorns.idioti.se/', [
                      'headers' => [
                          'Accept'     => 'application/json'
                      ]
                  ]);

                  $json = json_decode($res->getBody(), true);

                  $log->info("Requested info about all unicorns");

                  for ($i=0; $i < count($json) - 5; $i++) {
                    echo "<h3>" . ($json[$i]['id']) . ": " . ($json[$i]['name']) .
                    "<a href='index.php?id=".$json[$i]['id']."' class='btn btn-default' style='float:right;'>" . "Läs mer" . "</a>" .
                    "</h3>" . "<hr>";
                  } ?>

        			</p>

              <?php
              }
            ?>
            </form>
        </div>
    </body>
</html>
