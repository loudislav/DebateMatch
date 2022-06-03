<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\ProposedGame,
    DebateMatch\Factory\TeamFactory,
    DebateMatch\DataObject\RoundMatching;
use PHPUnit\Framework\TestCase;

class RoundMatchingTest extends TestCase
{
    public function testCreate(): void
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

        $match = new ProposedGame($teamA, $teamB);
        $roundMatching = new RoundMatching(array($match));

        self::assertSame(1, count($roundMatching->getAllMatches()));
        self::assertIsInt($roundMatching->getTotalRating());
    }

    public function testIsComplete()
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

        $match = new ProposedGame($teamA, $teamB);
        $roundMatching = new RoundMatching(array($match));

        self::assertTrue($roundMatching->isComplete(2));
    }

    public function testIsInComplete()
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

        $match = new ProposedGame($teamA, $teamB);
        $roundMatching = new RoundMatching(array($match));

        self::assertFalse($roundMatching->isComplete(4));
    }
}