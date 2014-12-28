<?php
namespace Libraries\Navigation;

/**
 * Navigation viewer class
 * @package Phalcon
 * @subpackage Libraries\Navigation\View
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Libraries/Navigation/Render.php
 */
class Render
{

    protected
        /**
         * Html output
         * @var string
         */
        $_string = '',
        /**
         * Active link class
         * @var string
         */
        $_activeClass = 'active-parent active',

        /**
         * Drop down child list ul class
         * @var string
         */
        $_dropChildClass = 'dropdown-menu',

        /**
         * Drop down child list ul show class
         * @var string
         */
        $_dropChildShowClass = 'show';

    /**
     * Output HTML to view
     *
     * @param string $node
     * @access public
     * @return string HTML
     */
    public function toHtml($node)
    {
        $this->_generate($node);
        return $this->_string;
    }

    /**
     * Create ul elements
     *
     * @param \Libraries\Navigation\Node $node
     * @access private
     * @return null
     */
    private function _generate(\Libraries\Navigation\Node $node)
    {
        $class = !is_null($node->getClass()) ? " class='" . $node->getClass() . "' " : '';
        $id = !is_null($node->getId()) ? " id='" . $node->getId() . "'" : '';

        $this->_string .= "\t<ul$class$id>" . PHP_EOL;

        if ($node->hasChilds())
            $this->_generateChilds($node->getChilds());

        $this->_string .= "\t</ul>" . PHP_EOL;
    }

    /**
     * Create childs element
     *
     * @param object $node
     * @access private
     * @return null
     */
    private function _generateChilds($childs)
    {
        foreach ($childs as $node)
            $this->_generateElement($node);
    }

    /**
     * Create one element
     *
     * @param object $node
     * @access private
     * @return null
     */
    private function _generateElement($node)
    {
        $cssClasses = [];
        $classLink = [];
        $dropDownShow = '';

        if ($node->isActive()) {
            // set active parent wrapper
            $cssClasses[] = $this->_activeClass;
            // set active link
            $classLink[] = $this->_activeClass;
            // set active dropdown list
            $dropDownShow = $this->_dropChildShowClass;
        }
        if ($node->getClassLink()) $classLink[] = $node->getClassLink();


        if ($node->getClass()) $cssClasses[] = $node->getClass();

        $class = count($cssClasses) > 0 ? " class='" . implode(' ', $cssClasses) . "'" : '';

        $classLink = ($node->getClassLink()) ? " class='" . implode(' ', $classLink) . "'" : '';

        $id = !is_null($node->getId()) ? " id='" . $node->getId() . "'" : '';
        $target = !is_null($node->getTarget()) ? " target='" . $node->getTarget() . "'" : '';
        $click = !is_null($node->getClick()) ? " onclick='" . $node->getClick() . "'" : '';

        // generate link and wrapper <li>
        $this->_string .= "\t\t<li$class $id>" . PHP_EOL;
        $this->_string .= "\t\t\t<a " . $classLink . " title='" . $node->getName() . "' " . $click . " href='" . $node->getUrl() . "' $target>";

        $this->_string .= ($node->getIcon()) ? '<i class="' . $node->getIcon() . '"></i>' : '';

        $this->_string .= '<span class="hidden-xs"> ' . $node->getName() . '</span>';

        $this->_string .= "</a>" . PHP_EOL;

        //generate childs

        if ($node->hasChilds()) {
            $ulClass = (!empty($this->_dropChildClass)) ? 'class="' . $this->_dropChildClass . ' ' . $dropDownShow . '"' : '';
            $this->_string .= "\t\t<ul $ulClass>" . PHP_EOL;
            $this->_generateChilds($node->getChilds());
            $this->_string .= "\t\t</ul>" . PHP_EOL;
        }
        $this->_string .= "\t\t</li>" . PHP_EOL;
    }
}