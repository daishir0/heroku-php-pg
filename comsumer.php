<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
//Predis\Autoloader::register();

define("CHANNEL_NAME", "hello");
define("RABBITMQ_BIGWIG_RX_URL", getenv("RABBITMQ_BIGWIG_RX_URL"));
//define("REDISTOGO_URL", getenv("REDISTOGO_URL"));

$channel = setupRabbitMQ();
//$client = setupRedis();
echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
  //global $client;
  require '09-output-and-download(giin)3000data-pdf.php';
  var_dump(json_decode($msg->body));
  $body = json_decode($msg->body);
  //$val = $client->set($body->id, $body->body);
};

$channel->basic_consume(CHANNEL_NAME, '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

function setupRabbitMQ() {
    $url = parse_url(RABBITMQ_BIGWIG_RX_URL);
    $connection = new AMQPStreamConnection($url["host"], $url["port"], $url["user"],
        $url["pass"], substr($url["path"], 1));
    $channel = $connection->channel();
    $channel->queue_declare(CHANNEL_NAME, false, false, false, false);
    return $channel;
}

/*
function setupRedis() {
    $url = parse_url(REDISTOGO_URL);

    // Named array of connection parameters:
    return new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $url['host'],
        'password'   => $url['pass'],
        'port'   => $url['port'],
    ]);
}
*/