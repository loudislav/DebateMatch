<?php

declare(strict_types=1);

namespace DebateMatch;


use DebateMatch\DataObject\Team;

class RatingCalculator
{
    // TODO: create YAML config file with values
    private const SAME_INSTITUTION = 1;
    private const WINS_DIFFERENCE_MULTIPLIER = 2;
    private const BALLOTS_DIFFERENCE_MULTIPLIER = 1;
    private const MET_BEFORE = 5;
    private const REPEAT_SAME_SIDE = 10;

    /**
     * // TODO: maybe can be static
     * // TODO: return flags (list of the broken rules)
     * @param Team $affirmative
     * @param Team $negative
     * @param int|null $oppositeSideRoundNumber
     * @return int
     */
    public function calculate(Team $affirmative, Team $negative, int $oppositeSideRoundNumber = null): int
    {
        $rating = 0;

        if ($this->areFromSameInstitution($affirmative, $negative)) $rating += self::SAME_INSTITUTION;
        $rating += $this->getResultDifferenceRating($affirmative, $negative);
        if ($affirmative->haveMetTeamBefore($negative)) $rating += self::MET_BEFORE;
        if (null !== $oppositeSideRoundNumber)
        {
            if ($affirmative->wasSideBefore($oppositeSideRoundNumber, true)) $rating += self::REPEAT_SAME_SIDE;
            if ($negative->wasSideBefore($oppositeSideRoundNumber, false)) $rating += self::REPEAT_SAME_SIDE;
        }

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

    /**
     * @param Team $affirmative
     * @param Team $negative
     * @return int
     */
    private function getResultDifferenceRating(Team $affirmative, Team $negative): int
    {
        $winsDifference = abs($affirmative->getTotalWins() - $negative->getTotalWins());
        $ballotsDifference = abs($affirmative->getTotalBallots() - $negative->getTotalBallots());

        // TODO: add speaker points difference
        return $winsDifference * self::WINS_DIFFERENCE_MULTIPLIER
            + $ballotsDifference * self::BALLOTS_DIFFERENCE_MULTIPLIER;
    }

}