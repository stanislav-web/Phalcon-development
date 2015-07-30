<?php
namespace Application\Services\Mappers;

use Application\Modules\Rest\Exceptions\BadRequestException;
use Uploader\Uploader as FileUploader;

/**
 * Class FileMapper. Actions above application files
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/FileMapper.php
 */
class FileMapper {

    /**
     * Dependency Container
     *
     * @var \Phalcon\Di\FactoryDefault $di
     */
    private $di;

    /**
     * Upload file config
     *
     * @var array $config
     */
    private $config = [];

    /**
     * Init DI
     *
     * @param \Phalcon\Di\FactoryDefault $di
     */
    public function __construct(\Phalcon\Di\FactoryDefault $di) {
        $this->setDi($di);
    }

    /**
     * Get Translate service
     *
     * @return \Translate\Translator|null
     */
    protected function getTranslator() {

        if($this->getDi()->has('TranslateService') === true) {
            return $this->getDi()->get('TranslateService')->assign('errors');
        }

        return null;
    }

    /**
     * Get Dependency container
     *
     * @return \Phalcon\Di\FactoryDefault
     */
    private function getDi()
    {
        return $this->di;
    }

    /**
     * Set dependency container
     *
     * @param \Phalcon\Di\FactoryDefault $di
     * @return \Application\Services\Mappers\FileMapper
     */
    private function setDi(\Phalcon\DiInterface $di)
    {
        $this->di = $di;
        return $this;
    }

    /**
     * Get attributes ( Not need for use in transfer model)
     *
     * @return array
     */
    public function getAttributes()
    {
        return [];
    }

    /**
     * Create configuration params for upload file
     *
     * @param string     $option config option type
     * @param null $directoryId if exist , it mean ID primary for dynamic create directories
     *
     * @return \Application\Services\Mappers\FileMapper
     */
    public function configure($option, $directoryId = null) {

        // get settings from api config
        $this->config = $this->getDi()->getConfig()->api->files[$option]->toArray();

        // configure directory

        if(isset($this->config['directory'])) {
            $this->config['directory'] = (is_null($directoryId) === false)
                ? DOCUMENT_ROOT.strtr($this->config['directory'], [':directoryId' => $directoryId])
                : DOCUMENT_ROOT.$this->config['directory'];
        }

        return $this;
    }

    /**
     * Upload file
     *
     * @return \Uploader\Uploader
     * @throws \Application\Modules\Rest\Exceptions\BadRequestException
     */
    public function upload() {

        $uploader = new FileUploader();
        $uploader->setRules($this->config);
        if($uploader->isValid() === true) {

            // move uploaded file
            $uploader->move();
        }
        else {

            // truncate if has an error
            $uploader->truncate();
            throw new BadRequestException($uploader->getErrors());
        }

        return $uploader;
    }

    /**
     * Append file to mapper ( Not need for use in transfer model)
     *
     * @param array files
     * @param array $params
     * @return array
     */
    public function append(array $files, array $params)
    {
        // checking data
        $this->prepare($files, $params);

        // add mapper to handle file request
        $mapper = $this->getDi()->get($params['mapper']);
        return $mapper->upload($params);
    }

    /**
     * Examine data for uploader
     *
     * @param array files
     * @param array $params
     * @throws BadRequestException
     */
    private function prepare(array $files, array $params) {

        if(empty($files) === true || isset($params['mapper']) === false) {

            throw new BadRequestException([
                'UPLOAD_FILE_ERROR' => $this->getTranslator()->translate('UPLOAD_FILE_ERROR')
            ]);
        }

        foreach($params as $key => $value) {
            if(empty($value) === true) {
                throw new BadRequestException([
                    'EMPTY_UPLOAD_PARAM' => 'Empty adjacent to the upload parameter `'.$key.'`'
                ]);
            }
        }

        if($this->getDi()->has($params['mapper']) === false) {
            throw new BadRequestException([
                'HANDLER_MAPPER_NOT_EXIST' => 'The handle `'.$params['mapper'].'` mapper for upload does not exist'
            ]);
        }
    }
}