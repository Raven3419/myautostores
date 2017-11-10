<?php

namespace LundProducts\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LundProducts\Service\Options;

class OptionsFactory implements FactoryInterface
{
    /**
     * Create Options instance from config
     *
     * @param ServiceLocatorInterface $sl
     *
     * @return LundProducts\Service\Options
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $config = $sl->get('Config');

        $options = isset($config['rr_admin']['options']) ?
            $config['rr_admin']['options'] :
            array();

        return new Options($options);
    }
}
