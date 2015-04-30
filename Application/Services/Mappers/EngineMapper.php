<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Engines;
use Application\Modules\Rest\Exceptions\NotFoundException;
use Application\Modules\Rest\DTO\EngineDTO;
use Phalcon\Http\Request;

/**
 * Class EngineMapper. Actions above application engine
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/EngineMapper.php
 */
class EngineMapper extends AbstractModelCrud {

    /**
     * Logo directory
     *
     * @const
     */
    const LOGO_DIR = 'files/logo';

    /**
     * Get instance of polymorphic object
     *
     * @return Engines
     */
    public function getInstance() {
        return new Engines();
    }

    /**
     * Define used engine
     *
     * @return \Application\Models\Engines $engine
     */
    public function define() {

        $request = $this->getDi()->get('request');
        $engine   =   $this->getInstance()->findFirst("host = '".$request->getHttpHost()."'");

        if($engine === null) {
            throw new NotFoundException([
                'HOST_NOT_FOUND'  =>  'Not found used host'
            ]);
        }

        return $engine;
    }

    /**
     * Read records
     *
     * @param array $credentials credentials
     * @param array $relations related models
     * @return mixed
     */
    public function read(array $credentials = [], array $relations = []) {

        $result = $this->getInstance()->find($credentials);

        if(empty($relations) === false) {
            $result = $this->readRelatedRecords($result, $relations);
        }
        if($result->count() > 0) {

            $transfer = new EngineDTO();

            if($result->count() === 1) {

                $result->getFirst()->logo = $this->setLogoDir($result->getFirst()->logo);

                $row = $result->getFirst();
                if(!$row instanceof \Phalcon\Mvc\Model\Row) {
                    $currency = $row->getCurrency();
                    if(isset($currency) === true) {
                        $transfer->setCurrencies($currency);
                    }
                    $banners = $row->getBanners();

                    if(isset($banners) === true) {
                        $transfer->setBanners($banners);
                    }


                }
            }

            return $transfer->setEngines($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }

    /**
     * Setup logo full path
     *
     * @param string $logo
     * @return string
     */
    private function setLogoDir($logo) {

        $request = $this->getDi()->get('request');

        return
            $request->getScheme().'://'.$request->getHttpHost().DIRECTORY_SEPARATOR.
            self::LOGO_DIR.DIRECTORY_SEPARATOR.$logo;
    }

    /**
     * Read related records
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $resultSet
     * @param array $relations related models
     * @return \Phalcon\Mvc\ModelInterface
     */
    public function readRelatedRecords(\Phalcon\Mvc\Model\Resultset\Simple $resultSet,
                                       array $relations = [])
    {
        foreach($relations as $rel => $credentials) {

            if(isset($resultSet->getFirst()->$rel) === false) {

                $conditions = $this->prepareRelatedConditions($resultSet, $credentials);
                $mapper = $this->getDi()->get(key($credentials['rule']));
                $find = $mapper->getInstance()->find($conditions);

                if($find->count() > 0) {

                    $resultSet->getFirst()->$rel = $mapper->setNestedTree($find->toArray(), 'parent_id');
                }
                else {
                    throw new NotFoundException([
                        'RECORDS_NOT_FOUND'  =>  'The records not found'
                    ]);
                }
            }
            else {
                throw new NotFoundException([
                    'RECORDS_NOT_FOUND'  =>  'The records not found'
                ]);
            }
        }
        return $resultSet;
    }

    /**
     * Prepare related query conditions
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $resultSet
     * @param array $credentials
     * @return array
     */
    public function prepareRelatedConditions(\Phalcon\Mvc\Model\Resultset\Simple $resultSet,
                                             array $credentials) {

        $rules  = $credentials['rule'];
        $mapper = key($rules);
        $modelKey = array_keys($rules[$mapper])[0];
        $relKey = current($rules[$mapper]);
        unset($credentials['rule']);

        if(empty($credentials) === true) {

            $conditions = [
                $relKey .' = '.(int)$resultSet->getFirst()->$modelKey
            ];
        }
        else {
            $conditions = [
                $relKey .' = '.(int)$resultSet->getFirst()->$modelKey. ' AND '
                .$modelKey. ' = '.(int)current($credentials)
            ];
        }

        $conditions[0] .= ' ORDER BY lft, sort';

        return $conditions;
    }
}