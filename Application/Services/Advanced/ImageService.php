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
     * New image path
     *
     * @var string  $imagePath
     */
    protected $imagePath;

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
     *
     * @return bool
     */
    public function resizeSmall($width = null, $height = null) {

        // set properties
        $width = ($width === null) ? $this->config->resize['small'][0] : $width;
        $height = ($height === null) ? $this->config->resize['small'][1] : $height;

        // resize image
        $image = $this->image->resize($width, $height);

        // process image
        $process = $this->process($image, $this->config->resize['small'][2]);

        // save image
        return ($image->save($process->full, $this->config->resize['small'][3]) != false)
            ? true : false;
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
        $process->path      = $image->getRealpath();
        $process->file      = $spl->getFilename();
        $process->name      = $spl->getBasename('.'.$spl->getExtension()).$name;
        $process->extension = $spl->getExtension();
        $process->full      = $this->imagePath =
            $spl->getPath().DIRECTORY_SEPARATOR.$process->name.'.'.$process->extension;

        return $process;
    }

    /**
     * Get new image path
     * @return string
     */
    public function getImagePath() {
        return $this->imagePath;
    }
}