<?php

/**
 * This sniff issues a warning when a \@see tag points to a URL.
 *
 * @category    PHP
 * @package     PHP_CodeSniffer
 * @author      Kohana Team
 * @copyright   (c) 2011 Kohana Team
 * @license     http://kohanaframework.org/license
 */
class Kohana_Sniffs_Commenting_DocBlockSeeSniff implements PHP_CodeSniffer_Sniff
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

        if (preg_match('#^\s+\*\s+@see\s+\S+://#', $content))
        {
            // Text after '@see' has a scheme, a colon and two slashes
            $phpcsFile->addWarning('@see tag should refer to code; use @link for hyperlinks', $stackPtr);
        }
    }
}
