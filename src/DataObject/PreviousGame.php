<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

class PreviousGame extends Game
{
    /**
     * @var int
     */
    private $roundNumber;
    /**
     * @var bool
     */
    private $affirmativeWinner;
    /**
     * @var bool
     */
    private $unanimousResult;

    /**
     * PreviousGame constructor.
     * @param Team $affirmative
     * @param Team $negative
     */
    public function __construct(Team $affirmative, Team $negative, int $roundNumber, bool $affrimativeWinner, bool $unanimousResult)
    {
        parent::__construct($affirmative, $negative);
        $this->roundNumber = $roundNumber;
        $this->affirmativeWinner = $affrimativeWinner;
        $this->unanimousResult = $unanimousResult;
    }

    /**
     * @return int
     */
    public function getRoundNumber(): int
    {
        return $this->roundNumber;
    }

    /**
     * @return bool
     */
    public function getAffirmativeWinner(): bool
    {
        return $this->affirmativeWinner;
    }

    /**
     * @return bool
     */
    public function getUnanimousResult(): bool
    {
        return $this->unanimousResult;
    }
}