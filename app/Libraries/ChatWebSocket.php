<?php

namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatWebSocket implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        echo "WebSocket Chat Server Started\n";
    }

    // User connect ஆனபோது
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "New Connection: {$conn->resourceId}\n";
    }

    // Message வந்தபோது
    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Message received: $msg\n";

        foreach ($this->clients as $client) {

            // sender தவிர மற்ற users க்கு send
            if ($from !== $client) {
                $client->send($msg);
            }

        }
    }

    // User disconnect
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} closed\n";
    }

    // Error handle
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}