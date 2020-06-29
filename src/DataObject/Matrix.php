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
     * @param array $teams
     */
    public function __construct(array $teams)
    {
        $this->create($teams);
    }

    /**
     * @param array $teams
     */
    private function create(array $teams)
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
                    $this->matrix[$counter][] = new Match($affirmative, $negative);
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