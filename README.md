# php-hash-terminal-bruteforcer

Easy to use terminal hash bruteforcer written in php. The consists of the main class called BruteForcer. This has some method that is useful to the flow of attacking the hashed password. The file also consists of the most commons characters, that you might want to check for.

By default the alogrithm is set to "sha256", but this can be changed from within the file.

How to use? Run this in your terminal (Make sure php is installed):
php brute-forcer.php 7d601f9d20703a97b8cb530538dbbadaa3e4bdfa5f333977e4232f51eebdc47a

When you are ready to bruteforce your own passwords, change out the terminal argument provided above.

Feel free to you this and modify as much as you want. If you find bugs or want to suggest improvements, please feel free to submit pull requests.

## How does it work?

Simply by going all combinations in the character list systematically until either the max_length provided in the code is reached or we find a match. It then hashes all of the different password combinations and compares to the hashed password provided via terminal arguments.
