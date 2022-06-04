<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

use DebateMatch\RatingCalculator;

class Matrix
{
    /**
     * @var array
     */
    private $matrix = array();

    /**
     * Create Matrix of ProposedMatches with affirmative lines and negative columns.
     * @param Team[] $teams
     * @param int|null $oppositeSideRoundNumber
     */
    public function __construct(array $teams, int $oppositeSideRoundNumber = null)
    {
        $counter = 0;
        foreach ($teams as $affirmative)
        {
            foreach ($teams as $negative)
            {
                if ($affirmative === $negative)
                {
                    $this->matrix[$counter][] = null;
                }
                else {
                    $this->matrix[$counter][] = new ProposedGame($affirmative, $negative, $oppositeSideRoundNumber);
                }
            }
            $counter++;
        }
    }

    /**
     * @return array
     */
    public function getMatrix(): array
    {
        return $this->matrix;
    }

    /**
     * Reduce Matrix so that each Team appears only as affirmative or as negative.
     * TODO: Refactoring - split into 2 functions
     * @return array()
     */
    public function getReducedMatrix(): array
    {
        $hungarian = new \DebateMatch\Hungarian($this->getAffirmativeXNegativeMatrix());
        $hungarianResults = $hungarian->solveMin();
        $affirmativeTeams = $negativeTeams = array();
        foreach ($hungarianResults as $key => $value)
        {
            $value < count($hungarianResults) / 2 ? $affirmativeTeams[] = $key : $negativeTeams[] = $key;
        }

        $reducedMatrix = array();
        for ($i = 0; $i < count($affirmativeTeams); $i++)
        {
            for($j = 0; $j < count($negativeTeams); $j++)
            {
                $reducedMatrix[$i][$j] = $this->matrix[$affirmativeTeams[$i]][$negativeTeams[$j]];
            }
        }
        return $reducedMatrix;
    }

    /**
     * Convert Matrix to a list of ProposedMatches ordered by rating.
     * @return ProposedGame[]
     */
    public function getList(): array
    {
        $list = array();
        foreach ($this->matrix as $row)
        {
            foreach ($row as $field)
            {
                if (null !== $field)
                {
                    $list[] = $field;
                }
            }
        }

        usort($list, array($this, "compareRatings"));

        return $list;
    }

    /**
     * @param ProposedGame $a
     * @param ProposedGame $b
     * @return int
     */
    private function compareRatings(ProposedGame $a, ProposedGame $b): int
    {
        if ($a->getRating() == $b->getRating()) return 0;
        return ($a->getRating() < $b->getRating()) ? -1 : 1;
    }

    /**
     * Returns square matrix with row for each Team and columns with total scores for its affirmative and negative games.
     * The first half of the columns is affirmative, the other half is negative.
     * To be used by the Hungarian algorithm.
     * @return array
     */
    private function getAffirmativeXNegativeMatrix(): array
    {
        $numberOfTeams = count($this->matrix);
        $numberOfAffirmativeTeams = $numberOfNegativeTeams = $numberOfTeams / 2;
        $affirmativeXNegativeMatrix = array();
        for ($i = 0; $i < $numberOfTeams; $i++)
        {
            $affirmativeXNegativeMatrix[$i] = array_merge(array_fill(0, $numberOfAffirmativeTeams, $this->getTotalAffirmativeRating($i)),array_fill($numberOfAffirmativeTeams, $numberOfNegativeTeams, $this->getTotalNegativeRating($i)));
        }
        return $affirmativeXNegativeMatrix;
    }

    /**
     * Returns sum of the Ratings of Team's all affirmative Games
     * @param int $team
     * @return int
     */
    private function getTotalAffirmativeRating(int $team): int
    {
        $totalRating = 0;
        foreach ($this->matrix[$team] as $game)
        {
            if (null !== $game) $totalRating += $game->getRating();
        }
        return $totalRating;
    }

    /**
     * Returns sum of the Rating of Team's all negative Games
     * @param int $team
     * @return int
     */
    private function getTotalNegativeRating(int $team): int
    {
        $totalRating = 0;
        foreach ($this->matrix as $games)
        {
            if (null !== $games[$team]) $totalRating += $games[$team]->getRating();
        }
        return $totalRating;
    }
}