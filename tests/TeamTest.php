<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Institution,
    DebateMatch\DataObject\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testCreate(): void
    {
        $institution = new Institution('Institution 1');
        $team = new Team('Team A', $institution);

        self::assertSame('Team A', $team->getName());
        self::assertSame('Institution 1', $team->getInstitution()->getName());
    }
}