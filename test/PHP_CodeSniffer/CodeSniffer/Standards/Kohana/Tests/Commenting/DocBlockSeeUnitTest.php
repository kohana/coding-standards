<?php

/**
 * Unit test class for DocBlockSeeSniff.
 *
 * @category    PHP
 * @package     PHP_CodeSniffer
 * @author      Kohana Team
 * @copyright   (c) 2011 Kohana Team
 * @license     http://kohanaframework.org/license
 */
class Kohana_Tests_Commenting_DocBlockSeeUnitTest extends AbstractSniffUnitTest
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
            6 => 1,
        );
    }
}
