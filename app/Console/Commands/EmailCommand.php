<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order_item;
use App\Item;
use App\Order;
use Mail;
class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $order_items = Order_item::all();
        foreach ($order_items as $order_item) {
              

        }  
    }
}
