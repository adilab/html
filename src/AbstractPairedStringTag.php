<?php

/**
 *
 * AdiPHP : Rapid Development Tools (http://adilab.net)
 * Copyright (c) Adrian Zurkiewicz
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @version     0.1
 * @copyright   Adrian Zurkiewicz
 * @link        http://adilab.net
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Adi\Html;

/**
 * Helper for paired tags with string inner
 *
 * @author adrian
 */
abstract class AbstractPairedStringTag extends AbstractTag {

	/**
	 * Returns Tag name
	 * 
	 * @return string Tag name
	 * 
	 */
	public function getName() {
		
		$name = strtolower(get_called_class());
		$name = explode('\\', $name);
		
		return end($name);
		
	}

	/**
	 * Returns instance
	 * 
	 * @param string $data
	 * @return self
	 */
	public static function create($data = NULL) {

		return parent::__create($data);
	}

	/**
	 *
	 * @var boolean 
	 */
	private $isOb = FALSE;

	/**
	 * Add string to inner html
	 * 
	 * @param string $html
	 */
	public function addData($html) {

		$data = $this->getData();
		$data .= $html;

		$this->setData($data);
	}

	/**
	 * Turn on output buffering
	 * 
	 * @return AbstractPairedStringTag
	 */
	public function obStart() {

		ob_start();
		$this->isOb = TRUE;

		return $this;
	}

	/**
	 * Turn off output buffering and add buffered content
	 * 
	 * @return \Adi\Html\AbstractPairedStringTag
	 */
	public function obStop() {

		if (!$this->isOb) {

			return $this;
		}

		$this->addData(ob_get_contents());

		ob_end_clean();

		$this->isOb = false;

		return $this;
	}

	/**
	 * Creates HTML code
	 */
	public function render() {

		$this->obStop();

		return $this->prepareHtml(array('name' => $this->getName(), 'paired' => TRUE));
	}

}
