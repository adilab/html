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
 * Helper for A tag
 *
 * @author adrian
 */
class A extends AbstractTag {

	/**
	 * Returns instance
	 * 
	 * @param string $url href attribute
	 * @param string $text Tag inner
	 * @return self
	 */
	public static function create($url, $text = NULL) {

		return parent::__create($url, $text);
	}

	/**
	 * 
	 * @param string $url href attribute
	 * @param string $text Tag inner
	 */
	public function __construct($url, $text = NULL) {

		if (!$text) {

			$text = $url;
		}

		parent::__construct($text);

		$this->setAttribute('href', $url);
	}

	/**
	 * Returns href attribute
	 * 
	 * @return string
	 */
	public function getHref() {

		return $this->getAttribute('href');
	}

	/**
	 * Set href attribute
	 * 
	 * @param string $url href attribute
	 * @return self
	 */
	public function setHref($url) {

		$this->setAttribute('href', $url);
		return $this;
	}

	/**
	 * Creates HTML code
	 */
	public function render() {

		return $this->prepareHtml(array('name' => 'a', 'paired' => TRUE));
	}

}
