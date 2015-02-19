<?php
namespace Application\Plugins\Breadcrumbs;

use Phalcon\Http\Request;
use Phalcon\Mvc\View;

/**
 * Breadcrumbs chain class
 *
 * @package Application
 * @subpackage Plugins
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanislav WEB
 * @filesource /Application/Plugins/Breadcrumbs.php
 */
class Breadcrumbs
{
    /**
     * Storage elements
     *
     * @var array $elements
     */
    private $elements = [];

    /**
     * Default view dir for breadcrumbs template
     *
     * @var string $viewDir
     */
    private $viewDir = '';

    /**
     * Default view partial template
     *
     * @var string $partialName
     */
    private $partialName = 'breadcrumbs';

    /**
     * Crud separator
     *
     * @var string $separator
     */
    private $separator = '';

    /**
     * Adding items to the chain
     *
     * @param string $caption title
     * @param string $link href (abs, or local)
     * @access public
     * @return this
     */
    public function add($caption, $link = false)
    {
        if ($link == (new Request)->getURI()) $el = ['active' => true, 'link' => $link, 'text' => $caption];
        else $el = ['active' => false, 'link' => $link, 'text' => $caption];
        $this->elements[] = $el;
        return $this;
    }

    /**
     * Set separator between links
     * @param string $value
     * @access public
     * @return this
     */
    public function separator($value)
    {
        $this->separator = $value;
        return $this;
    }

    /**
     * Reset chain method
     * @access public
     * @return null
     */
    public function reset()
    {
        $this->elements = [];
    }

    /**
     * Generating navigation chain
     *
     * @access public
     * @return object Phalcon\Mvc\View -> partial
     */
    public function generate()
    {
        $lastKey = key(array_slice($this->elements, -1, 1, true));
        $this->elements[$lastKey]['active'] = true;

        // set views dir
        $view = $this->setBreadcrumbsView(new View(), dirname(__FILE__) . '/views/');

        return $view;
    }

    /**
     * Setup Breadcrumbs views dir
     * @param string $value
     * @access public
     * @return this
     */
    public function setBreadcrumbsView(View $view, $value)
    {
        $this->viewDir = (string)$value;

        $view->setPartialsDir($this->viewDir);
        $view->partial($this->partialName, [
                'elements' => $this->elements,
                'separator' => $this->separator,
            ]
        );
        return;
    }
}