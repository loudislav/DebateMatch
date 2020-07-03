<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Institution,
    DebateMatch\DataObject\Team;
use DebateMatch\DataObject\PreviousMatch;
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

    public function testAddPreviousMatchWon(): void
    {
        $institution = new Institution('Institution 1');
        $teamA = new Team('Team A', $institution);
        $teamB = new Team('Team B', $institution);
        $previousMatch = new PreviousMatch($teamA, $teamB, 1, true, true);
        $teamA->addPreviousMatch($previousMatch);

        self::assertSame(1, $teamA->getTotalWins());
        self::assertSame(3, $teamA->getTotalBallots());
    }

    public function testAddPreviousMatchLost(): void
    {
        $institution = new Institution('Institution 1');
        $teamA = new Team('Team A', $institution);
        $teamB = new Team('Team B', $institution);
        $previousMatch = new PreviousMatch($teamA, $teamB, 1, false, false);
        $teamA->addPreviousMatch($previousMatch);

        self::assertSame(0, $teamA->getTotalWins());
        self::assertSame(1, $teamA->getTotalBallots());
    }
}