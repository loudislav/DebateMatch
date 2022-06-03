<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

abstract class Game
{
    /**
     * @var Team
     */
    protected Team $affirmative;
    /**
     * @var Team
     */
    protected Team $negative;

    /**
     * Game constructor.
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