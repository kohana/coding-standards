<?php
/**
 * Kohana_Sniffs_Operators_TypeCastingSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Throws errors if type-casting expressions are not spaced properly or if 
 * long forms of type-casting operators are used.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_Operators_TypeCastingSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_ARRAY_CAST,
            T_BOOL_CAST,
            T_DOUBLE_CAST,
            T_INT_CAST,
            T_OBJECT_CAST,
            T_STRING_CAST,
            T_UNSET_CAST
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile All the tokens found in the 
     *        document
     * @param int $stackPtr Position of the current token in the stack passed 
     *        in $tokens
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $before = $tokens[$stackPtr - 1];
        $after = $tokens[$stackPtr + 1];

        if ($before['type'] != 'T_WHITESPACE'
            || $before['content'] != ' '
            || $after['type'] != 'T_WHITESPACE'
            || $after['content'] != ' ') {
            $error = 'Typecast operators must have a space on either side';
            $phpcsFile->addError($error, $stackPtr);
        }

        switch (strtolower($tokens[$stackPtr]['content'])) {
            case '(integer)':
            case '(boolean)':
                $error = '(int) and (bool) should be used instead of (integer) and (boolean)';
                $phpcsFile->addError($error, $stackPtr);
                break;
        }
    }
}

?>
