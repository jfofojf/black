<?php

namespace Blackjack;

use function cli\line;
use function cli\prompt;

/**
 * @param $arr
 * @return mixed
 */
function getCard(array $arr) : string
{
    return $arr[rand(0, 51)];
}

/**
 * @param array $arr
 * @return string
 */
function arrToStr(array $arr) : string
{
    $result = '';
    foreach ($arr as $item) {
        $result .= "[$item]";
    }
    return $result;
}

/**
 * @param array $cards
 * @param array $scores
 * @return array
 */
function generateDealer(array $cards, array $scores) : array
{
    $firstCard = getCard($cards);
    $secondCard = getCard($cards);
    $dealer[] = $firstCard;
    $dealer[] = $secondCard;
    $scoresCount = $scores[$firstCard] + $scores[$secondCard];
    $toPrint = "";
    for ($i = $scoresCount; $i < 17;) {
        $var = getCard($cards);
        $dealer[] = $var;
        $i += $scores[$var];
        $scoresCount += $scores[$var];
    }
    $toPrint = arrToStr($dealer);
    return ['print' => $toPrint, 'scores' => $scoresCount, 'cards' => $dealer];
}

/**
 * @param array $plOneCards
 * @param int $plOneScore
 * @param array $plTwoCards
 * @param int $plTwoScore
 * @return string
 */
function getWinner(array $plOneCards, int $plOneScore, array $plTwoCards, int $plTwoScore) : string
{
    $blackjack = "['tyz']['tyz']";

    if ($plOneCards === $blackjack && $plTwoCards === $blackjack) {
        return 'Dead head! Double blackjack!!!';
    } elseif ($plOneCards === $blackjack) {
        return 'You win! blackjack!!!';
    } elseif ($plTwoCards === $blackjack) {
        return 'Dealer win! blackjack!!!';
    }

    if ($plOneScore > 21) {
        return 'Dealer win!';
    } elseif ($plTwoScore > 21) {
        return 'You win!';
    } elseif ($plOneScore === $plTwoScore) {
        return 'Dead head!';
    } else {
        return ($plOneScore > $plTwoScore) ? 'You win!' : 'Dealer Win!';
    }
}

/**
 *
 */
function game()
{
    $cards = [
        'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'valet', 'dama', 'korol', 'tyz',
        'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'valet', 'dama', 'korol', 'tyz',
        'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'valet', 'dama', 'korol', 'tyz',
        'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'valet', 'dama', 'korol', 'tyz',
    ];
    $scores = [
        'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8,
        'nine' => 9, 'ten' => 10, 'valet' => 10, 'dama' => 10, 'korol' => 10, 'tyz' => 11,
    ];

    line('#####################');
    line('Welcome to Blackjack!');
    line('#####################');
    $start = prompt("print 'q' to exit or 'anything' to begin game");
    if ($start === 'q') {
        exit(0);
    }
    line('#################################');
    $my1 = getCard($cards);
    $my2 = getCard($cards);
    $myCards[] = $my1;
    $myCards[] = $my2;
    $myScores = $scores[$my1] + $scores[$my2];

    $dealer = generateDealer($cards, $scores);
    $printDealer = $dealer['print'];
    $dealerScores = $dealer['scores'];
    $dealerCards = $dealer['cards'];

    line("Your cards : [$my1][$my2]");
    line('#################################');

    for ($i = $myScores; $i <= 21;) {
        $answer = prompt('Do you need one more? answer yes or no');
        if (strtolower($answer) === 'no') {
            line('#################################');
            line("Dealer has : $dealerScores -> $printDealer");
            $myPrint = arrToStr($myCards);
            line('#################################');
            line("You has : $myScores -> $myPrint");
            line('#################################');
            $print = getWinner($myCards, $myScores, $dealerCards, $dealerScores);
            line($print);
            break;
        } elseif (strtolower($answer) === 'yes') {
            $val = getCard($cards);
            $myCards[] = $val;
            $print = arrToStr($myCards);
            line('#################################');
            line("Your cards : $print ");
            line('#################################');
            $cur = end($myCards);
            $myScores += $scores[$cur];
        }
    }
}
