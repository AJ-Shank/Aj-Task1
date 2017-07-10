<?php

use Illuminate\Database\Seeder;

use App\User;

use App\profile;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Eloquent::unguard();

      // call our class and run our seeds
      $this->call('Task1Seeder');
      $this->command->info('Task 1 seeds finished.'); // show information in the command line after everything is run
    }
}
// our own seeder class
// usually this would be its own file
class Task1Seeder extends Seeder {

    public function run() {

        // clear our database ------------------------------------------
        DB::table('profiles')->delete();
        DB::table('users')->delete();


        $bearLawly = User::create(array(
            'name'         => 'Lawly',
            'email'         => 'Grizzly@123',
        ));

        $bearCerms = User::create(array(
            'name'         => 'Cerms',
            'email'         => 'Black@123',
        ));

        $bearAdobot = User::create(array(
            'name'         => 'Adobot',
            'email'         => 'Polar@123',
        ));

        $this->command->info('details done');

        // seed our fish table ------------------------
        // our fish wont have names... because theyre going to be eaten

        // we will use the variables we used to create the bears to get their id

        Profile::create(array(
            'age'  => 21,
            'id' => $bearLawly->id,
            'DOB' => '1995-10-11'
        ));
        Profile::create(array(
            'age'  => 12,
            'id' => $bearCerms->id,
            'DOB' => '2000-01-31'
        ));
        Profile::create(array(
            'age'  => 4,
            'id' => $bearAdobot->id,
            'DOB' => '1955-10-19'
        ));

        $this->command->info('profile DOne');

    }

}
