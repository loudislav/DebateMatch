<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Institution,
    DebateMatch\Factory\TeamFactory;
use PHPUnit\Framework\TestCase;

class TeamFactoryTest extends TestCase
{
    public function testCreate(): void
    {;
        $testData = array(
            'name' => 'Team A',
            'institutionName' => 'Institution 1'
        );
        $factory = new TeamFactory();
        $team = $factory->create($testData);

        self::assertSame('Team A', $team->getName());
        self::assertSame('Institution 1', $team->getInstitution()->getName());
    }

    public function testCreateTwo(): void
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
        $factory->create($testDataA);
        $factory->create($testDataB);

        self::assertSame(1, count($factory->getInstitutionCollection()->getAllInstitutions()));
    }

    public function testCreateTwoDifferentInstitutions(): void
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
        $factory->create($testDataA);
        $factory->create($testDataB);

        self::assertSame(2, count($factory->getInstitutionCollection()->getAllInstitutions()));
    }
}