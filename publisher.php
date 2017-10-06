<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

define("CHANNEL_NAME", "hello");
define("RABBITMQ_BIGWIG_TX_URL", getenv("RABBITMQ_BIGWIG_TX_URL"));

$connection = connectRabbitMQ();
$channel = setupRabbitMQ($connection);

$body = json_encode(Array(
    "id" => ceil(microtime(true)*1000),
    "body" => "Hello World" . time()
));
$msg = new AMQPMessage($body);
$channel->basic_publish($msg, '', CHANNEL_NAME);

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

function connectRabbitMQ() {
    $url = parse_url(RABBITMQ_BIGWIG_TX_URL);
    $connection = new AMQPStreamConnection($url["host"], $url["port"], $url["user"],
        $url["pass"], substr($url["path"], 1));
    return $connection;
}

function setupRabbitMQ($connection) {
    $channel = $connection->channel();
    $channel->queue_declare(CHANNEL_NAME, false, false, false, false);
    return $channel;
}