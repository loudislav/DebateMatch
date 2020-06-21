<?php

include_once __DIR__ . '/../vendor/autoload.php';

//$data = json_decode(file_get_contents(__DIR__ . '/../test-data-round-1.json'));
$data = array(
    array(
        'name' => 'Team A',
        'institutionName' => 'Institution 1'
    ),
    array(
        'name' => 'Team B',
        'institutionName' => 'Institution 1'
    ),
    array(
        'name' => 'Team C',
        'institutionName' => 'Institution 2'
    ),
    array(
        'name' => 'Team D',
        'institutionName' => 'Institution 3'
    )
);

$matchingProcessor = new \DebateMatch\MatchingProcessor();
$matrix = $matchingProcessor->process($data);

echo '<table border="1">';
foreach ($matrix->getMatrix() as $lineKey => $line)
{
    echo '<tr>';
    foreach ($line as $fieldKey => $field)
    {
        if (null === $field) {
            echo "<td>N/A</td>";
        } else {
            echo "<td>Aff: ";
            echo $field['affirmative']->getName();
            echo "<br />Neg: ";
            echo $field['negative']->getName();
            echo "<br>$field[rating]";
            echo "</td>";
        }
    }
    echo '</tr>';
}
echo '</table>';

$list = $matrix->getList();

echo '<br><table border="1">';
foreach ($list as $item)
{
    echo "<tr><td>Aff: ";
    echo $item['affirmative']->getName();
    echo "<br />Neg: ";
    echo $item['negative']->getName();
    echo "<br>$item[rating]";
    echo "</td></tr>";
}
echo '</table>';