<?php
/**
 * Kohana_Sniffs_WhiteSpace_NoConcatenationSpaceSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @author    Chris Bandy <bandy.chris@gmail.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
namespace Kohana\Sniffs\WhiteSpace;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Throws errors if spaces are used on either side of a concatenation 
 * operator. 
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @author    Chris Bandy <bandy.chris@gmail.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class NoConcatenationSpaceSniff implements Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_STRING_CONCAT
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File $phpcsFile All the tokens found in the
     *        document
     * @param int $stackPtr Position of the current token in the stack passed 
     *        in $tokens
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr + 1]['content'] === ' ')
        {
            $fix = $phpcsFile->addFixableError('No space is allowed after concatenation operators', ($stackPtr + 1), 'NoConcatSpace');
            if ($fix === true) {
                $phpcsFile->fixer->replaceToken(($stackPtr + 1), '');
            }
        }

        if ($tokens[$stackPtr - 1]['content'] === ' ')
        {
            $fix = $phpcsFile->addFixableError('No space is allowed before concatenation operators', ($stackPtr + 1), 'NoConcatSpace');
            if ($fix === true) {
                $phpcsFile->fixer->replaceToken(($stackPtr - 1), '');
            }
        }

        // ignore newlines
        if ($tokens[$stackPtr + 1]['code'] === T_WHITESPACE && $tokens[$stackPtr + 1]['content'] !== PHP_EOL)
        {
            $phpcsFile->addError('No space is allowed after concatenation operators', $stackPtr, 'NoConcatSpace');
        }

        // Find the previous token in this statement that is not whitespace
        $prevPtr = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, 0, TRUE, NULL, TRUE);

        if ($prevPtr !== FALSE AND $prevPtr !== ($stackPtr - 1))
        {
            // Previous token is separated by whitespace

            if ($tokens[$prevPtr]['line'] === $tokens[$stackPtr]['line'])
            {
                $phpcsFile->addError('No space is allowed before concatenation operators', $stackPtr, 'NoConcatSpace');
            }
            elseif ($tokens[$prevPtr]['line'] !== ($tokens[$stackPtr]['line'] - 1))
            {
                $phpcsFile->addError('No blank lines are allowed before concatenation operators', $stackPtr, 'NoConcatSpace');
            }
        }
    }
}

?>
