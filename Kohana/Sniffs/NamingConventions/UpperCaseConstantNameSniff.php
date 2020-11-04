<?php
/**
 * Kohana_Sniffs_NamingConventions_UpperCaseConstantNameSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: UpperCaseConstantNameSniff.php 291908 2009-12-09 03:56:09Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
namespace Kohana\Sniffs\NamingConventions;


use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff as StandardUpperCaseConstantNameSniff;

/**
 * Kohana_Sniffs_NamingConventions_UpperCaseConstantNameSniff.
 *
 * Ensures that constant names are all uppercase.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.2.2
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class UpperCaseConstantNameSniff extends StandardUpperCaseConstantNameSniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
		T_STRING,
		T_TRUE,
		T_FALSE,
		T_NULL,
		T_LOGICAL_AND,
		T_LOGICAL_OR,
		T_LOGICAL_XOR
	);

    }//end register()

}//end class

?>
