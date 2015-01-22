<?php
namespace Modules\Backend\Forms;

use Models\Pages;
use Phalcon\Forms\Element;
use Phalcon\Forms\Form;


/**
 * Class PageForm
 *
 * @package    Backend
 * @subpackage    Modules\Backend\Forms
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Forms/PageForm.php
 */
class PageForm extends Form
{

    /**
     * Initialize form's elements
     *
     * @param null $obj
     * @param mixed $options
     */
    public function initialize($obj = null, $options)
    {
        $this->setEntity($this);

        $this->add(new Element\Text("title", [
                'id' => 'title',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getTitle() : ''
            ])
        );

        $this->add(new Element\TextArea("content", [
                'id' => 'content-page',
                'value' => (isset($options['default'])) ? $options['default']->getContent() : ''
            ])
        );

        $this->add(new Element\Text("alias", [
                'id' => 'alias',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getAlias() : ''
            ])
        );

        $this->add(new Element\Submit("save", [
                'id' => 'save',
            ])
        );
    }
}