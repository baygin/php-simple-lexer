<?php

namespace SimpleInterpreter\Core;

use SimpleInterpreter\Core\{
    TokenInterface,
    TokenType,
};

class Token implements TokenInterface, TokenType
{
    public string $type;
    public string $value;

    /**
     * Init a new Token
     * @param string $type
     * @param string $value
     * @return Token
     */
    public static function Create(string $type, string $value): Token
    {
        $token = new Token;
        $token->type = $type;
        $token->value = $value;

        return $token;
    }

    /**
     * Init a new Token from string
     * @param string $char
     * @return Token
     */
    public static function GetFromString(string $char): Token
    {
        switch ($char) {
            case '=':
                return Token::Create(self::EQUALS, $char);
            case ';':
                return Token::Create(self::SEMI, $char);
            case '(':
                return Token::Create(self::LPAREN, $char);
            case ')':
                return Token::Create(self::RPAREN, $char);
            case ',':
                return Token::Create(self::COMMA, $char);
        }

        return Token::Create(self::EOF, "\0");
    }
}
