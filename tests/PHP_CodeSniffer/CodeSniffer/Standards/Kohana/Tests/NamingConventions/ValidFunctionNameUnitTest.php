<?php
/**
 * Unit test class for the ValidFunctionName sniff.
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
 * Unit test class for the ValidFunctionName sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com> 
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@ 
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Tests_NamingConventions_ValidFunctionNameUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getErrorList()
    {
        return array(
            6 => 1,
            7 => 1,
            9 => 1,
            10 => 1,
            12 => 1,
            13 => 1,
            14 => 1,
            15 => 1,
            16 => 1,
            18 => 1,
            19 => 1,
            20 => 1,
            22 => 1,
            23 => 1,
            25 => 1,
            26 => 1,
            27 => 1,
            28 => 1,
            29 => 1,
            31 => 1,
            32 => 1,
            33 => 1,
            35 => 1,
            36 => 1,
            38 => 1,
            39 => 1,
            40 => 1,
            41 => 1,
            42 => 1,
            44 => 1,
            45 => 1,
            46 => 1,
            48 => 1,
            49 => 1,
            51 => 1,
            52 => 1,
            53 => 1,
            54 => 1,
            55 => 1,
            57 => 1,
            57 => 1,
            58 => 1,
            59 => 1,
            65 => 1,
            66 => 1,
            68 => 1,
            69 => 1,
            70 => 1,
            71 => 1,
            72 => 1,
            74 => 1,
            75 => 1,
            76 => 1,
            78 => 1,
            79 => 1,
            81 => 1,
            82 => 1,
            83 => 1,
            84 => 1,
            85 => 1,
            87 => 1,
            88 => 1,
            89 => 1,
            91 => 1,
            92 => 1,
            94 => 1,
            95 => 1,
            96 => 1,
            97 => 1,
            98 => 1,
            100 => 1,
            101 => 1,
            102 => 1,
            104 => 1,
            105 => 1,
            107 => 1,
            108 => 1,
            109 => 1,
            110 => 1,
            111 => 1,
            113 => 1,
            114 => 1,
            115 => 1,
            119 => 1,
            120 => 1,
            121 => 1,
            122 => 1,
            123 => 1,
            124 => 1,
            125 => 1,
            126 => 1,
            127 => 1,
            128 => 1,
            129 => 1,
            130 => 1,
            146 => 1,
            147 => 1,
            148 => 1,
            151 => 1,
            152 => 1,
            153 => 1,
            154 => 1,
            155 => 1,
            156 => 1,
            157 => 1,
            158 => 1,
            159 => 1,
            160 => 1,
            161 => 1,
            162 => 1,
            163 => 1,
            165 => 1,
            166 => 1,
            169 => 1,
            170 => 1
        );
    }


    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getWarningList()
    {
        return array();
    }
}

?>
