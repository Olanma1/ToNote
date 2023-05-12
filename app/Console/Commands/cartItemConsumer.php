<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Contracts\KafkaConsumerMessage;


class cartItemConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cart-item-consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Kafka::createConsumer()->subscribe("cartItem")->withHandler(function(KafkaConsumerMessage $message){

            $body = $message->getBody();
            echo $body["userId"]["productId"];
        })->build()->consume();
    }
}
