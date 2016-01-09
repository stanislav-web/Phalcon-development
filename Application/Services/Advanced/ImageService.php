<?php
namespace Application\Services\Advanced;

/**
 * Class ImageService. Tools for working with images
 *
 * @package Application\Services
 * @subpackage Advanced
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Advanced/ImageService.php
 */
class ImageService {

    /**
     * @const Imagick adapter
     */
    const Imagick = 'Phalcon\Image\Adapter\Imagick';

    /**
     * @const Gd adpater
     */
    const GD = 'Phalcon\Image\Adapter\GD';

    /**
     * Image library adapter
     *
     * @var \Phalcon\Image\AdapterInterface  $image
     */
    protected $image;

    /**
     * Image's process settings
     *
     * @var array $config
     */
    protected $config = [];

    /**
     * Initialize image adapter
     *
     * @param \Phalcon\Image\AdapterInterface $adapter
     * @param \Phalcon\Config $config
     */
    public function __construct(\Phalcon\Image\AdapterInterface $adapter, \Phalcon\Config $config) {

        $this->image = $adapter;
        $this->config = $config;
    }

    /**
     * Resize image to small sizes
     *
     * @param null $width
     * @param null $height
     * @throws \ImagickException
     * @throws \Exception
     *
     * @return bool|string
     */
    public function resizeSmall($width = null, $height = null) {

        // set properties
        $width = ($width === null) ? $this->config->resize['small'][0] : $width;
        $height = ($height === null) ? $this->config->resize['small'][1] : $height;

        try {
            // resize image
            $image = $this->image->resize($width, $height);

            // process image
            $process = $this->process($image, $this->config->resize['small'][2]);

            // save image
            return ($image->save($process->smallpath, $this->config->resize['small'][3]) != false)
                ? (array)$process : false;
        }
        catch(\Exception $e) {
            if(get_class($this->image) == self::Imagick) {
                throw new \ImagickException($e->getMessage(), $e->getCode());
            }
            else {
                throw new \Exception($e->getMessage(), $e->getCode());

            }
        }
    }


    /**
     * Image process informer
     *
     * @param \Phalcon\Image\AdapterInterface $image
     * @param string                          $name
     *
     * @return \StdClass
     */
    private function process(\Phalcon\Image\AdapterInterface $image, $name = '') {

        $spl = new \SplFileInfo($image->getRealpath());

        $process = new \StdClass();

        $process->name          = $spl->getBasename('.'.$spl->getExtension()).$name.'.'.$spl->getExtension();
        $process->path          = str_ireplace($spl->getBasename(), $process->name, str_ireplace(DOCUMENT_ROOT, '',$image->getRealpath()));
        $process->directory     = dirname($image->getRealpath());
        $process->extension     = $spl->getExtension();
        $process->size          = $spl->getSize();
        $process->smallpath         = $spl->getPath().DIRECTORY_SEPARATOR.$process->name;

        return $process;
    }
}