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

                if(isset($result->getFirst()->currency) === true) {
                    $transfer->setCurrencies($result->getFirst()->currency);
                }
            }

            return $transfer->setEngines($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  'The records not found'
        ]);
    }

    /**
     * Prepare related query conditions
     *
     * @param Resultset $resultSet
     * @param array $credentials
     * @return array
     */
    public function prepareRelatedConditions(\Phalcon\Mvc\Model\Resultset\Simple $resultSet, array $credentials) {

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