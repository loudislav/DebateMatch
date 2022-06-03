<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\PreviousGame,
    DebateMatch\Factory\TeamFactory;
use PHPUnit\Framework\TestCase;

class PreviousMatchTest extends TestCase
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

        $match = new PreviousGame($teamA, $teamB, 1, true, true);

        self::assertSame('Team A', $match->getAffirmative()->getName());
        self::assertSame('Team B', $match->getNegative()->getName());
        self::assertSame(1, $match->getRoundNumber());
        self::assertTrue($match->getAffirmativeWinner());
        self::assertTrue($match->getUnanimousResult());
    }
}