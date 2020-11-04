<?php

/**
 * Kohana Coding Standards
 */

use PHP_CodeSniffer\Exceptions\RuntimeException;
use PHP_CodeSniffer\Standards\Squiz;
use PHP_CodeSniffer\Util\Standards;

if (class_exists(Standards::class, true) === false) {
    throw new RuntimeException('Class not found '.Standards::class);
}

/**
 * Kohana Coding Standard.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com> 
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@ 
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_KohanaCodingStandard extends Standards
{
    /**
     * Return a list of external sniffs to include with this standard.
     *
     * The PEAR standard uses some generic sniffs.
     *
     * @return array
     */
    public function getIncludedSniffs()
    {
        return array(
            'Generic.Sniffs.Functions.OpeningFunctionBraceBsdAllmanSniff.php',
            'Generic.Sniffs.NamingConventions.UpperCaseConstantNameSniff.php'
        );
    }
}

?>
