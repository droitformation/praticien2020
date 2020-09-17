<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Goutte\Client;

class UtilityClassTest extends TestCase
{
    public function testIsPublication()
    {
        $dispatch = new \App\Praticien\Bger\Utility\Dispatch();

        $result = $dispatch->isPublication('Une categorie *');

        $this->assertTrue($result);
    }
}
