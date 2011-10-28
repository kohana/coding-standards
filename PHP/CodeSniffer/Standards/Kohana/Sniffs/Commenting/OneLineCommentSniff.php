<?php
/**
 * Kohana_Sniffs_Commenting_OneLineCommentSniff. 
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
 * This sniff prohibits the use of parentheses for constructor calls that 
 * do not accept parameters.
 * 
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_Commenting_OneLineCommentSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_COMMENT
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile File being scanned
     * @param int $stackPtr Position of the current token in the stack
     *        passed in $tokens.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $content = $tokens[$stackPtr]['content'];

        // Allow PHPUnit Code Coverage Ignore tags
        if (preg_match('_^//@codeCoverageIgnore(Start|End)_', $content))
        {
            return;
        }

        if (preg_match('/^\s*(?:\/\/[^ ]|#)/', $content)) {
            $error = 'Single-line comments must begin with "// " (e.g. // My comment)';
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}

?>
