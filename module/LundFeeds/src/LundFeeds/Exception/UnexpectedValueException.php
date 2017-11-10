<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage Exception
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\Exception;

class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
    /**
    * @param mixed $fileLog
    * @return UnexpectedValueException
    */
    public static function invalidFileLogEntity($fileLog)
    {
        return new static(
            sprintf(
                '%s does not implement LundProducts\Entity\FileLogInterface',
                is_object($fileLog) ? get_class($fileLog) : gettype($fileLog)
            )
        );
    }
}
