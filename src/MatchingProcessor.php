<?php

declare(strict_types=1);

namespace DebateMatch;


use DebateMatch\DataObject\Matrix;
use DebateMatch\DataObject\RoundMatching;
use DebateMatch\Factory\TeamFactory;

class MatchingProcessor
{
    /**
     * @var TeamFactory
     */
    private $teamFactory;

    public function __construct()
    {
        $this->teamFactory = new TeamFactory();
    }

    public function process(array $data): array
    {
        $teams = array();
        foreach ($data as $line) {
            $teams[] = $this->teamFactory->create($line);
        }
        // TODO: continue
        $matrix = new Matrix($teams);
        $proposedRoundMatchings = $this->getProposedRoundMatchings($matrix->getList(), count($teams));
        return $proposedRoundMatchings;
    }

    private function getProposedRoundMatchings(array $listOfMatches, int $numberOfTeams): array
    {
        $proposedRoundMatchings = array();
        while (count($listOfMatches) >= $numberOfTeams / 2)
        {
            $roundMatching = new RoundMatching($listOfMatches);
            if ($roundMatching->isComplete($numberOfTeams))
            {
                $proposedRoundMatchings[] = $roundMatching;
            }
            array_shift($listOfMatches);
        }
        return $proposedRoundMatchings; // TODO: maybe order by totalRanking first
    }
}