<?php
/**
 * Kohana_Sniffs_WhiteSpace_ParenthesesSniff.
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
 * Throws errors if spaces are used improperly around constructs, 
 * parentheses, and some operators.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_WhiteSpace_ParenthesesSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_IF,
            T_ELSE,
            T_ELSEIF,
            T_SWITCH,
            T_WHILE,
            T_FOR,
            T_FOREACH,
            T_OPEN_PARENTHESIS,
            T_CLOSE_PARENTHESIS,
            T_BITWISE_AND,
            T_BOOLEAN_NOT
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

        switch ($tokens[$stackPtr]['type']) {
            case 'T_ELSE':
                $nextPtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
                if ($tokens[$nextPtr]['type'] != 'T_IF') {
                    break;
                }
            case 'T_IF':
            case 'T_ELSEIF':
            case 'T_SWITCH':
            case 'T_WHILE':
            case 'T_FOR':
            case 'T_FOREACH':
                if ($tokens[$stackPtr + 1]['type'] != 'T_WHITESPACE'
                    || $tokens[$stackPtr + 1]['content'] != ' ') {
                    $error = 'Construct names should be separated from opening parentheses by a single space';
                    $phpcsFile->addError($error, $stackPtr);
                }
                break;

            case 'T_OPEN_PARENTHESIS':
                $prevPtr = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
                if ($tokens[$stackPtr + 1]['type'] == 'T_WHITESPACE'
                    && !in_array($tokens[$prevPtr]['type'], array('T_STRING', 'T_ARRAY'))
                    && !in_array($tokens[$stackPtr + 2]['type'], array('T_BITWISE_AND', 'T_BOOLEAN_NOT', 'T_ARRAY_CAST', 'T_BOOL_CAST', 'T_DOUBLE_CAST', 'T_INT_CAST', 'T_OBJECT_CAST', 'T_STRING_CAST', 'T_UNSET_CAST'))) {
                    $error = 'Whitespace after an opening parenthesis is only allowed when !, &, or a typecasting operator immediately follows';
                    $phpcsFile->addError($error, $stackPtr);
                }
                break;

            case 'T_CLOSE_PARENTHESIS':
                $opener = $tokens[$stackPtr]['parenthesis_opener'];
                $prevPtr = $phpcsFile->findPrevious(T_WHITESPACE, $opener - 1, null, true); 
                if (!in_array($tokens[$prevPtr]['type'], array('T_STRING', 'T_ARRAY'))
                    && $tokens[$stackPtr - 1]['type'] == 'T_WHITESPACE') {
                    $error = 'Whitespace before a closing parenthesis is not allowed';
                    $phpcsFile->addError($error, $stackPtr);
                }
                break;

            case 'T_BITWISE_AND':
                // Allow the =& operator 
                $before = $tokens[$stackPtr - 1];
                if($before['type'] === 'T_EQUAL' || $before['content'] === '=') {
                    continue;
                }
            case 'T_BOOLEAN_NOT':
                $before = $tokens[$stackPtr - 1];
                $after = $tokens[$stackPtr + 1];
                if ($before['type'] != 'T_WHITESPACE'
                    || $before['content'] != ' '
                    || $after['type'] != 'T_WHITESPACE'
                    || $after['content'] != ' ') {
                    $error = 'A single space is required on either side of ! and & operators';
                    $phpcsFile->addError($error, $stackPtr);
                }
                break;
        }
    }
}

?>
