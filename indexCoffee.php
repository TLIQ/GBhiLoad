<?php

  require_once('vendor/autoload.php');
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  use PhpAmqpLib\Connection\AMQPStreamConnection;
  use PhpAmqpLib\Exception\AMQPProtocolChannelException;
  use PhpAmqpLib\Message\AMQPMessage;



  $connection = new AMQPConnection();
  $connection->setHost('127.0.0.1');
  $connection->setLogin('guest');
  $connection->setPassword('guest');
  $connection->connect();


  $channel = new AMQPChannel($connection);

  AMQPQueueCreate($channel, 'order_cofee');
  AMQPQueueCreate($channel, 'payment_waiting');
  AMQPQueueCreate($channel, 'payment_confirm');
  AMQPQueueCreate($channel, 'prepared');
  AMQPQueueCreate($channel, 'delivery');
  AMQPQueueCreate($channel, 'ask_feedback');

    
  function AMQPQueueCreate(AMQPChannel $channel, string $name)
  {
    try {
    $queue = new AMQPQueue($channel);
    $queue->setName($name);
    $queue->setFlags(AMQP_DURABLE);
    $queue->declareQueue();
  } catch (Exception $ex) {
    print_r($ex);
  }
  }
?>
