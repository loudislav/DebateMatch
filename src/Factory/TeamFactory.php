<?php

declare(strict_types=1);

namespace DebateMatch\Factory;

use DebateMatch\DataObject\Institution;
use DebateMatch\DataObject\InstitutionCollection;
use DebateMatch\DataObject\PreviousMatch;
use DebateMatch\DataObject\Team;
use DebateMatch\DataObject\TeamCollection;

class TeamFactory
{
    /**
     * @var InstitutionCollection
     */
    private $institutionCollection;
    /**
     * @var TeamCollection
     */
    private $teamCollection;

    public function __construct()
    {
        $this->institutionCollection = new InstitutionCollection();
        $this->teamCollection = new TeamCollection();
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
        $this->teamCollection->addTeam($team);

        return $team;
    }

    /**
     * @param array $data
     * @param Team $currentTeam
     */
    public function addPreviousMatches(array $data, Team $currentTeam): void
    {
        foreach ($data as $item)
        {
            $previousMatch = new PreviousMatch
            (
                $this->teamCollection->getTeamByName($item['affirmative']),
                $this->teamCollection->getTeamByName($item['negative']),
                $item['roundNumber'],
                $item['affirmativeWinner'],
                $item['unanimousResult']
            );

            $currentTeam->addPreviousMatch($previousMatch);
        }
    }

    /**
     * @return InstitutionCollection
     */
    public function getInstitutionCollection(): InstitutionCollection
    {
        return $this->institutionCollection;
    }

}