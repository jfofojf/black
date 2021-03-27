<?php

namespace Blackjack;

use function cli\line;
use function cli\prompt;

function getCard($arr)
{
    return $arr[rand(0, 12)];
}

function game()
{
    $cards = [
        'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'valet', 'dama', 'korol', 'tyz',
    ];
    $scores = [
        'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8,
        'nine' => 9, 'ten' => 10, 'valet' => 10, 'dama' => 10, 'korol' => 10, 'tyz' => 11,
    ];

    line('Hello Chlenosos!');
    $dealersCard1 = getCard($cards);
    $dealersCard2 = getCard($cards);
    $my1 = getCard($cards);
    $my2 = getCard($cards);
    $myScores = $scores[$my1] + $scores[$my2];
    $dealerScores = $scores[$dealersCard1] + $scores[$dealersCard2];

    line('your cards : [ $my1, $my2 ]');

    for ($i = $myScores; $i <= 21;) {
        $answer = prompt('do you need more? answer yes or no');
        if (strtolower($answer) === 'no') {
            $result = ($myScores > $dealerScores) ? 'yes' : 'no';
            $print = ($result === 'yes') ? 'You win!' : 'You lose!';
            line($print);
            break;
        } elseif (strtolower($answer) === 'yes') {
            $my3 = getCard($cards);
            line('your cards : [ $my1, $my2, $my3 ]');
            $myScores += $scores[$my3];
            $i += $scores[$my3];
        }
    }
}
