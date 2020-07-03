<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

use DebateMatch\RatingCalculator;

class ProposedMatch extends Match
{
    /**
     * @var RatingCalculator
     */
    private $ratingCalculator;
    /**
     * @var int
     */
    private $rating;

    /**
     * Match constructor.
     * @param Team $affirmative
     * @param Team $negative
     * @param int|null $oppositeSideRoundNumber
     */
    public function __construct(Team $affirmative, Team $negative, int $oppositeSideRoundNumber = null)
    {
        parent::__construct($affirmative, $negative);
        $this->ratingCalculator = new RatingCalculator();
        $this->rating = $this->ratingCalculator->calculate($affirmative, $negative, $oppositeSideRoundNumber);
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }
}