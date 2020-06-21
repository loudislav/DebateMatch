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
     * @var RatingCalculator
     */
    private $ratingCalculator;

    /**
     * @param array $teams
     */
    public function __construct(array $teams)
    {
        $this->ratingCalculator = new RatingCalculator();
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
                    // TODO: Class Matching
                    $opponent = array(
                        'affirmative' => $affirmative,
                        'negative' => $negative,
                        'rating' => $this->ratingCalculator->calculate($affirmative, $negative)
                    );
                    $this->matrix[$counter][] = $opponent;
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
     * @param array $a
     * @param array $b
     * @return int
     */
    private function compareRatings(array $a, array $b): int
    {
        if ($a['rating'] == $b['rating']) return 0;
        return ($a['rating'] < $b['rating']) ? -1 : 1;
    }
}