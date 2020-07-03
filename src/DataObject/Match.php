<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

abstract class Match
{
    /**
     * @var Team
     */
    protected $affirmative;
    /**
     * @var Team
     */
    protected $negative;

    /**
     * Match constructor.
     * @param Team $affirmative
     * @param Team $negative
     */
    public function __construct(Team $affirmative, Team $negative)
    {
        $this->affirmative = $affirmative;
        $this->negative = $negative;
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
}