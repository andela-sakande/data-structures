<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use React\EventLoop\Factory;
use Rx\Scheduler;

$loop = Factory::create();

//You only need to set the default scheduler once
Scheduler::setDefaultFactory(function() use($loop){
    return new Scheduler\EventLoopScheduler($loop);
});

$fruits = ['apple', 'banana', 'orange', 'raspberry'];

$observer = new \Rx\Observer\CallbackObserver(function($value) {
    printf("%s\n", $value);
}, null, function() {
    print("Complete\n");
});

\Rx\Observable::fromArray($fruits)
    ->map(function($value) {
        return strlen($value);
    })
    ->subscribe($observer);

$loop->run();
