<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Order_item;
use App\Item;
use App\Order;
use Carbon\Carbon;
use Mail;
use Log;
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
        $data = 0;
        $date = Carbon::now();
        $order_items = Order_item::all();
        log::info("entro a email send");
        log::info($order_items);
        foreach ($order_items as $order_item) {
            log::info($order_item['date']);
            if(Carbon::parse($order_item['date'])->diffInDays() <= 1){
                $data = $data + 1;
            }
        }  
        $all_data = array('data' => $data);
        Mail::send('emails.message', $all_data, function($message)
       {
           //asunto
           $message->subject("test");
 
           //receptor
           $message->to("mcasanova@uninorte.edu.co");
 
       });
    }
}
