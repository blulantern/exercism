<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

class Tournament
{
    private $teams;
    const WIN = 'win';
    const LOSS = 'loss';
    const DRAW = 'draw';

    public function __construct()
    {
        $this->teams = array();
    }

    public function tally($scores) 
    {
        $lines = explode("\n", $scores);
        foreach ($lines as $line) {
            $score = explode(';', $line);
            switch ($score[2]) {
                case self::WIN:
                    $this->addTeam($score[0], self::WIN);
                    $this->addTeam($score[1], self::LOSS);
                    break;
                case self::LOSS:
                    $this->addTeam($score[0], self::LOSS);
                    $this->addTeam($score[1], self::WIN);
                    break;
                default:
                    $this->addTeam($score[0]);
                    $this->addTeam($score[1]);
            }
        }
        print_r($this->teams);
        return $this->createTable();
    }
    private function addTeam($team, $result = null)
    {
        if (!array_key_exists($team, $this->teams)) {
            $this->teams = [$team =>['mp' => 0, 'w' => 0, 'd' => 0, 'l' => 0, 'p' => 0]];
        }
        switch ($result) {
            case self::WIN:
                $this->teams[$team]['mp']++;
                $this->teams[$team]['w']++;
                $this->teams[$team]['p']+=3;
                break;
            case self::LOSS:
                $this->teams[$team]['mp']++;
                $this->teams[$team]['l']++;
                break;
            default:
                $this->teams[$team]['mp']++;
                $this->teams[$team]['d']++;
                $this->teams[$team]['p']++;
                break;
        }
    }

    private function createTable()
    {
        $table = "Team                           | MP |  W |  D |  L |  P\n";
        foreach($this->teams as $team => $values){
            $table .= "$team             |  {$values['mp']} |  {$values['w']} |  {$values['d']} |  {$values['l']} |  {$values['p']}\n";
        }
        print_r($table);
        return $table;
    }
}
