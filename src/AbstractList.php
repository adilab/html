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
 * Helper for list tags
 *
 * @author adrian
 */
abstract class AbstractList extends AbstractPairedArrayTag {
	
	
	/**
	 * Prepares HTML code of tag
	 * 
	 * @param array $params Parameters as associative array. Keys: tag => tag name
	 * @return string
	 */
	protected function prepareHtml($params = array()) {	

		$attributes = $this->prepareAttributes();
		$name = $params['name'];

		$result = "<{$name} {$attributes}>";

		foreach ($this->getData() as $li) {

			$result .= "<li>{$li}</li>";
		}

		$result .= "</{$name}>";

		return $result;
	}

}
