<?php

namespace IRMessage\Tests;

use PHPUnit\Framework\TestCase;


class IPPanelDriverTest extends TestCase
{
    public function test_ippanel_token(): void
    {
        $token = env('IPPANEL_TOKEN', null);

        $this->assertNotNull($token, 'IPPANEL_TOKEN environment value is not set. all tests must be failed');
    }
}