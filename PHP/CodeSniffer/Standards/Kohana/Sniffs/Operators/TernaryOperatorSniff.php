<?php
/**
 * Kohana_Sniffs_Operators_TernaryOperatorSniff.
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
class Kohana_Sniffs_Operators_TernaryOperatorSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_INLINE_THEN
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

        // Find the start of the ternary expression 
        // Parentheses surrounding the entire ternary
        // Ex: ($condition ? $true : $false)
        if (!empty($tokens[$stackPtr]['nested_parenthesis'])) {
            $startPtr = key($tokens[$stackPtr]['nested_parenthesis']);
            $endPtr = current($tokens[$stackPtr]['nested_parenthesis']);

        // Ternary is assigned, returned, or output
        // Ex: $foo = $condition ? $true : $false;
        //     return $condition ? $true : $false; 
        //     echo $condition ? $true : $false;
        } else {
            $allowed = array(
                T_EQUAL,
                T_RETURN,
                T_ECHO,
                T_AND_EQUAL,
                T_CONCAT_EQUAL,
                T_DIV_EQUAL,
                T_MINUS_EQUAL,
                T_MOD_EQUAL,
                T_MUL_EQUAL,
                T_OR_EQUAL,
                T_PLUS_EQUAL,
                T_SL_EQUAL,
                T_SR_EQUAL,
                T_XOR_EQUAL
            );
            $startPtr = $phpcsFile->findPrevious($allowed, $stackPtr);
            $endPtr = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);
        }

        // If the ternary is not assigned or returned, error and bail out
        if ($startPtr === false || $tokens[$startPtr]['line'] < $tokens[$stackPtr]['line'] - 1) {
            $error = 'Ternary operations must only occur within properly formatted assignment or return statements';
            $phpcsFile->addError($error, $stackPtr);
            return;
        }

        // Find the colon separating the true and false values
        $colonPtr = $phpcsFile->findNext(T_COLON, $stackPtr + 1);

        // Ensure the colon is on the same or next line, error and bail out if not
        if ($colonPtr === false || $tokens[$colonPtr]['line'] > $tokens[$stackPtr]['line'] + 1) {
            $error = 'Colon must appear on the same or following line of ternary operator';
            $phpcsFile->addError($error, $stackPtr);
            return;
        }

        // Find the token bounds of each part of the ternary expression
        $check = array(
            'condition' => array($startPtr + 1, $stackPtr - 1),
            'true value' => array($stackPtr + 1, $colonPtr - 1),
            'false value' => array($colonPtr + 1, $endPtr - 1)
        );

        // For each part (condition, true value, false value)...
        foreach ($check as $part => $range) {

            // Trim any surrounding whitespace
            $range[0] = $phpcsFile->findNext(T_WHITESPACE, $range[0], null, true);
            $range[1] = $phpcsFile->findPrevious(T_WHITESPACE, $range[1], null, true);

            // Check to see if this part is a simple or complex expression
            $tokenPtr = $phpcsFile->findNext(T_WHITESPACE, $range[0], null, true);
            switch ($tokens[$tokenPtr]['type']) {

                // If the expression is parenthesized, ensure it's not simple
                case 'T_OPEN_PARENTHESIS':
                    $nextPtr = $phpcsFile->findNext(array(T_WHITESPACE, T_VARIABLE), $tokenPtr + 1, null, true);
                    if ($tokens[$nextPtr]['type'] == 'T_CLOSE_PARENTHESIS') {
                        $error = 'Standalone variables should not be parenthesized when used as ternary values'; 
                        $phpcsFile->addError($error, $stackPtr);
                        continue 2;
                    }
                    break;

                // If the expression is an array, ignore it
                case 'T_ARRAY':
                    break;

                // If the expression is a variable, function call, or array/string access, skip past it and continue 
                case 'T_VARIABLE':
                case 'T_STRING':
                case 'T_ISSET':
                case 'T_EMPTY':
                    $nextPtr = $phpcsFile->findNext(T_WHITESPACE, $tokenPtr + 1, null, true);
                    switch ($tokens[$nextPtr]['type']) {
                        case 'T_OPEN_PARENTHESIS':
                            $tokenPtr = $tokens[$nextPtr]['parenthesis_closer'];
                            break;
                        case 'T_OPEN_CURLY_BRACKET':
                            $tokenPtr = $phpcsFile->findNext(T_CLOSE_CURLY_BRACKET, $nextPtr + 1);
                            break;
                        case 'T_OPEN_SQUARE_BRACKET':
                            $tokenPtr = $phpcsFile->findNext(T_CLOSE_SQUARE_BRACKET, $nextPtr + 1);
                            break;
                    }

                // Break if the expression is simple (constant or function call) 
                case 'T_CONSTANT_ENCAPSED_STRING':
                case 'T_DNUMBER':
                case 'T_LNUMBER':
                case 'T_MINUS': // Negative numbers
                    $nextPtr = $phpcsFile->findNext(T_WHITESPACE, $tokenPtr + 1, null, true);
                    if ($nextPtr >= $range[1]) {
                        break;
                    }

                // Expression must be complex and not parenthesized
                default:
                    $error = 'All comparisons and operations in ternary ' . $part . 's must be done inside of a parentheses group';
                    $phpcsFile->addError($error, $stackPtr);
                    break;
            }
        }
    }
}

?>
