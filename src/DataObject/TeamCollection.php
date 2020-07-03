<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

class TeamCollection
{
    /**
     * @var Team[]
     */
    private $teams = array();

    /**
     * @param Team $team
     * @return Team
     */
    public function addTeam(Team $team): Team
    {
        $this->teams[] = $team;
        return $team;
    }

    /**
     * @return array
     */
    public function getAllTeams(): array
    {
        return $this->teams;
    }

    /**
     * @param string $teamName
     * @return Team
     */
    public function getTeamByName(string $teamName): Team
    {
        foreach ($this->teams as $record)
        {
            if ($record->getName() === $teamName)
            {
                return $record;
            }
        }
    }

}