<?php
namespace Application\Modules\Backend\Forms;

use Application\Models\Engines;
use Phalcon\Forms\Element;
use Phalcon\Forms\Form;

/**
 * Class CategoryForm
 *
 * @package    Application\Modules\Backend
 * @subpackage    Form
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /Application/Modules/Backend/Forms/CategoryForm.php
 */
class CategoryForm extends Form
{

    /**
     * Available engines (multiple select)
     *
     * @var array
     */
    private $engines = [];

    /**
     * Available categories (for parent)
     *
     * @var array
     */
    private $categories = [];

    /**
     * Initialize form's elements
     *
     * @param null $obj
     * @param mixed $options
     */
    public function initialize($obj = null, $options)
    {
        $this->setEntity($this);

        // get engines array to Select node
        $this->engines = $this->getEngines($options['engines']);

        // get categories array to Select node
        $this->categories = $this->getCategories($options['categories']);

        $this->add(new Element\Text("title", [
                'id' => 'title',
                'required' => 'true',
                'value' => (isset($options['default'])) ? $options['default']->getTitle() : ''
            ])
        );

        $this->add(new Element\TextArea("description", [
                'id' => 'description',
                'value' => (isset($options['default'])) ? $options['default']->getDescription() : ''
            ])
        );

        $this->add((new Element\Select("parent_id[]", $this->categories, ['useEmpty' => true, 'multiple' => true]))
            ->setDefault((isset($options['default'])) ? $options['default']->getParentId() : '')
        );

        $this->add((new Element\Select("engine_id", $this->engines))
            ->setDefault((isset($options['default'])) ? $options['default']->getEngine() : 1)
        );

        $this->add(new Element\Numeric("sort", [
                'id' => 'sort',
                'value' => (isset($options['default'])) ? $options['default']->getSort() : 0
            ])
        );

        $this->add(new Element\Check("visibility", [
                'id' => 'visibility',
                'class' => 'bt',
                'value' => (isset($options['default'])) ? $options['default']->getVisibility() : 1
            ])
        );

        $this->add(new Element\Submit("save", [
                'id' => 'save',
            ])
        );
    }

    /**
     * Get engines list from database
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $currency
     * @return array
     */
    public function getEngines(\Phalcon\Mvc\Model\Resultset\Simple $engines)
    {
        $HelpersService = $this->getDI()->get('tag');
        return ($engines->count() > 0)
            ? $HelpersService->arrayToPair($engines->toArray())
            : [];
    }

    /**
     * Get categories list from database
     *
     * @param \Phalcon\Mvc\Model\Resultset\Simple $currency
     * @return array
     */
    public function getCategories(\Phalcon\Mvc\Model\Resultset\Simple $categories)
    {
        $HelpersService = $this->getDI()->get('tag');

        return ($categories->count() > 0)
            ? $HelpersService->arrayToPair($categories->toArray())
            : [];
    }
}