<?php
namespace Plugins\Breadcrumbs;
use Phalcon\Mvc\View,
	Phalcon\Http\Request;

/**
 * Breadcrumbs chain class
 * @package Phalcon
 * @subpackage Plugins
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @copyright Stanilav WEB
 * @filesource /apps/Plugins/Breadcrumbs.php
 */
class Breadcrumbs {

	/**
	 * Set of storage elements
	 * @var array
	 * @access private
	 */
	private 	$_elements		=	[],
				$_viewDir		=	false,
				$_partialName	=	'breadcrumbs',
				$_separator		=	false;

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
		if($link == (new Request)->getURI()) $el = ['active' => true, 'link'   => $link, 'text'   => $caption];
		else $el = ['active' => false, 'link'   => $link, 'text'   => $caption];
		$this->_elements[] = $el;
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
		$this->_separator = $value;
		return $this;
	}

	/**
	 * Setup Breadcrumbs views dir
	 * @param string $value
	 * @access public
	 * @return this
	 */
	public function setBreadrumbsView(View $view, $value)
	{
		$this->_viewDir = (string)$value;

		$view->setPartialsDir($this->_viewDir);
		$view->partial($this->_partialName, [
				'elements'	=>	$this->_elements,
				'separator'	=>	$this->_separator,
			]
		);
		return;
	}

	/**
	 * Reset chain method
	 * @access public
	 * @return null
	 */
	public function reset()
	{
		$this->_elements = [];
	}

	/**
	 * Generating navigation chain
	 *
	 * @access public
	 * @return object Phalcon\Mvc\View -> partial
	 */
	public function generate()
	{
		$lastKey = key(array_slice($this->_elements, -1, 1, true));
		$this->_elements[$lastKey]['active'] = true;

		// set views dir
		$view = $this->setBreadrumbsView(new View(), dirname(__FILE__) .'/views/');

		return $view;
	}
}