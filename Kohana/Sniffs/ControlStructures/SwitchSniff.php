<?php
/**
 * Kohana_Sniffs_ControlStructures_SwitchSniff.
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
namespace Kohana\Sniffs\ControlStructures;

use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Throws errors if switch structures do not conform to the coding standard.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class SwitchSniff implements Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_CASE,
            T_DEFAULT,
            T_BREAK
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
        $line = $tokens[$stackPtr]['line'];
        $tokenCount = $phpcsFile->numTokens - 1;

        // Each case, break, and default should be on a separate line
        $start = $end = $stackPtr;
        while ($tokens[$start]['line'] == $line && $start > 0) {
            $start--;
        }
        while ($tokens[$end]['line'] == $line && $end < $tokenCount) {
            $end++;
        }

        $lineTokens = array_slice($tokens, $start, $end - $start + 1, true);
        foreach ($lineTokens as $tokenPtr => $token) {
            switch ($token['type']) {
                case 'T_CASE':
                case 'T_DEFAULT':
                case 'T_BREAK':
                    if ($tokenPtr > $stackPtr) {
                        $error = 'Each case, break, and default should be on a separate line';
                        $phpcsFile->addError($error, $stackPtr, 'Switch');
                    }
            }
        }

        if ($tokens[$stackPtr]['type'] == 'T_BREAK') {
            return;
        }

        // In this context the scope opener is either a colon or semicolon
        $stackPtrScopeOpener = $tokens[$stackPtr]['scope_opener'];

        // Account for typos using ; instead of : on case lines
        if ($tokens[$stackPtrScopeOpener]['type'] === 'T_SEMICOLON') {
            $error = 'Potential use of ; instead of : on a case line';
            $phpcsFile->addWarning($error, $stackPtr, 'Switch');
            return;
        }

        // Code inside case and default blocks should be indented
        for (
            $open = $tokens[$stackPtr]['scope_opener'];
            $tokens[$open]['line'] == $line;
            $open++
        );

        for (
            $close = $tokens[$stackPtr]['scope_closer'];
            $tokens[$close]['line'] == $tokens[$close + 1]['line'];
            $close--
        );

        $indent = $phpcsFile->getTokensAsString($start, $stackPtr - $start);
        $tabCount = substr_count($indent, "\t") + 1;
        $tabString = str_repeat("\t", $tabCount);

        foreach (range($open, $close) as $tokenPtr) {

            // The first condition checks that we're on a new line (so we can check the indent)
            // The second checks to see if there is sufficient indent
            if ($tokens[$tokenPtr]['line'] == $tokens[$tokenPtr - 1]['line'] + 1
                && substr($tokens[$tokenPtr]['content'], 0, $tabCount) != $tabString) {

                // Empty lines are exempt from the indentation rule
                $empty_line = TRUE;

                // We now need to have a look along the line and see if there're any case / default
                // tags in case we're allowing conditions to drop through
                for (
                    $localTokenPtr = $tokenPtr;
                    $tokens[$localTokenPtr]['line'] === $tokens[$localTokenPtr + 1]['line'];
                    $localTokenPtr++
                ) {
                    // If there's a break or default tag on this line then we need to move onto the next line
                    if(in_array($tokens[$localTokenPtr]['type'], array('T_CASE', 'T_DEFAULT'))) {
                        continue 2;
                    }

                    if( ! in_array($tokens[$localTokenPtr]['type'], [
                        'T_WHITESPACE',
                        'T_DOC_COMMENT_OPEN_TAG',
                        'T_DOC_COMMENT_WHITESPACE',
                        'T_DOC_COMMENT_TAG',
                        'T_DOC_COMMENT_STRING',
                        'T_DOC_COMMENT_CLOSE_TAG'
                    ]))
                    {
                        $empty_line = FALSE;
                    }
                }

                // Empty lines are exempt from the indentation rules
                if( ! $empty_line)
                {
                    $phpcsFile->addError('Code inside case and default blocks should be indented', $tokenPtr, 'Switch');
                }
            }
        }
    }
}

?>
