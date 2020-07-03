<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\Factory\TeamFactory,
    DebateMatch\DataObject\ProposedMatch;
use PHPUnit\Framework\TestCase;

class ProposedMatchTest extends TestCase
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

        $match = new ProposedMatch($teamA, $teamB);

        self::assertSame('Team A', $match->getAffirmative()->getName());
        self::assertSame('Team B', $match->getNegative()->getName());
        self::assertIsInt($match->getRating());
    }
}