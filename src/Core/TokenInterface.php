<?php

namespace SimpleInterpreter\Core;

interface TokenInterface
{
    /**
     * Init a new Token
     * @param string $type
     * @param string $value
     * @return Token
     */
    public static function Create(string $type, string $value): Token;

    /**
     * Init a new Token from string
     * @param string $char
     * @return Token
     */
    public static function GetFromString(string $char): Token;
}
