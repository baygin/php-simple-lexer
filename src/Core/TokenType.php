<?php

namespace SimpleInterpreter\Core;

interface TokenType
{
    const ID     = "id";
    const STRING = "string";
    const QUOTES = "\"";
    const LPAREN = "(";
    const RPAREN = ")";
    const COMMA  = ",";
    const EQUALS = "=";
    const SEMI   = ";";
    const STAR   = "*";
    const DIV    = "/";
    const EOF    = "\0";
}
