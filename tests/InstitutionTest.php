<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Institution;
use PHPUnit\Framework\TestCase;

class InstitutionTest extends TestCase
{
    public function testCreate(): void
    {
        $institution = new Institution('Institution 1');

        self::assertSame('Institution 1', $institution->getName());
    }
}