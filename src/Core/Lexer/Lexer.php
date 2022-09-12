<?php

namespace SimpleInterpreter\Core\Lexer;

use SimpleInterpreter\Core\Token;
use SimpleInterpreter\Core\Lexer\LexerInterface;

class Lexer implements LexerInterface
{
    public string         $current_char;
    public int            $current_index = 0;
    public int            $current_line  = 1;
    public LexerSource    $source;

    /**
     * Init lexer by LexerSource
     * @param LexerSource $source The source
     * @return Lexer
     */
    public function __construct(LexerSource $source)
    {
        $this->source = $source;
        $this->current_char = $this->source->content[$this->current_index];
    }

    /**
     * Let's check the content length is still less than the current index 
     * @return bool
     */
    public function IsEndContent(): bool
    {
        return !($this->current_index < $this->source->length);
    }

    /**
     * Advance one character
     * Increment the current index if not at the end of the content
     * 
     * @return Lexer
     */
    public function Advance(): Lexer
    {
        $this->current_index++;

        if (!$this->IsEndContent()) {
            $this->current_char = $this->source->content[$this->current_index];
        }

        return $this;
    }

    /**
     * Advance the character by the entered count
     * Increment the current index by the entered count if not at the end of the content
     * @param int $count
     * @return Lexer
     */
    public function AdvanceMultiple(int $count): Lexer
    {
        for ($i = 0; ($i < $count && !$this->IsEndContent()); $i++) {
            $this->current_index++;
            $this->current_char = $this->source->content[$this->current_index];
        }

        return $this;
    }

    /**
     * Skip the whitespaces
     * @return Lexer
     */
    public function SkipWhitespace(): Lexer
    {
        while (!$this->IsEndContent() && ($this->current_char === ' ' || $this->current_char === "\n")) {
            $this->Advance();
        }

        return $this;
    }

    /**
     * Skip the inline comment
     * e.g. // comment 
     * @return Lexer
     */
    public function SkipInlineComment(): Lexer
    {
        while ($this->source->content[$this->current_index] !== "\n") {
            $this->Advance();
        }

        return $this;
    }

    /**
     * Skip the block comment
     * e.g. /* comment * / (without space after the star) 
     * @return Lexer
     */
    public function SkipBlockComment(): Lexer
    {
        while (
            $this->source->content[$this->current_index] !== Token::STAR
            ||
            $this->GetNextChar() !== Token::DIV
        ) {
            $this->Advance();
        }

        $this->AdvanceMultiple(2);

        return $this;
    }

    /**
     * Collect the ID 
     * e.g. "Hello World!"
     * @return Token
     */
    public function CollectID(): Token
    {
        $id = "";

        while (LexerRule::ID($this->current_char)) {
            $id .= $this->current_char;

            $this->Advance();
        }

        return Token::Create(Token::ID, $id);
    }

    /**
     * Collect the string between quotes 
     * e.g. "Hello World!"
     * @return Token
     */
    public function CollectString(): Token
    {
        $string = "";

        $this->Advance();

        while ($this->current_char !== Token::QUOTES) {
            $string .= $this->current_char;

            if ($this->IsEndContent()) {
                // ...
            }

            $this->Advance();
        }

        $this->Advance();

        return Token::Create(Token::STRING, $string);
    }

    /**
     * Get the next character of the content of LexerSource 
     * @return string
     */
    public function GetNextChar(): string
    {
        return $this->source->content[$this->current_index + 1];
    }

    /**
     * Get the next token 
     * @return Token
     */
    public function GetNextToken(): Token
    {
        while (!$this->IsEndContent()) {

            // Skip whitespace
            if ($this->current_char == ' ' || $this->current_char === "\n") {
                // Increments current line
                if ($this->current_char === "\n") {
                    $this->current_line++;
                }

                $this->SkipWhitespace();
            }

            // Skip comments
            if ($this->current_char === Token::DIV) {
                if ($this->GetNextChar() === Token::DIV) {
                    $this->SkipInlineComment();
                } else if ($this->GetNextChar() === Token::STAR) {
                    $this->SkipBlockComment();
                }
            }

            // ID
            if (LexerRule::ID($this->current_char)) {
                return $this->CollectID();
            }

            // String
            if ($this->current_char === Token::QUOTES) {
                return $this->CollectString();
            }

            switch ($this->current_char) {
                case TOKEN::EQUALS:
                case TOKEN::SEMI:
                case TOKEN::LPAREN:
                case TOKEN::RPAREN:
                case TOKEN::COMMA:
                    $token = Token::GetFromString($this->current_char);
                    $this->Advance();
                    return $token;
            }
        }

        return Token::Create(Token::EOF, "\0");
    }
}
