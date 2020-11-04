<?php
/**
 * Kohana_Sniffs_Operators_ComparisonOperatorSniff.
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
 * Throws errors if boolean comparison operators are used rather than 
 * logical ones.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class ComparisonOperatorSniff implements Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_BOOLEAN_AND,
            T_BOOLEAN_OR,
            T_IS_GREATER_OR_EQUAL,
            T_IS_SMALLER_OR_EQUAL,
            T_IS_EQUAL,
            T_IS_NOT_EQUAL,
            T_IS_IDENTICAL,
            T_IS_NOT_IDENTICAL,
            T_IS_NOT_EQUAL,
            T_GREATER_THAN,
            T_LESS_THAN
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

        switch ($tokens[$stackPtr]['type']) {
            case 'T_BOOLEAN_AND':
            case 'T_BOOLEAN_OR':
                $error = 'Operators && and || are not allowed, use AND and OR instead';
                $phpcsFile->addError($error, $stackPtr, 'ComparisonOperator');
                break;

            default:
                $beforePtr = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
                $afterPtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
                if ($tokens[$afterPtr]['type'] == 'T_VARIABLE') {
                    switch ($tokens[$beforePtr]['type']) {
                        case 'T_STRING':
                            $beforePtr = $phpcsFile->findPrevious(T_WHITESPACE, $beforePtr - 1, null, true);
                            if ($tokens[$beforePtr]['type'] == 'T_OBJECT_OPERATOR') {
                                break;
                            }
                        case 'T_FALSE':
                        case 'T_TRUE':
                        case 'T_NULL':
                            $error = 'Variables should precede constants in comparison operations';
                            $phpcsFile->addError($error, $stackPtr, 'ComparisonOperator');
                            break;
                    }
                }
                break;
        }
    }
}

?>
