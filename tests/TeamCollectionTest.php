<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Institution,
    DebateMatch\DataObject\Team,
    DebateMatch\DataObject\TeamCollection;
use PHPUnit\Framework\TestCase;

class TeamCollectionTest extends TestCase
{
    public function testAdd(): void
    {
        $team = new Team ('Team A', new Institution('Institution 1'));
        $teamCollection = new TeamCollection();
        $teamCollection->addTeam($team);

        self::assertSame(1, count($teamCollection->getAllTeams()));
    }

    public function testGetByName(): void
    {
        $team = new Team ('Team A', new Institution('Institution 1'));
        $teamCollection = new TeamCollection();
        $teamCollection->addTeam($team);

        self::assertSame($team, $teamCollection->getTeamByName('Team A'));
    }
}