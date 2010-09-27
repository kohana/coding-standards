<?php
/**
 * Kohana_Sniffs_Functions_RegularExpressionSniff.
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
 * Throws errors if ternary expressions use parentheses improperly or exceed 
 * 80 characters in length on a single line.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_Functions_RegularExpressionSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_STRING 
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

        // Is this a function call? 
        $prevPtr = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        $nextPtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
        if ($tokens[$prevPtr]['type'] != 'T_FUNCTION'
            && $tokens[$nextPtr]['type'] == 'T_OPEN_PARENTHESIS') {

            // Is this a POSIX function?
            if (preg_match('/^(ereg|spliti?|sql_regcase)$/', $tokens[$stackPtr]['content'])) { 
                $error = 'PCRE (preg) functions are preferred over POSIX (ereg) functions';
                $phpcsFile->addError($error, $stackPtr);

            // Is this a PCRE function?
            } elseif (strpos($tokens[$stackPtr]['content'], 'preg') === 0) {

                // Is the regular expression surrounded by single quotes?
                $nextPtr = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $nextPtr + 1); 
                $content = $tokens[$nextPtr]['content'];
                if (substr($content, 0, 1) == '"') {
                    $error = 'Regular expressions must be surrounded by single quotes';
                    $phpcsFile->addError($error, $stackPtr);
                }

                // Does the regular expression have a EOL hole?
                if (preg_match('/\$\/[^D]*$/', $content)) {
                    $error = 'Regular expression may have an EOL hole and need /D modifier';
                    $phpcsFile->addWarning($error, $stackPtr);
                }

                // Is this function preg_replace?
                if ($tokens[$stackPtr]['content'] != 'preg_replace') {
                    return;
                }

                // Is the replacement surrounded by single quotes?
				// In some cases this functionality is required, hence this is a warning
                $nextPtr = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $nextPtr + 1); 
                $content = $tokens[$nextPtr]['content'];
                if (substr($content, 0, 1) == '"') {
                    $error = 'It is recommended that regular expression replacements are surrounded by single quotes';
                    $phpcsFile->addWarning($error, $stackPtr);
                }

                // Is the replacement using the $n notation for backreferences?
                if (preg_match('/\\\\[0-9]+/', $content)) {
                    $error = 'Backreferences in regular expressions must use $n notation rather than \\n notation';
                    $phpcsFile->addError($error, $stackPtr);
                }
            }
        }
    }
}

?>
