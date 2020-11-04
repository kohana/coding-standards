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
namespace Kohana\Sniffs\Operators;

use PHP_CodeSniffer\Sniffs\Sniff;

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
class TypeCastingSniff implements Sniff
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
     * @param \PHP_CodeSniffer\Files\File $phpcsFile All the tokens found in the
     *        document
     * @param int $stackPtr Position of the current token in the stack passed 
     *        in $tokens
     * @return void
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $before = $tokens[$stackPtr - 1];
        $after = $tokens[$stackPtr + 1];

        if (($after['type'] !== 'T_WHITESPACE' OR $after['content'] !== ' ')
            OR ($before['type'] !== 'T_STRING_CONCAT'
                AND ($before['type'] !== 'T_WHITESPACE' OR $before['content'] !== ' ')
                AND $tokens[$stackPtr]['line'] !== $tokens[$stackPtr - 2]['line'] + 1))
        {
            $error = 'Typecast operators must be first on the line or have a space on either side';
            $fix = $phpcsFile->addFixableError($error, $stackPtr, 'TypeCasting');
            if ($fix === true) {
                if ($after['content'] !== ' ') {
                    $phpcsFile->fixer->addContentB($stackPtr, ' ');
                }
                if ($before['content'] !== ' ') {
                    $phpcsFile->fixer->addContentBefore($stackPtr, ' ');
                }
            }

            // $phpcsFile->addError($error, $stackPtr, 'TypeCasting');
        }

        switch (strtolower($tokens[$stackPtr]['content'])) {
            case '(integer)':
            case '(boolean)':
                $error = '(int) and (bool) should be used instead of (integer) and (boolean)';
                $phpcsFile->addError($error, $stackPtr, 'TypeCasting');
                break;
        }
    }
}

?>
