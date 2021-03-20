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
    public $hash_to_attack = '';
    private $password_arr = [];

    function __construct($algorithm) {
        $this->algorithm = $algorithm;
    }

    public function attack($hash_to_attack, $max_length) {
        $this->pre_attack_setup($hash_to_attack);
        while(count($this->password_arr) <= $max_length) {
            $this->iterator($this->password_arr);
            array_push($this->password_arr, chars[0]);
        }
        exit(1);
    }

    private function iterator($password_arr, $charIdx = 0) {
        // Recursive basecase
        if(count($password_arr) == $charIdx) return;

        for($i = 0; $i < count(chars); ++$i) {

            // This will prevent dublications
            if($charIdx != 0 && $i == 0) continue;

            $password_arr[$charIdx] = chars[$i];
            $password_str = implode('', $password_arr);
            $matches = $this->password_validator($password_str);

            if($matches) {
                echo "Password is: $password_str\n";
                exit(0);
            }

            $this->iterator($password_arr, $charIdx + 1);
        }
    }

    private function pre_attack_setup($hash_to_attack) {
        $this->password_arr = [chars[0]];
        $this->hash_to_attack = $hash_to_attack;
    }
    
    private function password_validator($password_str) {
        return hash($this->algorithm, $password_str) == $this->hash_to_attack;
    }
}

// Provide the algorithm you want to use on instantiation. See supported algorithms here: https://www.php.net/manual/en/function.hash-algos.php
$bruteForcer = new BruteForcer('sha256');
$hash_to_attack = strtolower($argv[1]);

$bruteForcer->attack($hash_to_attack, 3);