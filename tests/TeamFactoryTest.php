<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\Factory\TeamFactory;
use PHPUnit\Framework\TestCase;

class TeamFactoryTest extends TestCase
{
    protected $teamFactory;
    protected $teamA;
    protected $teamB;

    protected function setUp(): void
    {
        $testDataA = array(
            'name' => 'Team A',
            'institutionName' => 'Institution 1'
        );
        $testDataB = array(
            'name' => 'Team B',
            'institutionName' => 'Institution 1'
        );
        $this->teamFactory = new TeamFactory();
        $this->teamA = $this->teamFactory->create($testDataA);
        $this->teamB = $this->teamFactory->create($testDataB);
    }

    public function testCreate(): void
    {
        self::assertSame('Team A', $this->teamA->getName());
        self::assertSame('Institution 1', $this->teamA->getInstitution()->getName());
    }

    public function testCreateTwoSamInstitution(): void
    {
        self::assertSame(1, count($this->teamFactory->getInstitutionCollection()->getAllInstitutions()));
    }

    public function testCreateTwoDifferentInstitutions(): void
    {
        $testDataC = array(
            'name' => 'Team C',
            'institutionName' => 'Institution 2'
        );
        $this->teamFactory->create($testDataC);

        self::assertSame(2, count($this->teamFactory->getInstitutionCollection()->getAllInstitutions()));
    }

    public function testAddPreviousMatch(): void
    {
        $previousMatch = array(
            array(
                'affirmative' => 'Team A',
                'negative' => 'Team B',
                'roundNumber' => 1,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            )
        );
        $this->teamFactory->addPreviousMatches($previousMatch, $this->teamA);

        self::assertSame(1, $this->teamA->getTotalWins());
        self::assertSame(3, $this->teamA->getTotalBallots());
    }

    public function testAddPreviousMatches(): void
    {
        $previousMatch = array(
            array(
                'affirmative' => 'Team A',
                'negative' => 'Team B',
                'roundNumber' => 1,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            ),
            array(
                'affirmative' => 'Team A',
                'negative' => 'Team B',
                'roundNumber' => 2,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            )
        );
        $this->teamFactory->addPreviousMatches($previousMatch, $this->teamA);

        self::assertSame(2, $this->teamA->getTotalWins());
        self::assertSame(6, $this->teamA->getTotalBallots());
    }
}