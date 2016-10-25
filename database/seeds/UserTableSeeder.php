<?php

use CodeDelivery\Models\Client;
use CodeDelivery\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class)->create(
            [
                'name' => 'client',
                'email' => 'client@client.com.br',
                'password' => bcrypt('123456'),
            ]
        )->client()->save(factory(Client::class)->make());;

        factory(User::class)->create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.com.br',
                'password' => bcrypt('123456'),
                'role' => 'admin'
            ]
        )->client()->save(factory(Client::class)->make());

        factory(User::class, 3)->create(
            [
                'role' => 'deliveryman'
            ]
        );

        factory(User::class, 10)->create()->each(function($u) {
            $u->client()->save(factory(Client::class)->make());
        });

    }
}
