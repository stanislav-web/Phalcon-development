<?php
namespace Application\Modules\Backend\Forms;

use Phalcon\Forms\Element;
use Phalcon\Forms\Form;

/**
 * Class CurrencyForm
 *
 * @package    Application\Modules\Backend
 * @subpackage    Form
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Forms/CurrencyForm.php
 */
class CurrencyForm extends Form
{

    /**
     * Initialize form's elements
     * @param null $obj
     * @param mixed $options
     */
    public function initialize($obj = null, $options)
    {
        $this->setEntity($this);

        $this->add(new Element\Text("name", [
                'id' => 'name',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getName() : ''
            ])
        );

        $this->add(new Element\Text("symbol", [
                'id' => 'symbol',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getSymbol() : ''
            ])
        );

        $this->add(new Element\Text("code", [
                'id' => 'code',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getCode() : ''
            ])
        );

        $this->add(new Element\Submit("save", [
                'id' => 'save',
            ])
        );
    }
}