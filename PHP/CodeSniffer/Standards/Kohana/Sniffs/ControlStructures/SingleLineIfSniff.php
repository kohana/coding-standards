<?php
/**
 * Kohana_Sniffs_ControlStructures_SingleLineIfSniff.
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
 * Throws errors if single-line if statements are used for anything that 
 * does not break normal execution.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_ControlStructures_SingleLineIfSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_IF
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

        // Shift the stack pointer past the if condition
        $tokenPtr = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr);
        $tokenPtr = $tokens[$tokenPtr]['parenthesis_closer'];

        // Find the first non-whitespace token following the if condition
        $tokenPtr = $phpcsFile->findNext(T_WHITESPACE, $tokenPtr + 1, null, true);

        self::check_if_statement($phpcsFile, $stackPtr, $tokens, $tokenPtr);
    }
	
	private static function check_if_statement(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $tokens, $tokenPtr)
	{
	
		switch ($tokens[$tokenPtr]['type']) {
            // Ignore branches that are not single-line
            case 'T_COLON':
            case 'T_OPEN_CURLY_BRACKET':
			
			// Ignore branches that break normal execution
            case 'T_RETURN':
            case 'T_CONTINUE':
            case 'T_BREAK':
            case 'T_THROW':
            case 'T_EXIT':
                return;

            // Ignore comments only after checking the next token
			case 'T_COMMENT':
				$tokenPtr2 = $phpcsFile->findNext(T_WHITESPACE, $tokenPtr + 1, null, true);
				self::check_if_statement($phpcsFile, $stackPtr, $tokens, $tokenPtr2);
				return;
			
			// Generate an error for all other branches
            default:
                $error = 'Single-line if statements should only be used when breaking normal execution';
                $phpcsFile->addError($error, $stackPtr);
        }
	}
}

?>
