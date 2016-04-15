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
 * Helper for HTML tags
 *
 * @author adrian
 */
class Tag extends AbstractTag {
	
	
	/**
	 *
	 * @var string
	 */
	private $name;
	
	
	/**
	 * Returns Tag instance
	 * 
	 * @param string $name Tag name
	 * @param string $data Inner value (only for paired tags)
	 * @return self
	 */
	public static function create($name, $data = NULL) {
		
		return parent::__create($name, $data);
	}	
	
	
	/**
	 * 
	 * @param string $name Tag name
	 * @param string $data Inner value (only for paired tags)
	 */
	public function __construct($name, $data = NULL) {
		
		parent::__construct($data);
		
		$this->name = $name;
	}
	
	/**
	 * Creates HTML code
	 */	
	public function render() {
		
		return $this->prepareHtml(array('name' => $this->name));
	}
	
}
