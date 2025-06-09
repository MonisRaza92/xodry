<?php
require __DIR__.'/../vendor/autoload.php';

use Workerman\Worker;
use Workerman\Timer;
use Predis\Client as Redis;

// Redis client
$redis = new Redis();

// MySQL
$pdo = new PDO("mysql:host=localhost;dbname=xodry", "root", "");

// Background Worker
$worker = new Worker();
$worker->onWorkerStart = function () use ($redis, $pdo) {
    Timer::add(5, function () use ($redis, $pdo) {
        while ($json = $redis->rpop('notifications_queue')) {
            $notif = json_decode($json, true);
            if (!$notif) continue;

            $userId = str_replace('user_', '', $notif['to']);
            $message = $notif['message'];
            $timestamp = date('Y-m-d H:i:s', $notif['timestamp']);

            $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $message, $timestamp]);
        }
    });
};

Worker::runAll();
