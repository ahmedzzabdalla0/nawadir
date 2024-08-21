<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//        DB::statement('ALTER TABLE `users_addresses` ADD `country_id` INT NOT NULL DEFAULT \'2\' AFTER `gov_id`;');
//        DB::statement('ALTER TABLE `countries` ADD `status` INT NOT NULL DEFAULT \'1\' AFTER `accept_prefix`;');
//        DB::statement('ALTER TABLE `countries` ADD `tax` DECIMAL NOT NULL DEFAULT \'0\' AFTER `status`;');
//        DB::statement('UPDATE `countries` SET `flag` = \'1579082661_728476703.jpeg\' WHERE `countries`.`id` = 2;');
    }
}
