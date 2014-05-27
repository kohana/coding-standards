<?php
/**
 * Kohana_Sniffs_NamingConventions_ValidFunctionNameSniff.
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

if (class_exists('PEAR_Sniffs_NamingConventions_ValidFunctionNameSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PEAR_Sniffs_NamingConventions_ValidFunctionNameSniff not found');
}

/**
 * Ensures methods and functions are named correctly.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@ 
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_NamingConventions_ValidFunctionNameSniff extends PHP_CodeSniffer_Standards_AbstractScopeSniff 
{
    // Copied from the base class because it's declared as private there
    protected $_magicMethods = array(
        'construct',
        'destruct',
        'call',
        'callStatic',
        'get',
        'set',
        'isset',
        'unset',
        'sleep',
        'wakeup',
        'toString',
        'set_state',
        'clone',
    );

    // Copied from the base class because it's declared as private there
    protected $_magicFunctions = array(
        'autoload',
    );

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(array(T_CLASS, T_INTERFACE), array(T_FUNCTION), true);
    }

    /**
     * Supporting method to validate a function or method name.
     *
     * @param string $name Name of the function or method to validate
     * @return bool TRUE if the function or method name is valid, FALSE 
     *         otherwise
     */
    protected function isInvalidName($name)
    {
        return !preg_match('#^(?:__)?(?:(?:[a-z_\x7f-\xff][a-z0-9_\x7f-\xff]*)|toString)$#', $name);
    }

    /**
     * Processes the tokens within the scope.
     *
     * @param PHP_CodeSniffer_File $phpcsFile File being processed
     * @param int $stackPtr Position where this token was found
     * @param int $currScope Position of the current scope
     *
     * @return void
     */
    protected function processTokenWithinScope(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $currScope)
    {
        $className  = $phpcsFile->getDeclarationName($currScope);
        $methodName = $phpcsFile->getDeclarationName($stackPtr);

        // Ignore anonymous functions used within a class
        if ( ! $methodName)
            return;

        // Ignore magic methods 
        if (substr($methodName, 0, 2) == '__') {
            $magicPart = substr($methodName, 2);
            if (in_array($magicPart, $this->_magicMethods) === false) {
                 $error = 'Method name "' . $className . '::' . $methodName . '" is invalid; only PHP magic methods should be prefixed with a double underscore';
                 $phpcsFile->addError($error, $stackPtr);
            }
            return;
        }

        // Ignore Iterator methods
        if (preg_match('/^offset(?:Get|Set|Exists|Unset)$/', $methodName)) {
            return;
        }

        // Evaluate all other functions and methods
        if ($this->isInvalidName($methodName)) {
            $error = 'Method name "' . $methodName . '" is not in all lowercase using underscores for word separators';
            $phpcsFile->addError($error, $stackPtr);
        }
    }

    /**
     * Processes the tokens outside the scope.
     *
     * @param PHP_CodeSniffer_File $phpcsFile File being processed
     * @param int $stackPtr Position where this token was found
     * @return void
     */
    protected function processTokenOutsideScope(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $functionName = $phpcsFile->getDeclarationName($stackPtr);

        // Ignore anonymous functions
        if ( ! $functionName)
            return;

        // Ignore magic functions 
        if (substr($functionName, 0, 2) == '__') {
            if (in_array(substr($functionName, 2), $this->_magicFunctions) === false) {
                 $error = "Function name \"$functionName\" is invalid; only PHP magic functions should be prefixed with a double underscore";
                 $phpcsFile->addError($error, $stackPtr);
            }
            return;
        }

        // Ignore internal functions
        $functions = get_defined_functions();
        $functions = $functions['internal'];
        if (in_array($functionName, $functions)) {
            return;
        }

        // Evaluate all other functions and methods
        if ($this->isInvalidName($functionName)) {
            $error = 'Function name "' . $functionName . '" is not in all lowercase using underscores for word separators';
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}

?>
