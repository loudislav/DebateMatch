<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

use DebateMatch\RatingCalculator;

class RoundMatching
{
    /**
     * @var Match[]
     */
    private $matches = array();
    /**
     * @var int
     */
    private $totalRating;
    /**
     * @var Team[]
     */
    private $usedTeams = array();

    /**
     * RoundMatching constructor.
     * @param Match[] $listOfAllPossibleMatches
     */
    public function __construct(array $listOfAllPossibleMatches)
    {
        foreach ($listOfAllPossibleMatches as $match)
        {
            // if neither of the teams is used
            if (!in_array($match->getAffirmative(), $this->usedTeams) and !in_array($match->getNegative(), $this->usedTeams))
            {
                $this->addMatch($match);
            }
        }
    }

    /**
     * @param Match $match
     */
    private function addMatch(Match $match): void
    {
        $this->matches[] = $match;
        $this->totalRating += $match->getRating();
        $this->usedTeams[] = $match->getAffirmative();
        $this->usedTeams[] = $match->getNegative();
    }

    /**
     * @return array|Match[]
     */
    public function getAllMatches(): array
    {
        return $this->matches; // TODO: maybe order by rating first
    }

    /**
     * @return int
     */
    public function getTotalRating(): int
    {
        return $this->totalRating;
    }

    /**
     * @param int $totalNumberOfTeams
     * @return bool
     */
    public function isComplete(int $totalNumberOfTeams): bool
    {
        if (count($this->usedTeams) === $totalNumberOfTeams)
        {
            return true;
        }
        return false;
    }
}