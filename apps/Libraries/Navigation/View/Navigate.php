<?php
namespace Libraries\Navigation\View;
use Helpers\CatalogueTags;

class Navigate {
	/**
	 * Вывод Html
	 * @var string
	 */
	protected $html = '';
	/**
	 * Объект переводчика Translate
	 * @var type
	 */
	protected $t;
	/**
	 * Контейнер с зависимостями
	 * @var type
	 */
	protected $di;
	protected $wrapper = false;
	protected $request = false;
	/**
	 * @todo add acl veryfication
	 * @todo add schedule veryfication
	 *
	 */
	public function __construct()
	{
		if(is_null($this->t))
		{
			$this->di	=	\Phalcon\DI::getDefault();
			$messages = [];
			require $this->di->get('config')->application->messagesDir."/".$this->di->get('session')->get('language')."/layout.php";
			$this->t = new \Phalcon\Translate\Adapter\NativeArray([
				"content" => $messages
			]);
		}
	}

	/**
	 * Translate proxy
	 *
	 * @param type $word
	 * @return string
	 */
	private function _translate($word)
	{
		if(is_null($this->t))
			return $word;

		return $this->t->_($word);
	}

	/**
	 * Create ul elements
	 *
	 * @param type $node
	 */
	private function _generate($node) {
		$class = !is_null($node->getClass()) ? " class='" . $node->getClass() . "' " : '';
		$id = !is_null($node->getId()) ? " id='" . $node->getId() . "'" : '';
		// определяю обертку
		$this->wrapper = !is_null($node->getWrapper()) ? $node->getWrapper() : '';
		$this->html .= "\t<$this->wrapper $class$id>" . PHP_EOL;
		if ($node->hasChilds())
			$this->_generateChilds($node->getChilds());
		$this->html .= "\t</$this->wrapper>" . PHP_EOL;
	}
	/**
	 * Create childs element
	 *
	 * @param type $childs
	 */
	private function _generateChilds($childs) {
		foreach ($childs as $node) {
			$this->_generateElement($node);
		}
	}
	/**
	 * Create one element
	 *
	 * @param type $node
	 */
	private function _generateElement($node) {
		$cssClasses = array();
		if ($node->isActive())
			$cssClasses[] = '';
		if (!is_null($node->getClass()))
			$cssClasses[] = $node->getClass();
		$openSubBlock = $node->getOpen();
		$closeSubBlock = $node->getClose();
		$cssClasses = array_filter($cssClasses);
		$class = count($cssClasses) > 0 ? " class='" . implode(',', $cssClasses) . "'" : '';
		$id = !is_null($node->getId()) ? " id='" . $node->getId() . "'" : '';
		$target = !is_null($node->getTarget()) ? " target='" . $node->getTarget() . "'" : '';
		if(!empty($openSubBlock)) $this->html .= $openSubBlock;
		if((new \Phalcon\Http\Request())->getURI() == $node->getUrl())
		{
			$selected = " selected";
			$class	.=	" class='selected'";
		}
		else $selected = '';
		$this->html .= ($this->wrapper == 'div') ? "\t\t<$this->wrapper $class $id>" . PHP_EOL : false;
		// onclick defined
		$onclick = $node->getClick();
		$onclick = ($onclick != null) ? "onclick=\"".$onclick."\"" : "";
		$this->html .= ($this->wrapper != 'div') ? '<li>' : false;
		$this->html .= "\t\t\t<a title='". $this->_translate($node->getName()) . "' class='".$node->getClassLink().$selected."' ".$onclick." href='" . $node->getUrl() . "' $target>". $this->_translate($node->getName())."</a>" . PHP_EOL;
		if($node->hasChilds())
		{
			if($this->wrapper == 'ul')
			{
				$this->html .= "\t\t<ul class>" . PHP_EOL;
				$this->_generateChilds($node->getChilds());
				$this->html .= "\t\t</ul>" . PHP_EOL;
			}
		}
		$this->html .= ($this->wrapper != 'div') ? '</li>' : false;
		if(!empty($closeSubBlock)) $this->html .= $closeSubBlock;
		// Генерирование дочерних категорий
		if($node->hasChilds())
		{
			if($this->wrapper == 'div')
			{
				$this->html .= "\t\t<div class='submenu'>" . PHP_EOL;
				$this->_generateChilds($node->getChilds());
				$this->html .= "\t\t</div>" . PHP_EOL;
			}
		}
		$this->html .= ($this->wrapper == 'div') ? "\t\t</$this->wrapper>" : false;
	}
	/**
	 * Generate all HTML
	 *
	 * @param type $node
	 * @return string
	 */
	public function toHtml($node) {
		$this->_generate($node);
		return $this->html;
	}
}