<?php
namespace Application\Modules\Backend\Forms;

use Application\Models\Engines;
use Phalcon\Forms\Element;
use Phalcon\Forms\Form;

/**
 * Class EngineForm
 *
 * @package    Application\Modules\Backend
 * @subpackage    Form
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Forms/EngineForm.php
 */
class EngineForm extends Form
{

    /**
     * Currencies key => value
     * @var array
     */
    private $currencies = [];

    /**
     * Statuses key => value
     * @var array
     */
    private $statuses = [];

    /**
     * Initialize form's elements
     * @param null $obj
     * @param mixed $options
     */
    public function initialize($obj = null, $options)
    {
        $this->setEntity($this);

        // create currencies array to Select node
        $this->currencies = $this->getCurrencyList($options['currency']);

        // create statuses array to Select node
        $this->statuses = Engines::$statuses;

        $this->add(new Element\Text("name", [
                'id' => 'name',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getName() : ''
            ])
        );

        $this->add(new Element\TextArea("description", [
                'id' => 'description',
                'value' => (isset($options['default'])) ? $options['default']->getDescription() : ''
            ])
        );

        $this->add(new Element\File("logo", [
                'id' => 'logo-upload',
                'class' => 'file',
                'data-show-upload' => 'false',
                'data-show-caption' => 'true',
            ])
        );

        $this->add(new Element\Text("host", [
                'id' => 'host',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getHost() : ''
            ])
        );

        $this->add(new Element\Text("code", [
                'id' => 'code',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getCode() : ''
            ])
        );

        $this->add((new Element\Select("currency_id", $this->currencies))
                ->setDefault((isset($options['default'])) ? $options['default']->getCurrencyId() : 1)
        );

        $this->add((new Element\Select("status", $this->statuses))
                ->setDefault((isset($options['default'])) ? $options['default']->getStatus() : 1)
        );

        $this->add(new Element\Submit("save", [
                'id' => 'save',
            ])
        );
    }

    /**
     * Create currency list from database
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $currency
     * @return array
     */
    public function getCurrencyList(\Phalcon\Mvc\Model\Resultset\Simple $currency)
    {
        $result = [];

        if($currency->count() > 0) {

            foreach ($currency->toArray() as $v) {
                $result[$v['id']] = $v['name'];
            }
        }

        return $result;
    }
}