<?php
namespace Application\Modules\Backend\Forms;

use Phalcon\Forms\Element;
use Phalcon\Forms\Form;

/**
 * Class SearcherForm
 *
 * @package    Application\Modules\Backend
 * @subpackage    Form
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Forms/SearcherForm.php
 */
class SearcherForm extends Form
{
    /**
     * Initialize form's elements
     * @param null $obj
     * @param mixed $options
     */
    public function initialize()
    {
        $this->setEntity($this);

        $this->add(new Element\Text("query", [
                'id'            => 'query',
                'placeholder'   =>  'search...',
            ])
        );
    }
}