<?php
namespace Modules\Frontend\Forms;

use Models\Users;
use Phalcon\Forms\Element;
use Phalcon\Forms\Form;


/**
 * Class SignForm
 * @package    Backend
 * @subpackage    Modules\Frontend\Forms
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Frontend/Forms/SignForm.php
 */
class SignForm extends Form
{

    /**
     * Initialize form's elements
     * @param null $obj
     * @param mixed $options
     */
    public function initialize($obj = null, $options)
    {
        $this->setEntity($this);

        $this->add(new Element\Text("login", [
                'id' => 'login',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getLogin() : ''
            ])
        );

        $this->add(new Element\Password("password", [
                'id' => 'password',
                'required' => 'true',
            ])
        );

        $this->add(new Element\Submit("auth", [
                'id' => 'auth',
            ])
        );
    }
}