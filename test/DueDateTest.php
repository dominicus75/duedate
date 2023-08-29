<?php declare(strict_types=1);

namespace Dominicus75\DueDate\Tests;

use Dominicus75\DueDate\DueDate;
use PHPUnit\Framework\TestCase;

class DueDateTest extends TestCase
{
    public function testConstructor()
    {
        $valid_params = [
            ['6:15:0', 12],
            ['7:0:0', 12],
            ['8:15:0', 8],
            ['8:0:0', 8],
            ['10:0:0', 6]            
        ];

        $invalid_params = [
            ['-2:15:0', 12],
            ['24:0:0', 12],
            ['8:60:0', 8],
            ['8:0:60', 8],
            ['25:61:76', 25]            
        ];

        foreach ($valid_params as $par) {
            $obj = new DueDate($par[0], $par[1]);
            $this->assertInstanceOf('Dominicus75\DueDate\DueDate', $obj);
        }

        foreach ($invalid_params as $par) {
            $obj = new DueDate($par[0], $par[1]);
            $this->assertInstanceOf('Dominicus75\DueDate\DueDate', $obj);
        }
    
    }

    public function testCalculateDueDateMethod() 
    {
        $obj = new DueDate();
        $this->assertInstanceOf('Dominicus75\DueDate\DueDate', $obj);

        $expected = (new \DateTimeImmutable())->add(new \DateInterval('P1D'));

        $result = $obj->calculateDueDate();
        $this->assertEquals(
            $expected->format('Y-m-d H:i:s'),
            $result->format('Y-m-d H:i:s')
        );

    }

}