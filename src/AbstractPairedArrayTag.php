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
 * Helper for paired tags with list as array inner
 *
 * @author adrian
 */
abstract class AbstractPairedArrayTag extends AbstractTag {

	/**
	 *
	 * @var array
	 */
	private $data;
	
	
	/**
	 * Returns instance
	 * 
	 * @param array $data
	 * @return self
	 */
	public static function create($data = array()) {
		
		return parent::__create($data);
	}	
	

	/**
	 * 
	 * @param array $data
	 */
	public function __construct(array $data = array()) {
		$this->data = $data;
	}

	/**
	 * 
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}
	
	
	/**
	 * Add item to tag data
	 * 
	 * @param mixed $item
	 */
	public function addData($item) {
	
		$this->data[] = $item;
	}

	/**
	 * 
	 * @param array $data
	 * @return self
	 */
	public function setData($data) {
		$this->data = $data;
		return $this;
	}



}
