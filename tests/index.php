<?php

require_once("vendor/autoload.php");

use SimpleInterpreter\Core\Token;
use SimpleInterpreter\Core\Lexer\{
    Lexer,
    LexerSource
};

$fileList = [
    "print",
];

foreach ($fileList as $file) {
    // Reading source code from .fsun file
    $sourceCode = file_get_contents("./tests/source/{$file}.fsun");

    // Creating LexerSource
    $source = new LexerSource(
        $sourceCode
    );

    // Creating Lexer
    $lexer = new Lexer($source);

    // Tokenizing
    print "----- Tokenizing the file: {$file}.fsun -----\n";
    while (($token = $lexer->GetNextToken())->type !== Token::EOF) {
        print "TOKEN({$token->type}, {$token->value})\n";
    }
    print "----- End of {$file}.fsun -----\n";
}
