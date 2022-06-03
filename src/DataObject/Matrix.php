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
}