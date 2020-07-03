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
     * Matrix constructor.
     * @param array $teams
     * @param int|null $oppositeSideRoundNumber
     */
    public function __construct(array $teams, int $oppositeSideRoundNumber = null)
    {
        $this->create($teams, $oppositeSideRoundNumber);
    }

    /**
     * TODO: merge with constructor
     * @param array $teams
     * @param int|null $oppositeSideRoundNumber
     */
    private function create(array $teams, int $oppositeSideRoundNumber = null)
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
                    $this->matrix[$counter][] = new ProposedMatch($affirmative, $negative, $oppositeSideRoundNumber);
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
     * TODO: test
     * @return array
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
     * @param Match $a
     * @param Match $b
     * @return int
     */
    private function compareRatings(Match $a, Match $b): int
    {
        if ($a->getRating() == $b->getRating()) return 0;
        return ($a->getRating() < $b->getRating()) ? -1 : 1;
    }
}