# Simple Lexer Based PHP

Developed it to understand how Lexer works.

## Installation

```sh
$ git clone git@github.com:baygin/php-simple-lexer.git
$ cd php-simple-lexer
$ composer install
```

## Test

```sh
$ php tests/index.php
```
### Result

```
----- Tokenizing the file: print.fsun -----
TOKEN(id, String)
TOKEN(id, message)
TOKEN(=, =)
TOKEN(string, Hello World!)
TOKEN(;, ;)
TOKEN(id, Print)
TOKEN((, ()
TOKEN(id, message)
TOKEN(), ))
TOKEN(;, ;)
----- End of print.fsun -----
```