<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/LundProducts for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RocketDam\Service\AssetService;
use Imagine\Gd\Imagine;

/**
 * Imagines controller for admin module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/LundProducts for the canonical source repository
 */
class ImagineController extends AbstractActionController
{
    /**
     * @var \RocketDam\Service\AssetService
     */
    protected $assetService;

    /**
     * @var \Imagine\Gd\Imagine
     */
    protected $imagine;

    /**
     * @param AssetService $assetService
     */
    public function __construct(
        AssetService $assetService,
        Imagine $imagine
    ) {
        $this->assetService = $assetService;
        $this->imagine = $imagine;
    }

    /**
     * Return resized image
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $hash = $this->params()->fromRoute('hash', null);
        $width = $this->params()->fromRoute('width', null);
        $height = $this->params()->fromRoute('height', null);

        $thumbnail = realpath(__DIR__.'/../../../../../public/thumbnails').'/'.$hash.'-'.$width.'-'.$height.'.png';

        if (is_file($thumbnail)) {
            $response = new \Zend\Http\Response\Stream();
            $headers = new \Zend\Http\Headers();
            $headers->addHeaderLine('Content-Type', 'image/png');
            $response->setHeaders($headers);
            $response->setStream(fopen($thumbnail, 'r'));
            /*$response = $this->getResponse();
            $response->setContent(fopen($thumbnail, 'r'));
            $response->getHeaders()
                ->addHeaderLine('Content-Transfer-Encoding', 'binary')
                ->addHeaderLine('Content-Type', 'image/png')
                ->addHeaderLine('Content-Length', filesize($thumbnail));*/
        } else {
            $asset = $this->assetService->getAssetByHash($hash);

            $size = new \Imagine\Image\Box($width, $height);
            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

            $image = $this->imagine->open(realpath(__DIR__.'/../../../../../public/assets').'/'.$asset->getFilePath())
                ->thumbnail($size, $mode)
                ->save($thumbnail);

            /*if ($asset->getWidth() > $asset->getHeight()) {
                $image->resize($image->getSize()->widen($width));
            } else {
                $image->resize($image->getSize()->heighten($height));
            }*/

            //$image->resize(new \Imagine\Image\Box($width, $height), \Imagine\Image\ImageInterface::FILTER_UNDEFINED);

            $response = $this->getResponse();
            $response->setContent($image->get('png'));
            $response->getHeaders()
                ->addHeaderLine('Content-Transfer-Encoding', 'binary')
                ->addHeaderLine('Content-Type', 'image/png')
                ->addHeaderLine('Content-Length', mb_strlen($image->get('png')));
        }

        return $response;
    }
}
