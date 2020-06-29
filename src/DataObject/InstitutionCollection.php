<?php

declare(strict_types=1);

namespace DebateMatch\DataObject;

class InstitutionCollection
{
    /**
     * @var Institution[]
     */
    private $institutions = array();

    /**
     * @param Institution $institution
     * @return Institution
     */
    public function addInstitution(Institution $institution): Institution
    {
        foreach ($this->institutions as $record)
        {
            if ($record->getName() === $institution->getName())
            {
                return $record;
            }
        }
        $this->institutions[] = $institution;
        return $institution;
    }

    /**
     * @return array
     */
    public function getAllInstitutions(): array
    {
        return $this->institutions;
    }

}