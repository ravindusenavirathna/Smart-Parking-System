<?php
require __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;
use MongoDB\Driver\ServerApi;

$uri = 'mongodb+srv://user:Fo3KGESGOd7hFHvp@maincluster.rydkq.mongodb.net/?retryWrites=true&w=majority&appName=mainCluster';

$apiVersion = new ServerApi(ServerApi::V1);

$client = new Client($uri, [], ['serverApi' => $apiVersion]);

try {
    $client->selectDatabase('admin')->command(['ping' => 1]);
    echo "Pinged your deployment. You successfully connected to MongoDB!\n";
} catch (Exception $e) {
    printf($e->getMessage());
}
