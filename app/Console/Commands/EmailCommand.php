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
        $body = "";
        $date = Carbon::now();
        $order_items = Order_item::all();
        log::info("entro a email send");
        log::info($order_items);
        foreach ($order_items as $order_item) {
            log::info($order_item['date']);
            if(Carbon::parse($order_item['date'])->diffInDays() <= 1){
                $body = $body . "Order ID: " . $Order_item->order->id . "-- Item ID: " . $Order_item->item->id . "\n  ";
            }
        }
        if ($body <> ""){
            $users = User::whereIn('type', ['asistente','director', 'bodega'])->get();
            Log::info($users);
            if ($users){
                foreach ($users as $user) {
                    $message = ['data' => $body];
                    Mail::send('emails.message', $message, function($message) use ($user)
                   {
                       //asunto
                       $message->subject("sin asunto");
             
                       //receptor
                       $message->to($user -> email);
             
                   });
                }  
            }
            
            
        }
    }
}
