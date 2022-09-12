<?php

namespace SimpleInterpreter\Core\Lexer;

use SimpleInterpreter\Core\Token;

interface LexerInterface
{
    /**
     * Init lexer by LexerSource
     * @param LexerSource $source The source
     * @return Lexer
     */
    public function __construct(LexerSource $source);

    /**
     * Let's check the content length is still less than the current index 
     * @return bool
     */
    public function IsEndContent(): bool;

    /**
     * Advance one character
     * Increment the current index if not at the end of the content
     * 
     * @return Lexer
     */
    public function Advance(): Lexer;

    /**
     * Advance the character by the entered count
     * Increment the current index by the entered count if not at the end of the content
     * @param int $count
     * @return Lexer
     */
    public function AdvanceMultiple(int $count): Lexer;

    /**
     * Skip the whitespaces
     * @return Lexer
     */
    public function SkipWhitespace(): Lexer;

    /**
     * Skip the inline comment
     * e.g. // comment 
     * @return Lexer
     */
    public function SkipInlineComment(): Lexer;

    /**
     * Skip the block comment
     * e.g. /* comment * / (without space after the star) 
     * @return Lexer
     */
    public function SkipBlockComment(): Lexer;

    /**
     * Collect the ID 
     * e.g. "Hello World!"
     * @return Token
     */
    public function CollectID(): Token;

    /**
     * Collect the string between quotes 
     * e.g. "Hello World!"
     * @return Token
     */
    public function CollectString(): Token;

    /**
     * Get the next character of the content of LexerSource 
     * @return string
     */
    public function GetNextChar(): string;

    /**
     * Get the next token 
     * @return Token
     */
    public function GetNextToken(): Token;
}
