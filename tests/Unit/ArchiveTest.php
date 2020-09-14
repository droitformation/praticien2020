<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArchiveTest extends TestCase
{
    public function testArchiveYear()
    {
        $decision1 = factory(\App\Praticien\Decision\Entities\Decision::class)->create(['numero' => '4A_123/2017', 'categorie_id' => 174,'publication_at' => \Carbon\Carbon::today()]);
        $decision2 = factory(\App\Praticien\Decision\Entities\Decision::class)->create(['numero' => '5A_23/2019', 'categorie_id' => 175,'publication_at' => \Carbon\Carbon::today()->addDay(1)]);

        $table = new \App\Praticien\Bger\Utility\Table();

        // Make archives
        $table->mainTable  = 'decisions';
        $table->connection = 'test';

        $table->setYear('2020')->canTransfert()->create()->transfertArchives();
        $table->deleteLastYear();

        $results = \DB::connection('test')->table('archive_2020')->whereYear('publication_at', 2020)->count();

        $this->assertEquals(2,$results);
    }
}
