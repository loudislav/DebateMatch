<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

/**
 * Komplet předělat - neobsahuje všechna možná párování.
 * Maximum weight matching in bipartite graph
 * Possible solutions:
 * - Hungarian algorithm
 * - Hungarian algorithm with Bellman-Ford algorithm
 * - Possibly Dijkstra algorithm using Fibonacci heap
 * If not bipartite Edmonds' blossom algorithm
 * Použít heuristiku a nepřidat hrany s vysokým skore / porušující pravidla
 */
class RoundMatching
{
    /**
     * @var Game[]
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
     * @param ProposedGame[] $listOfAllPossibleMatches
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
     * @param ProposedGame $match
     */
    private function addMatch(ProposedGame $match): void
    {
        $this->matches[] = $match;
        $this->totalRating += $match->getRating();
        $this->usedTeams[] = $match->getAffirmative();
        $this->usedTeams[] = $match->getNegative();
    }

    /**
     * @return ProposedGame[]
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