<?php
/**
 * Created by PhpStorm.
 * User: phucvo
 * Date: 3/5/19
 * Time: 2:32 PM.
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class WelcomeTest extends TestCase
{
    public function testWarmup()
    {
        $this->assertEquals('hello', 'hello');
    }
}
