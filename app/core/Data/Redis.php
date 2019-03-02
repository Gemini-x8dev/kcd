<?php

namespace HCM\Data;

use RedisClient\ClientFactory;

class Redis
{
    public function addVisits()
    {


// Example 1. Create new Instance for Redis version 2.8.x with config via factory
        $Redis = ClientFactory::create([
            'server' => 'redis:6379', // or 'unix:///tmp/redis.sock'
            'timeout' => 2,
            'version' => '2.8.24'
        ]);

        $Redis->set('host', $_SERVER['HTTP_HOST']);
        $visits = $Redis->get('visits');
        $Redis->set('visits', intval($visits) + 1);
        echo "<br><br>From Redis: {$Redis->get('host')} was visited {$Redis->get('visits')} times<br><br>";
    }
}