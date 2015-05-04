<?php
namespace Application\Modules\Rest\DTO;

use Application\Aware\AbstractDTO;

/**
 * Class ErrorDTO. Data Transfer Object for errors relationships
 *
 * @package Application\Modules\Rest
 * @subpackage DTO
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Rest/ErrorDTO.php
 */
class ErrorDTO extends AbstractDTO
{
    /**
     * Errors collection
     *
     * @var array
     */
    public $errors = [];

    /**
     * Setup errors
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $errors
     * @return \Application\Modules\Rest\DTO\ErrorDTO
     */
    public function setErrors(\Phalcon\Mvc\Model\Resultset\Simple $errors)
    {

        $this->errors = $errors->toArray();
        $this->errors['total'] = $this->total($errors);
        $this->errors['limit'] = $this->limit($errors);
        $this->errors['offset'] = $this->offset();

        return $this;
    }

    /**
     * Reverse object to real array for all public properties
     *
     * @param object $object
     * @return mixed
     */
    public function toArray() {
        return  get_object_vars($this);
    }

}
