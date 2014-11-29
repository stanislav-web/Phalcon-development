<?php
namespace Modules\Backend\Forms;

use Models\Engines;
use	Phalcon\Forms\Form,
	Phalcon\Forms\Element;


/**
 * Class AddEngineForm
 * @package 	Backend
 * @subpackage 	Modules\Backend\Forms
 * @since PHP >=5.4
 * @version 1.0
 * @author Stanislav WEB | Lugansk <stanisov@gmail.com>
 * @filesource /apps/Modules/Backend/Forms/AddEngineForm.php
 */
class AddEngineForm extends Form
{
	private
			/**
		 	 * Currencies key => value
		 	 * @var array
		 	 */
			$_currencies	=	[],

			/**
		 	 * Statuses key => value
		 	 * @var array
		 	 */
			$_statuses		=	[];

	/**
	 * Initialize form's elements
	 * @param null $obj
	 * @param mixed $options
	 */
	public function initialize($obj = null,  $options)
	{
		$this->setEntity($this);

		// create currencies array to Select node
		$this->_currencies	=	$this->getCurrencyList($options);

		// create statuses array to Select node
		$this->_statuses	=	Engines::$statuses;

		$this->add(new Element\Text("name", [
				'id'		=>	'name',
				'required'	=>	'true'
			])
		);

		$this->add(new Element\TextArea("description", [
				'id'		=>	'description',
			])
		);

		$this->add(new Element\Text("host", [
				'id'		=>	'host',
				'required'	=>	'true'
			])
		);

		$this->add(new Element\Text("code", [
				'id'		=>	'code',
				'required'	=>	'true'
			])
		);

		$this->add((new Element\Select("currency_id", $this->_currencies))
				->setDefault(1)
		);

		$this->add((new Element\Select("status", $this->_statuses))
				->setDefault(1)
		);

		$this->add(new Element\Submit("save", [
				'id'		=>	'save',
			])
		);
	}

	/**
	 * Create currency list from database
	 * @param \Models\Currency $currency
	 * @return array
	 */
	public function getCurrencyList(\Phalcon\Mvc\Model\Resultset\Simple $currency)
	{
		foreach($currency as $v)
			$this->_currencies[$v->getId()]	=	$v->getName();
		return $this->_currencies;
	}
}