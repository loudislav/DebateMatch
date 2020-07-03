<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\Factory\TeamFactory,
    DebateMatch\RatingCalculator;
use PHPUnit\Framework\TestCase;

class RatingCalculatorTest extends TestCase
{
    public function testCalculateRound1DifferentInstitutions(): void
    {
        $testDataA = array(
            'name' => 'Team A',
            'institutionName' => 'Institution 1'
        );
        $testDataB = array(
            'name' => 'Team B',
            'institutionName' => 'Institution 2'
        );
        $factory = new TeamFactory();
        $teamA = $factory->create($testDataA);
        $teamB = $factory->create($testDataB);
        $ratingCalculator = new RatingCalculator();

        $rating = $ratingCalculator->calculate($teamA, $teamB);

        self::assertSame(0, $rating);
    }

    public function testCalculateRound1SameInstitutions(): void
    {
        $testDataA = array(
            'name' => 'Team A',
            'institutionName' => 'Institution 1'
        );
        $testDataB = array(
            'name' => 'Team B',
            'institutionName' => 'Institution 1'
        );
        $factory = new TeamFactory();
        $teamA = $factory->create($testDataA);
        $teamB = $factory->create($testDataB);
        $ratingCalculator = new RatingCalculator();

        $rating = $ratingCalculator->calculate($teamA, $teamB);

        self::assertSame(1, $rating);
    }

    // TODO: testCalculateRound2BothWinners & testCalculateRound2WinnerLoser
    // TODO: testRepeatSide
}