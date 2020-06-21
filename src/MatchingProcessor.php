<?php

declare(strict_types=1);

namespace DebateMatch;


use DebateMatch\DataObject\Matrix;
use DebateMatch\Factory\TeamFactory;

class MatchingProcessor
{
    /**
     * @var TeamFactory
     */
    private $teamFactory;

    public function __construct()
    {
        $this->teamFactory = new TeamFactory();
        $this->ratingCalculator = new RatingCalculator(); // TODO: maybe unnecessary
    }

    public function process(array $data): Matrix
    {
        $teams = array();
        foreach ($data as $line) {
            $teams[] = $this->teamFactory->create($line);
        }
        // TODO: continue
        $matrix = new Matrix($teams);
        return $matrix;
    }
}