<?php

declare(strict_types=1);

namespace DebateMatch;


use DebateMatch\DataObject\Team;

class RatingCalculator
{
    // TODO: create YAML config file with values
    private const SAME_INSTITUTION = 1;

    /**
     * // TODO: maybe can be static
     * @param Team $affirmative
     * @param Team $negative
     * @return int
     */
    public function calculate(Team $affirmative, Team $negative): int
    {
        $rating = 0;

        if ($this->areFromSameInstitution($affirmative, $negative)) $rating += self::SAME_INSTITUTION;

        return $rating;
    }

    /**
     * @param Team $affirmative
     * @param Team $negative
     * @return bool
     */
    private function areFromSameInstitution(Team $affirmative, Team $negative): bool
    {
        if ($affirmative->getInstitution() === $negative->getInstitution())
        {
            return true;
        }
        return false;
    }

}