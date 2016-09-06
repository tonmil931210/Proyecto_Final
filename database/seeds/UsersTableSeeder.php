<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Item_type;
use App\Order_status;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([                
                'name' => 'admin',
                'email' =>'m112@d.com',
                'password' =>123456,
                'type' => 'admin'
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
    }
}
