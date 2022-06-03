<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

class Team
{
    private const BALLOTS_FOR_UNANIMOUS_WIN = 3;
    private const BALLOTS_FOR_SPLIT_WIN = 2;
    private const BALLOTS_FOR_SPLIT_LOSS = 1;
    private const BALLOTS_FOR_UNANIMOUS_LOSS = 0;
    /**
     * @var string
     */
    private $name;
    /**
     * @var Institution
     */
    private $institution;
    /**
     * @var PreviousGame[]
     */
    private $previousMatches = array();
    /**
     * @var int
     */
    private $totalWins = 0;
    /**
     * @var int
     */
    private $totalBallots = 0;
    /**
     * @var Team[]
     */
    private $previousOpponents = array();

    public function __construct(string $name, Institution $institution)
    {
        $this->name = $name;
        $this->institution = $institution;
    }

    /**
     * @param PreviousGame $previousMatch
     */
    public function addPreviousMatch(PreviousGame $previousMatch): void
    {
        $round = $previousMatch->getRoundNumber();
        $this->previousMatches[$round] = $previousMatch;

        if ($this->isWinner($previousMatch->getAffirmativeWinner(), $previousMatch->getAffirmative()))
        {
            $this->totalWins += 1;
            $this->calculateBallots(true, $previousMatch->getUnanimousResult());
        }
        else
        {
            $this->calculateBallots(false, $previousMatch->getUnanimousResult());
        }

        $this->addPreviousOpponent($previousMatch);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Institution
     */
    public function getInstitution(): Institution
    {
        return $this->institution;
    }

    /**
     * @return int
     */
    public function getTotalWins(): int
    {
        return $this->totalWins;
    }

    /**
     * @return int
     */
    public function getTotalBallots(): int
    {
        return $this->totalBallots;
    }

    /**
     * Check if current team is winner of the match
     * @param bool $affirmativeWinner
     * @param Team $affirmative
     * @return bool
     */
    private function isWinner(bool $affirmativeWinner, Team $affirmative): bool
    {
        if ($affirmativeWinner and $this === $affirmative) return true;
        elseif (!$affirmativeWinner and $this === $affirmative) return false;
        elseif ($affirmativeWinner and $this !== $affirmative) return false;
        else return true;
    }

    /**
     * @param bool $winner
     * @param bool $unanimousResult
     */
    private function calculateBallots(bool $winner, bool $unanimousResult): void
    {
        if ($winner and $unanimousResult) $this->totalBallots += self::BALLOTS_FOR_UNANIMOUS_WIN;
        elseif ($winner and !$unanimousResult) $this->totalBallots += self::BALLOTS_FOR_SPLIT_WIN;
        elseif (!$winner and !$unanimousResult) $this->totalBallots += self::BALLOTS_FOR_SPLIT_LOSS;
        else $this->totalBallots += self::BALLOTS_FOR_UNANIMOUS_LOSS;
    }

    /**
     * @param PreviousGame $previousMatch
     */
    private function addPreviousOpponent(PreviousGame $previousMatch): void
    {
        if ($this !== $previousMatch->getAffirmative()) $this->previousOpponents[] = $previousMatch->getAffirmative();
        else $this->previousOpponents[] = $previousMatch->getNegative();
    }

    /**
     * @param Team $opponent
     * @return bool
     */
    public function haveMetTeamBefore(Team $opponent): bool
    {
        foreach ($this->previousOpponents as $previousOpponent)
        {
            if ($previousOpponent === $opponent) return true;
        }
        return false;
    }

    /**
     * @param int $oppositeSiteRoundNumber
     * @param bool $affirmative
     * @return bool
     */
    public function wasSideBefore(int $oppositeSiteRoundNumber, bool $affirmative): bool
    {
        if (!isset($this->previousMatches[$oppositeSiteRoundNumber]))
        {
            return false;
        }
        $oppositeSiteRound = $this->previousMatches[$oppositeSiteRoundNumber];

        if ($affirmative and $oppositeSiteRound->getAffirmative() === $this) return true;
        elseif ($affirmative and $oppositeSiteRound->getAffirmative() !== $this) return false;
        elseif (!$affirmative and $oppositeSiteRound->getAffirmative() === $this) return false;
        else return true;
    }
}