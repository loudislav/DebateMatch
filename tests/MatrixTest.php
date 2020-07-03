<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Matrix,
    DebateMatch\Factory\TeamFactory;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    protected $teams;

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
        $factory = new TeamFactory();
        $teamA = $factory->create($testDataA);
        $teamB = $factory->create($testDataB);
        $this->teams = array(
            $teamA,
            $teamB
        );
    }

    public function testCreate(): void
    {
        $matrix = new Matrix($this->teams);
        $matrix = $matrix->getMatrix();

        self::assertNull($matrix[0][0]);
        self::assertSame('Team A', $matrix[0][1]->getAffirmative()->getName());
        self::assertSame('Team B', $matrix[0][1]->getNegative()->getName());
        self::assertSame('Team B', $matrix[1][0]->getAffirmative()->getName());
        self::assertSame('Team A', $matrix[1][0]->getNegative()->getName());
        self::assertNull($matrix[1][1]);
    }

    public function testGetList(): void
    {
        $matrix = new Matrix($this->teams);
        $list = $matrix->getList();

        self::assertSame(2, count($list));
        self::assertContainsOnlyInstancesOf('DebateMatch\DataObject\ProposedMatch', $list);
    }
}