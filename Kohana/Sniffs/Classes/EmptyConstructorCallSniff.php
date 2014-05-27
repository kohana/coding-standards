<?php
/**
 * Kohana_Sniffs_Classes_EmptyConstructorCallSniff. 
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
class Kohana_Sniffs_Classes_EmptyConstructorCallSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array(
            T_NEW
        );
    }
    
    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile File where the token was found
     * @param int $stackPtr Position in the stack where the token was found
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $open = $phpcsFile->findNext(
            T_OPEN_PARENTHESIS, 
            $stackPtr, 
            null, 
            false, 
            null, 
            true
        );
        
        if ($open !== false
            && $phpcsFile->getTokensAsString($open, 2) == '()') {
            $phpcsFile->addError(
                'Parentheses should not be used in calls to class constructors without parameters',
                 $stackPtr
            );
        }
    }
}

?>
