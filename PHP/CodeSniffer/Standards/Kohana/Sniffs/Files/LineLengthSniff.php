<?php
/**
 * Unit test class for LineLengthSniff.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Andrew Edwards <ae@eventarc.com> 
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@ 
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Kohana_Sniffs_Files_LineLengthSniff extends Generic_Sniffs_Files_LineLengthSniff
{

    /**
     * The number of characters allowed per line. This will give an
     * error if breached. You can set to 0 to disable.
     *
     * @var int
     */
    protected $lineLimit = 80;

    /**
     * This is the absolute line limit allowed. Anything over this will
     * invoke an error. You can set to 0 to disable
     *
     * @var int
     */
    protected $absoluteLineLimit = 120;

}//end class

?>
