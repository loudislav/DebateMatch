<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Matrix;
use DebateMatch\Factory\TeamFactory;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
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
        $teams = array(
            $teamA,
            $teamB
        );
        $matrix = new Matrix($teams);
        $matrix = $matrix->getMatrix();

        self::assertNull($matrix[0][0]);
        self::assertSame('Team A', $matrix[0][1]['affirmative']->getName());
        self::assertSame('Team B', $matrix[0][1]['negative']->getName());
        self::assertSame('Team B', $matrix[1][0]['affirmative']->getName());
        self::assertSame('Team A', $matrix[1][0]['negative']->getName());
        self::assertNull($matrix[1][1]);
    }
}