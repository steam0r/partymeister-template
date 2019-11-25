<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MotorBackendDatabaseSeeder::class,
            MotorMediaDatabaseSeeder::class,
//            MotorCMSDatabaseSeeder::class,
            PartymeisterAccountingDatabaseSeeder::class,
            PartymeisterCoreDatabaseSeeder::class,
            PartymeisterCompetitionsDatabaseSeeder::class,
            PartymeisterSlidesDatabaseSeeder::class,
            PartymeisterFrontendDatabaseSeeder::class,
        ]);
    }
}
