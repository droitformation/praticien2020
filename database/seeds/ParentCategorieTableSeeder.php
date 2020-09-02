<?php

use Illuminate\Database\Seeder;

class ParentCategorieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('parent_categories')->truncate();

        $parent_categories = array(
            array('id' => '1', 'rang' => 0, 'nom' => 'Économie'),
            array('id' => '2', 'rang' => 0, 'nom' => 'Instruction et formation professionnelle'),
            array('id' => '3', 'rang' => 0, 'nom' => 'Procédure'),
            array('id' => '4', 'rang' => 0, 'nom' => 'Média'),
            array('id' => '6', 'rang' => 0, 'nom' => 'Responsabilité de l\'État'),
            array('id' => '7', 'rang' => 0, 'nom' => 'Santé & sécurité sociale'),
            array('id' => '8', 'rang' => 0, 'nom' => 'Droit constitutionnel'),
            array('id' => '9', 'rang' => 0, 'nom' => 'Droit des poursuites et faillites'),
            array('id' => '10','rang' => 0, 'nom' => 'Finances publiques & droit fiscal'),
            array('id' => '11','rang' => 0, 'nom' => 'Droit pénal'),
            array('id' => '12','rang' => 0, 'nom' => 'Droit de cité et droit des étrangers'),
            array('id' => '13','rang' => 0, 'nom' => 'Propriété intellectuelle'),
            array('id' => '14','rang' => 0, 'nom' => 'Droit privé'),
            array('id' => '15','rang' => 0, 'nom' => 'Droit administratif'),
            array('id' => '16','rang' => 0, 'nom' => 'Assurances sociales'),
            array('id' => '17','rang' => 0, 'nom' => 'Énergie'),
            array('id' => '18','rang' => 0, 'nom' => 'Droit des obligations'),
            array('id' => '19','rang' => 0, 'nom' => 'Droit de l\'avocat'),
            array('id' => '20','rang' => 0, 'nom' => 'Juridiction arbitrale'),
            array('id' => '21','rang' => 0, 'nom' => 'Droit commercial'),
            array('id' => '23','rang' => 0, 'nom' => 'Art et culture'),
            array('id' => '24','rang' => 0, 'nom' => 'Poste et télécommunications'),
            array('id' => '25','rang' => 1, 'nom' => 'Général'),
        );

        \DB::table('parent_categories')->insert($parent_categories);
    }
}
