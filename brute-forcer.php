<?php

# Written by Magnus Lundstrøm 19/03/2021

define('UPPERCASE_LETTERS', range('A', 'Z'));
define('LOWERCASE_LETTERS', range('a', 'z'));
define('NUMBERS', range(0, 9));
define('SPECIAL_CHARACTERS', str_split('!@#$%^&*()-_+=~`[]{}|:;<>,.?/\'\"'));
define('chars', array_merge(LOWERCASE_LETTERS, UPPERCASE_LETTERS, NUMBERS, SPECIAL_CHARACTERS));

// TERMINAL bruteforcer for algoritms supported by PHP hash function
class BruteForcer {
    public $algorithm;
    public $environment;
    private $start_time = 0;
    private $counter = 0; // Purely utility
    private $hash_to_attack = '';
    private $password_arr = [];

    function __construct($algorithm) {
        $this->algorithm = $algorithm;
        $this->password_arr = [chars[0]];
    }

    public function attack($hash_to_attack, $max_length) {
        $this->hash_to_attack = $hash_to_attack;
        $this->count_down($max_length);
        while(count($this->password_arr) <= $max_length) {
            $this->iterator($this->password_arr);
            array_push($this->password_arr, chars[0]);
        }
        echo "\nFound nothing... Password may include characters not in chars array or is longer than max_length variable provided." ;
        echo "\nTried $this->counter times and spent " . (time() - $this->start_time) . " seconds.\n";
        $this->reset();
    }

    private function iterator($password_arr, $charIdx = 0) {
        // Recursive basecase
        if(count($password_arr) == $charIdx) return;

        for($i = 0; $i < count(chars); ++$i) {

            // This will prevent dublications
            if($charIdx != 0 && $i == 0) continue;

            $password_arr[$charIdx] = chars[$i];
            $password_str = implode('', $password_arr);
            echo $password_str; // Can be removed but looks pretty sick in the terminal not gonna lie
            $matches = $this->password_validator($password_str);

            if($matches) {
                echo "\n\nThe password is: $password_str\n";
                echo "It took $this->counter tries and " . (time() - $this->start_time) . " seconds.\n";
                exit();
            }

            $this->iterator($password_arr, $charIdx + 1);
            $this->counter++;
        }
    }

    // Reset the object ready for a new attack
    private function reset() {
        $this->counter = 0;
        $this->hash_to_attack = '';
        $this->pwArr = [];
        $this->start_time = 0;
    }
    
    private function password_validator($password_str) {
        return hash($this->algorithm, $password_str) == $this->hash_to_attack;
    }

    private function count_down($max_length) {
        echo "Starting attempt with " . count(chars) . " characters and max password length of $max_length. At worst will take " . pow(count(chars), $max_length) . " tries.\n";
        for($i = 2; $i >= 0; --$i) {
            echo "Starting in: $i\n";
            sleep(1);
        }
        echo "\n";
        $this->start_time = time();
    }
}

// Provide the class the algorithm you want to use. See supported algorithms here: https://www.php.net/manual/en/function.hash-algos.php
$bruteForcer = new BruteForcer('sha256');

$hash_to_attack = $argv[1];


// Provide the attack function the hash you want to attack and the MAXIMUM CHARACTER LENGTH of passwords you want to attack. Remember each char is VERY expensive
$bruteForcer->attack($hash_to_attack, 15);