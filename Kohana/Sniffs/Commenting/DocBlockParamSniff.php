<?php

/**
 * This sniff issues a warning when a \@param tag lacks the parameter name.
 *
 * @category    PHP
 * @package     PHP_CodeSniffer
 * @author      Kohana Team
 * @copyright   (c) 2010 Kohana Team
 * @license     http://kohanaframework.org/license
 */
class Kohana_Sniffs_Commenting_DocBlockParamSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_DOC_COMMENT
        );
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $content = $tokens[$stackPtr]['content'];

        // Capture text after '@param'
        if (preg_match('/^\s+\*\s+@param\s+(.*)$/', $content, $matches))
        {
            if ( ! preg_match('/^\S+\s+\$\S/', $matches[1]))
            {
                // Second "word" (non-whitespace) does not start with $
                $phpcsFile->addWarning('@param tag should have the parameter name', $stackPtr);
            }
        }
    }
}
