<?php

declare(strict_types=1);

namespace DebateMatch;


use DebateMatch\DataObject\Matrix;
use DebateMatch\DataObject\RoundMatching;
use DebateMatch\Factory\TeamFactory;

// TODO: refactor
class MatchingProcessor
{
    private TeamFactory $teamFactory;

    public function __construct()
    {
        $this->teamFactory = new TeamFactory();
    }

    public function process(array $data, int $oppositeSideRoundNumber = null): array
    {
        $teams = $this->createTeams($data);

        $matrix = new Matrix($teams, $oppositeSideRoundNumber);
        foreach ($matrix->getList() as $item) {
            echo $item->getAffirmative()->getName() . " " . $item->getNegative()->getName() . " " . $item->getRating() . "<br>";
        }
        $matrix = $matrix->getReducedMatrix();
        $tmpMatrix = array();
        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 0; $j < count($matrix); $j++) {
                if (null === $matrix[$i][$j]) {
                    $tmpMatrix[$i][$j] = 1000;
                } else {
                    $tmpMatrix[$i][$j] = $matrix[$i][$j]->getRating();
                }
            }
        }
        var_dump($tmpMatrix);
        $hungarian = new Hungarian($tmpMatrix);
        $allocation = $hungarian->solveMin(true);
        $proposedRoundMatchings = array();
        foreach ($allocation as $key => $value)
        {
            $proposedRoundMatchings[] = $matrix[$key][$value];
        }

        return $proposedRoundMatchings;
    }

    private function createTeams(array $data): array
    {
        $teams = array();
        foreach ($data as $line) {
            $teams[] = $this->teamFactory->create($line);
        }
        for ($i = 0; $i < count($teams); $i++) {
            if (isset($data[$i]['previousMatches']))
            {
                $this->teamFactory->addPreviousMatches($data[$i]['previousMatches'], $teams[$i]);
            }
        }
        return $teams;
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