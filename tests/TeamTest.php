<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Institution,
    DebateMatch\DataObject\PreviousMatch,
    DebateMatch\DataObject\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    protected $teamA;
    protected $teamB;

    protected function setUp(): void
    {
        $institution = new Institution('Institution 1');
        $this->teamA = new Team('Team A', $institution);
        $this->teamB = new Team('Team B', $institution);
    }

    public function testCreate(): void
    {
        self::assertSame('Team A', $this->teamA->getName());
        self::assertSame('Institution 1', $this->teamA->getInstitution()->getName());
    }

    public function testAddPreviousMatchWon(): void
    {
        $previousMatch = new PreviousMatch($this->teamA, $this->teamB, 1, true, true);
        $this->teamA->addPreviousMatch($previousMatch);

        self::assertSame(1, $this->teamA->getTotalWins());
        self::assertSame(3, $this->teamA->getTotalBallots());
    }

    public function testAddPreviousMatchLost(): void
    {
        $previousMatch = new PreviousMatch($this->teamA, $this->teamB, 1, false, false);
        $this->teamA->addPreviousMatch($previousMatch);

        self::assertSame(0, $this->teamA->getTotalWins());
        self::assertSame(1, $this->teamA->getTotalBallots());
    }

    public function testHaveMetBefore(): void
    {
        $previousMatch = new PreviousMatch($this->teamA, $this->teamB, 1, true, true);
        $this->teamA->addPreviousMatch($previousMatch);

        self::assertTrue($this->teamA->haveMetTeamBefore($this->teamB));
    }

    public function testHaveNotMetBefore(): void
    {
        self::assertFalse($this->teamA->haveMetTeamBefore($this->teamB));
    }

    public function testWasSideBeforeAffirmative(): void
    {
        $previousMatch = new PreviousMatch($this->teamA, $this->teamB, 1, true, true);
        $this->teamA->addPreviousMatch($previousMatch);

        self::assertTrue($this->teamA->wasSideBefore(1, true));
    }

    public function testWasSideBeforeNegative(): void
    {
        $previousMatch = new PreviousMatch($this->teamA, $this->teamB, 1, true, true);
        $this->teamB->addPreviousMatch($previousMatch);

        self::assertTrue($this->teamB->wasSideBefore(1, false));
    }

    public function testWasNotSideBefore(): void
    {
        self::assertFalse($this->teamA->wasSideBefore(1, true));
    }

    public function testWasOtherSideBefore(): void
    {
        $previousMatch = new PreviousMatch($this->teamA, $this->teamB, 1, true, true);
        $this->teamA->addPreviousMatch($previousMatch);

        self::assertFalse($this->teamA->wasSideBefore(1, false));
    }
}