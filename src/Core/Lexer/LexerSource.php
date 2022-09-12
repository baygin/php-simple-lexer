<?php

namespace SimpleInterpreter\Core\Lexer;

class LexerSource
{
    public string $content;
    public int $length;

    /**
     * Init LexerSource by entering the content
     * @param string $content The source
     */
    public function __construct(string $content)
    {
        $this->content = $content;
        $this->length = strlen($content);
    }
}
