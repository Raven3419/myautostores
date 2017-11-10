<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use LundSite\Entity\ComparisonChartInterface;
use Zend\EventManager\Event;

/**
 * ComparisonChart events.
 */
class ComparisonChartEvent extends Event
{
    const EVENT_CUSTOMERREVIEW_CREATED = 'comparisonChartCreated';
    const EVENT_CUSTOMERREVIEW_EDITED  = 'comparisonChartEdited';
    const EVENT_CUSTOMERREVIEW_DELETED = 'comparisonChartDeleted';

    /**
     * @var ComparisonChartInterface
     */
    protected $comparisonChart;

    /**
     * @param string               $name
     * @param ComparisonChartInterface $comparisonChart
     */
    public function __construct($name, ComparisonChartInterface $comparisonChart)
    {
        parent::__construct($name);
        $this->comparisonChart = $comparisonChart;
    }

    /**
     * @param  ComparisonChartInterface $comparisonChart
     * @return ComparisonChartEvent
     */
    public function setComparisonChart($comparisonChart)
    {
        $this->comparisonChart = $comparisonChart;

        return $this;
    }

    /**
     * @return ComparisonChartInterface
     */
    public function getComparisonChart()
    {
        return $this->comparisonChart;
    }
}
