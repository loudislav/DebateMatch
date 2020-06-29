<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

use DebateMatch\RatingCalculator;

class Match
{
    /**
     * @var RatingCalculator
     */
    private $ratingCalculator;
    /**
     * @var Team
     */
    private $affirmative;
    /**
     * @var Team
     */
    private $negative;
    /**
     * @var int
     */
    private $rating;

    /**
     * Match constructor.
     * @param Team $affirmative
     * @param Team $negative
     */
    public function __construct(Team $affirmative, Team $negative)
    {
        $this->ratingCalculator = new RatingCalculator();

        $this->affirmative = $affirmative;
        $this->negative = $negative;
        $this->rating = $this->ratingCalculator->calculate($affirmative, $negative);
    }

    /**
     * @return Team
     */
    public function getAffirmative(): Team
    {
        return $this->affirmative;
    }

    /**
     * @return Team
     */
    public function getNegative(): Team
    {
        return $this->negative;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }
}