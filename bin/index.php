<?php

include_once __DIR__ . '/../vendor/autoload.php';

//$data = json_decode(file_get_contents(__DIR__ . '/../test-data-round-1.json'));

/** Začátek testovacích dat */
$data = array(
    array(
        'name' => 'Team A',
        'institutionName' => 'Institution 1',
        'previousMatches' => array(
            array(
                'affirmative' => 'Team A',
                'negative' => 'Team C',
                'roundNumber' => 1,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            )
        )
    ),
    array(
        'name' => 'Team B',
        'institutionName' => 'Institution 1',
        'previousMatches' => array(
            array(
                'affirmative' => 'Team B',
                'negative' => 'Team D',
                'roundNumber' => 1,
                'affirmativeWinner' => false,
                'unanimousResult' => false
            )
        )
    ),
    array(
        'name' => 'Team C',
        'institutionName' => 'Institution 2',
        'previousMatches' => array(
            array(
                'affirmative' => 'Team A',
                'negative' => 'Team C',
                'roundNumber' => 1,
                'affirmativeWinner' => true,
                'unanimousResult' => true
            )
        )
    ),
    array(
        'name' => 'Team D',
        'institutionName' => 'Institution 3',
        'previousMatches' => array(
            array(
                'affirmative' => 'Team B',
                'negative' => 'Team D',
                'roundNumber' => 1,
                'affirmativeWinner' => false,
                'unanimousResult' => false
            )
        )
    )
);
/** Konec testovacích dat */

/** Začátek načítání z greyboxu */
/*
$gb = file_get_contents('https://debatovani.cz/greybox/?page=turnaj&turnaj_id=244');
$gbSplit = preg_split('/\<h2\>(.*)\<\/h2\>/m', $gb);
$lines = preg_split('/\<tr\>/', $gbSplit[1]);
$data = array();
for ($i = 2; $i < count($lines); $i++)
{
    $fields = preg_split('/\>/', $lines[$i]);
    $data[] = array(
        'name' => substr($fields[4],0,-3),
        'institutionName' => substr($fields[8],0,-3)
    );
}

$debateLines = preg_split('/\<tr\>/', $gbSplit[2]);
for ($i = 28; $i < count($debateLines); $i++)
{
    $fields = preg_split('/\>/', $debateLines[$i]);
    $date = substr($fields[1], 0, -4); // may be unnecessary
    $affirmative = substr($fields[4], 0, -3);
    $negative = substr($fields[8], 0, -3);
    $result = substr($fields[15], 0, -4);
    echo "$date\t$affirmative\t$negative\t$result\n\n";
    $affirmativeWinner = false;
    if (substr($result, 0, 3) === 'aff') $affirmativeWinner = true;
    $unanimousResult = false;
    if (substr($result, 4, 3) === '3:0') $unanimousResult = true;

    switch ($i)
    {
        case ($i < 42):
            $roundNumber = 3;
            break;
        case ($i < 56):
            $roundNumber = 2;
            break;
        default:
            $roundNumber = 1;
            break;
    }

    for ($j = 0; $j < count($data); $j++)
    {
        if ($data[$j]['name'] === $affirmative or $data[$j]['name'] === $negative)
        {
            $data[$j]['previousMatches'][] = array(
                'affirmative' => $affirmative,
                'negative' => $negative,
                'roundNumber' => $roundNumber,
                'affirmativeWinner' => $affirmativeWinner,
                'unanimousResult' => $unanimousResult
            );
        }
    }
}

var_dump($data);
*/
/** Konec načítání z greyboxu */

$matchingProcessor = new \DebateMatch\MatchingProcessor();
$matchingSet = $matchingProcessor->process($data, 1);

echo "Bylo navrženo " . count($matchingSet) . " možných párování. Z toho " . count($matchingSet) . " optimálních.<br>";

echo '<br><table border="1">';
foreach ($matchingSet as $roundMatching)
{
    echo "<tr><td>".$roundMatching->getTotalRating()."</td>";
    foreach ($roundMatching->getAllMatches() as $match)
    {
        echo "<td>Aff: ";
        echo $match->getAffirmative()->getName();
        echo "<br />Neg: ";
        echo $match->getNegative()->getName();
        echo "<br>Rating: ";
        echo $match->getRating();
        echo "</td>";
    }
    echo "</tr>";
}
echo '</table>';

/*$matrix = $matchingProcessor->process($data);

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
echo '</table>';*/