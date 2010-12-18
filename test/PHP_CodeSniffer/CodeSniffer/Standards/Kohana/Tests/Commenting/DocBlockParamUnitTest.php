<?php

/**
 * Unit test class for DocBlockParamSniff.
 *
 * @category    PHP
 * @package     PHP_CodeSniffer
 * @author      Kohana Team
 * @copyright   (c) 2010 Kohana Team
 * @license     http://kohanaframework.org/license
 */
class Kohana_Tests_Commenting_DocBlockParamUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the number of errors that should occur on each line.
     *
     * @return  array   Array of (line => number) pairs
     */
    public function getErrorList()
    {
        return array();
    }

    /**
     * Returns the number of warnings that should occur on each line.
     *
     * @return  array   Array of (line => number) pairs
     */
    public function getWarningList()
    {
        return array(
            4 => 1,
            12 => 1,
        );
    }
}
