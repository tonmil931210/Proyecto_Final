<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Item_type;
use App\Order_status;
use App\Event;
use App\Item;
use App\Order_item;
use App\Order;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([                
                'name' => 'admin',
                'email' =>'admin@admin.com',
                'password' =>123456,
                'type' => 'admin'
            ]);
        User::create([                
                'name' => 'gerente',
                'email' =>'mcasanova@uninorte.edu.co',
                'password' =>123456,
                'type' => 'gerente'
            ]);
       User::create([                
                'name' => 'director',
                'email' =>'milton931210@gmail.com',
                'password' =>123456,
                'type' => 'director'
            ]);
       User::create([                
                'name' => 'bodega',
                'email' =>'tonmil.sorkerf@gmail.com',
                'password' =>123456,
                'type' => 'bodega'
            ]);
        Item_type::create([                
                'name' => 'Retornable'
            ]);
        Item_type::create([                
                'name' => 'No retornable'
            ]);
        Order_status::create([                
                'name' => 'Pendiente'
            ]);
        Order_status::create([                
                'name' => 'Rechazado'
            ]);
        Order_status::create([                
                'name' => 'Aprobado'
            ]);
        Order_status::create([                
                'name' => 'Entregado'
            ]);
        Order_status::create([                
                'name' => 'Cancelado'
            ]);

        Event::create([                
                'name' => 'Feria pop',
                'start_date' => '2016-09-27',
                'finish_date' => '2016-09-30',
                'start_time' => '4:32:00',
                'finish_time' => '6:30:00',
                'location' => 'Kilometro 5',
                'place' => 'Uninorte'
            ]);
        Item::create([                
                'name' => 'libreta',
                'price' => '1000',
                'item_type_id' => '1',
                'number' => '30',
                'reorder' => '10',
                'min_stock' => '5',
            ]);
        Item::create([                
                'name' => 'pañoleta',
                'price' => '999',
                'item_type_id' => '2',
                'number' => '50',
                'reorder' => '15',
                'min_stock' => '10',
            ]);
        Order_item::create([                
                'item_id' => '1',
                'order_id' => '1',
                'number' => '2',
                'number_return' => '0',
                'state' => 'pendiente',
                'date' => '1992-12-12',
            ]);
        Order::create([                
                'event_id' => '1',
                'order_status_id' => '1',
                'user_id' => '1',
                'name_client' => 'milton',
                'type' => 'retornable'
            ]);
    }
}
