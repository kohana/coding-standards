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
class Kohana_Sniffs_ControlStructures_SwitchSniff implements PHP_CodeSniffer_Sniff
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
     * @param PHP_CodeSniffer_File $phpcsFile All the tokens found in the 
     *        document
     * @param int $stackPtr Position of the current token in the stack passed 
     *        in $tokens
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
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
                        $phpcsFile->addError($error, $stackPtr);
                    }
            }
        }

        if ($tokens[$stackPtr]['type'] == 'T_BREAK') {
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
            if ($tokens[$tokenPtr]['line'] == $tokens[$tokenPtr - 1]['line'] + 1
                && substr($tokens[$tokenPtr]['content'], 0, $tabCount) != $tabString) {
                $phpcsFile->addError('Code inside case and default blocks should be indented', $tokenPtr);
            }
        }
    }
}

?>
