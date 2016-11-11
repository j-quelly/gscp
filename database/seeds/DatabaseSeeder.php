<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	Model::unguard();

    	$this->call('UserTableSeeder');
    	$this->call(BooksTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call('PermissionTableSeeder');
        $this->call('PermissionRoleTableSeeder');
        $this->call('RoleUserTableSeeder');

    	Model::reguard();
        
    }
}
