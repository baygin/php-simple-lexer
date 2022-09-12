<?php

namespace SimpleInterpreter\Core\Lexer;

class LexerRule
{
    /**
     * Let's check the ID definition
     * @param string $char The current character of Lexer
     * @return bool
     */
    public static function ID(string $char): bool
    {
        return \IntlChar::isalnum($char) || $char === "_";
    }
}
