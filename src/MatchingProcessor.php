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

    public function process(array $data, int $oppositeSideRoundNumber = null): array
    {
        $teams = array();
        foreach ($data as $line) {
            $teams[] = $this->teamFactory->create($line);
        }
        for ($i = 0; $i < count($teams); $i++) {
            if (isset($data[$i]['previousMatches']))
            {
                foreach ($data[$i]['previousMatches'] as $match)
                {
                    $this->teamFactory->addPreviousMatches($match, $teams[$i]);
                }
            }
        }
        // TODO: continue
        $matrix = new Matrix($teams, $oppositeSideRoundNumber);
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

        usort($proposedRoundMatchings, array($this, "compareTotalRatings"));
        return $proposedRoundMatchings;
    }

    /**
     * @param RoundMatching $a
     * @param RoundMatching $b
     * @return int
     */
    private function compareTotalRatings(RoundMatching $a, RoundMatching $b): int
    {
        if ($a->getTotalRating() === $b->getTotalRating()) return 0;
        return ($a->getTotalRating() < $b->getTotalRating()) ? -1 : 1;
    }
}