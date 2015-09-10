<?php
namespace Application\Services\Mappers;

use Application\Aware\AbstractModelCrud;
use Application\Models\Subscribers;
use Application\Modules\Rest\DTO\SubscribersDTO;
use Application\Modules\Rest\Exceptions\NotFoundException;

/**
 * Class SubscribeMapper. Actions above application subscribers
 *
 * @package Application\Services
 * @subpackage Mappers
 * @since PHP >=5.6
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Services/Mappers/SubscribeMapper.php
 */
class SubscribeMapper extends AbstractModelCrud {

    /**
     * Get instance of polymorphic object
     *
     * @return Subscribers
     */
    public function getInstance() {
        return new Subscribers();
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

        if($result->count() > 0) {
            return (new SubscribersDTO())->setSubscribers($result);
        }

        throw new NotFoundException([
            'RECORDS_NOT_FOUND'  =>  $this->getTranslator()->translate('RECORDS_NOT_FOUND')
        ]);
    }
}