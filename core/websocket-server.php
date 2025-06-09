<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Workerman\Connection\TcpConnection;

$ws_worker = new Worker("websocket://0.0.0.0:3000");
$ws_worker->count = 1;

// Array to store all connections
$clients = [];

$ws_worker->onConnect = function (TcpConnection $connection) use (&$clients) {
    $clients[$connection->id] = $connection;
    echo "New connection: " . $connection->id . PHP_EOL;
};

$ws_worker->onMessage = function (TcpConnection $connection, $data) use (&$clients) {
    echo "Received from {$connection->id}: $data" . PHP_EOL;

    // Broadcast to all clients
    foreach ($clients as $client) {
        if ($client !== $connection) {
            $client->send("User {$connection->id} says: $data");
        }
    }
};

$ws_worker->onClose = function (TcpConnection $connection) use (&$clients) {
    unset($clients[$connection->id]);
    echo "Connection {$connection->id} closed" . PHP_EOL;
};

Worker::runAll();
// To run this script, use the command: php core/websocket-server.php
// Make sure you have installed the Workerman library via Composer:
// composer require workerman/workerman
// You can test the WebSocket server using a WebSocket client or a browser console.
// The server listens on port 3000 and can handle multiple connections.