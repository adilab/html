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

namespace Adi\Html\Table;

use Adi\Html\AbstractPairedStringTag;

/**
 * A pseudo tag for use in Table class. It represents a column of table and can be render as TH or TD tag. 
 *
 * @author adrian
 */
class Column extends AbstractPairedStringTag {

	/**
	 * Render as TH
	 */
	const TYPE_HEADER = 'th';
	
	/**
	 * Render as TD
	 */
	const TYPE_ROW = 'td';
	
	
	private $type = self::TYPE_ROW;
	
	
	/**
	 * Return tag type: th|td
	 * 
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Set header type
	 * 
	 * @return self
	 */
	public function setHeader() {
		$this->type = self::TYPE_HEADER;
		return $this;
	}


	/**
	 * Set row type
	 * 
	 * @return self
	 */
	public function setRow() {
		$this->type = self::TYPE_ROW;
		return $this;
	}
	
	
	/**
	 * 
	 * @return string
	 */
	public function getName() {
		
		return $this->type;
	}



}
