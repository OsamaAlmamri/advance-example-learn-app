<?php

namespace Tests\Unit;

use App\AccountingHelper;
use PHPUnit\Framework\TestCase;

class AccountingTest extends TestCase
{

    /**
     *A test profit
     *
     * @return void
     */

    public function testItCanFindProfit(): void
    {
       $profit= AccountingHelper::findProfit(100);

       $this->assertEquals(10,$profit);
       $this->assertLessThan(100,$profit);

    }
}
