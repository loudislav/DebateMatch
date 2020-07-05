<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

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
     * @param ProposedMatch[] $listOfAllPossibleMatches
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
     * @param ProposedMatch $match
     */
    private function addMatch(ProposedMatch $match): void
    {
        $this->matches[] = $match;
        $this->totalRating += $match->getRating();
        $this->usedTeams[] = $match->getAffirmative();
        $this->usedTeams[] = $match->getNegative();
    }

    /**
     * @return ProposedMatch[]
     */
    public function getAllMatches(): array
    {
        return $this->matches;
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