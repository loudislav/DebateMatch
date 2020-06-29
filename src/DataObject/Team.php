<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

class Team
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Institution
     */
    private $institution;
    /**
     * @var int
     */
    private $totalWins = 0;
    /**
     * @var int
     */
    private $totalBallots = 0;

    public function __construct(string $name, Institution $institution)
    {
        $this->name = $name;
        $this->institution = $institution;
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
}