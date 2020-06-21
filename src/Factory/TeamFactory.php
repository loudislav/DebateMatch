<?php

declare(strict_types=1);

namespace DebateMatch\Factory;

use DebateMatch\DataObject\Institution;
use DebateMatch\DataObject\InstitutionCollection;
use DebateMatch\DataObject\Team;

class TeamFactory
{
    /**
     * @var InstitutionCollection
     */
    private $institutionCollection;

    public function __construct()
    {
        $this->institutionCollection = new InstitutionCollection();
    }

    /**
     * @param array $data
     * @return Team
     */
    public function create(array $data): Team
    {
        $institution = new Institution($data['institutionName']);
        $institution = $this->institutionCollection->addInstitution($institution);

        $team = new Team(
            $data['name'],
            $institution
        );

        return $team;
    }

    /**
     * @return InstitutionCollection
     */
    public function getInstitutionCollection(): InstitutionCollection
    {
        return $this->institutionCollection;
    }

}