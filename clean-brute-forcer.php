<?php

# Provide the class the algorithm you want to use. See supported algorithms here: https:#www.php.net/manual/en/function.hash-algos.php

define('UPPERCASE_LETTERS', range('A', 'Z'));
define('LOWERCASE_LETTERS', range('a', 'z'));
define('NUMBERS', range(0, 9));
define('SPECIAL_CHARACTERS', str_split('!@#$%^&*()-_+=~`[]{}|:;<>,.?/\'\"'));
define('chars', array_merge(LOWERCASE_LETTERS, UPPERCASE_LETTERS, NUMBERS, SPECIAL_CHARACTERS));

# TERMINAL bruteforcer for algoritms supported by PHP hash function
class BruteForcer {
    public $algorithm;
    public $max_length;
    private $hash_to_attack = '';
    private $password_arr = [];

    function __construct($algorithm, $hash_to_attack, $max_length) {
        $this->algorithm = $algorithm;
        $this->hash_to_attach = $hash_to_attack;
        $this->max_length = $max_length;

        $this->run_attack();
    }

    public function run_attack() {
        $this->pre_attack_setup();
        $this->attack();
        $this->post_attack_teardown();
    }


    public function attack() {
        while(count($this->password_arr) <= $this->max_length) {
            $this->iterator();
            array_push($this->password_arr, chars[0]);
        }
    }

    private function iterator($charIdx = 0) {
        if(count($this->password_arr) == $charIdx) return;

        for($i; $i < count(chars); ++$i) {
            $this->iterator($this->password_arr, $charIdx + 1);

            # This will prevent dublicate operations
           if($charIdx != 0 && $i == 0) continue;
            $this->counter++;
            $this->password_arr[$char_index] = chars[$i];
 
            if($this->determine_match()) {
                $this->handle_hash_match();
            }
        }
    }

    private function determine_match() {
        $password_str = implode('', $this->password_arr);
        return $this->password_validator($password_str);
    }
    
    private function password_validator($password_str) {
        return hash($this->algorithm, $password_str) == $this->hash_to_attack;
    }
    
    private function handle_hash_match() {
        echo "\nThe password is: $password_str\n";
        exit(0); 
    }
    
    private function pre_attack_setup() {
        $this->password_arr = [chars[0]];
    }

    private function post_attack_teardown() {
        echo "\nThe password is: $password_str\n";
        exit(0);
    }
}

$algorithm = $argv[1];
$hash_to_attack = strtolower($argv[2]);
$max_length = $argv[3];

$bruteForcer = new BruteForcer($algorithm, $hash_to_attack, $max_length);