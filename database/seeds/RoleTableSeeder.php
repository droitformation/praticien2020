<?php

class RoleTableSeeder extends \Illuminate\Database\Seeder  {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('roles')->truncate();

		$roles = array(
			['name' => 'Administrateur', 'description' => 'Administrateur backend'],
            ['name' => 'Contributeur', 'description' => 'Contributeur aux articles'],
			['name' => 'Abonné', 'description' => 'Abonné au Droit pour le Praticien']
		);

		// Uncomment the below to run the seeder
		DB::table('roles')->insert($roles);
	}

}
