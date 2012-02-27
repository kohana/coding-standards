<?php
/**
 * Kohana_Sniffs_NamingConventions_LowerCaseComparisonLogicalOperatorSniff.
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
 * Ensures that logical operators names are all lowercase.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_NamingConventions_LowerCaseComparisonLogicalOperatorSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_LOGICAL_AND,
            T_LOGICAL_OR,
            T_LOGICAL_XOR,
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
        $currentToken = $tokens[$stackPtr];
        $registeredTokens = $this->register();

        if (in_array($currentToken['code'], $registeredTokens)) {
            if (! $this->_isLowerCaseTokenContent($currentToken)) {
                $error = 'Use lowercase ' . strtolower($currentToken['content']);
                $phpcsFile->addError($error, $stackPtr);
            }
        }
    }

    /**
     * Checks if the current token's content is a lowercase string.
     *
     * @param array $currentToken
     * @return boolean
     */
    private function _isLowerCaseTokenContent(array $currentToken)
    {
        $tokenContent = $currentToken['content'];
        $lowerCaseTokenContent = strtolower($tokenContent);

        return ($tokenContent === $lowerCaseTokenContent);
    }
}

?>
