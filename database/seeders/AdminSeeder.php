<?php

namespace Database\Seeders;

use App\Models\Accounts;
use App\Models\AccountTypes;
use App\Models\LoginTypes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        if(empty(LoginTypes::get()->toArray())){
            LoginTypes::create(['type' => 'admin']);
            LoginTypes::create(['type' => 'donor']);
            LoginTypes::create(['type' => 'refer']);
            LoginTypes::create(['type' => 'manager']);
            LoginTypes::create(['type' => 'substitute']);
            LoginTypes::create(['type' => 'volunteers']);
            LoginTypes::create(['type' => 'vendor']);
        }



        $account = Accounts::where('email', 'admin@admin.com')->get()->first();
        if(empty($account)){
            $account = Accounts::create([
                'user_name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456789'),
                'status' => '1',
            ]);
            $account->syncRoles(['administrator']);
            AccountTypes::create([
                'account_id' =>  $account->id,
                'type_id' => 1,
            ]);
        }
    }

}
  