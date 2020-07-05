<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\Factory\TeamFactory,
    DebateMatch\RatingCalculator;
use PHPUnit\Framework\TestCase;

class RatingCalculatorTest extends TestCase
{
    protected $teamFactory;
    protected $ratingCalculator;
    protected $teamA;
    protected $teamB;
    protected $teamC;

    protected function setUp(): void
    {
        $testDataA = array(
            'name' => 'Team A',
            'institutionName' => 'Institution 1'
        );
        $testDataB = array(
            'name' => 'Team B',
            'institutionName' => 'Institution 1',
            'previousMatches' => array(
                array(
                    'affirmative' => 'Team A',
                    'negative' => 'Team B',
                    'roundNumber' => 1,
                    'affirmativeWinner' => true,
                    'unanimousResult' => true
                )
            )
        );
        $testDataC = array(
            'name' => 'Team C',
            'institutionName' => 'Institution 2'
        );

        $this->teamFactory = new TeamFactory();
        $this->teamA = $this->teamFactory->create($testDataA);
        $this->teamB = $this->teamFactory->create($testDataB);
        $this->teamC = $this->teamFactory->create($testDataC);
        $this->ratingCalculator = new RatingCalculator();
    }

    public function testCalculateRound1DifferentInstitutions(): void
    {
        $rating = $this->ratingCalculator->calculate($this->teamA, $this->teamC);

        self::assertSame(0, $rating);
    }

    public function testCalculateRound1SameInstitutions(): void
    {
        $rating = $this->ratingCalculator->calculate($this->teamA, $this->teamB);

        self::assertSame(1, $rating);
    }

    public function testCalculateRound2BothWinners(): void
    {
        $previousMatchA = array(
            array(
                'affirmative' => 'Team A',
                'negative' => 'Team B',
                'roundNumber' => 1,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            )
        );
        $previousMatchC = array(
            array(
                'affirmative' => 'Team C',
                'negative' => 'Team B',
                'roundNumber' => 1,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            )
        );

        $this->teamFactory->addPreviousMatches($previousMatchA, $this->teamA);
        $this->teamFactory->addPreviousMatches($previousMatchC, $this->teamC);
        $rating = $this->ratingCalculator->calculate($this->teamA, $this->teamC);

        self::assertSame(0, $rating);
    }

    public function testCalculateRound2WinnerLoser(): void
    {
        $previousMatchA = array(
            array(
                'affirmative' => 'Team A',
                'negative' => 'Team B',
                'roundNumber' => 1,
                'affirmativeWinner' => false,
                'unanimousResult' => true
            )
        );
        $previousMatchC = array(
            array(
                'affirmative' => 'Team C',
                'negative' => 'Team B',
                'roundNumber' => 1,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            )
        );

        $this->teamFactory->addPreviousMatches($previousMatchA, $this->teamA);
        $this->teamFactory->addPreviousMatches($previousMatchC, $this->teamC);
        $rating = $this->ratingCalculator->calculate($this->teamA, $this->teamC);

        self::assertSame(5, $rating);
    }
}