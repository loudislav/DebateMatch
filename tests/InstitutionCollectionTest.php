<?php

declare(strict_types=1);

namespace DebateMatch\Tests;

use DebateMatch\DataObject\Institution,
    DebateMatch\DataObject\InstitutionCollection;
use PHPUnit\Framework\TestCase;

class InstitutionCollectionTest extends TestCase
{
    public function testAdd(): void
    {
        $institutionCollection = new InstitutionCollection();
        $institutionCollection->addInstitution(
            new Institution('Institution 1')
        );

        self::assertSame(1, count($institutionCollection->getAllInstitutions()));
    }
}