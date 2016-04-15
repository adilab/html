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
 * Helper for Img tag
 *
 * @author adrian
 */
class Img extends AbstractTag {

	/**
	 * Returns instance
	 * 
	 * @param string $url Url of picture
	 * @return self
	 */
	public static function create($url) {

		return parent::__create($url);
	}

	/**
	 * 
	 * @param string $url Url of picture
	 */
	public function __construct($url) {

		parent::__construct();

		$this->setAttribute('src', $url);
	}

	/**
	 * Returns src attribute
	 * 
	 * @return string
	 */
	public function getSrc() {

		return $this->getAttribute('src');
	}

	/**
	 * Set src attribute
	 * 
	 * @param string $url Url of picture
	 * @return self
	 */
	public function setSrc($url) {

		$this->setAttribute('src', $url);
		return $this;
	}

	/**
	 * Returns title attribute
	 * 
	 * @return string
	 */
	public function getTitle() {

		return $this->getAttribute('title');
	}

	/**
	 * Set title attribute
	 * 
	 * @param string $title Title of picture
	 * @return self
	 */
	public function setTitle($title) {

		$this->setAttribute('title', $title);
		return $this;
	}

	/**
	 * Returns alt attribute
	 * 
	 * @return string
	 */
	public function getAlt() {

		return $this->getAttribute('alt');
	}

	/**
	 * Set alt attribute
	 * 
	 * @param string $text Alternative text for picture
	 * @return self
	 */
	public function setAlt($text) {

		$this->setAttribute('alt', $text);
		return $this;
	}

	/**
	 * Creates default alternative text for picture
	 */
	private function createDefaultAlt() {
		
		if (!$alt = trim($this->getSrc())) {
			
			return;
		}
		
		$alt = pathinfo($alt, PATHINFO_FILENAME);
		$alt = ucfirst($alt);
		$alt = trim(str_replace(array('-', '_'), ' ', $alt));
		$this->setAlt($alt);
	}
	
	
	/**
	 * Creates HTML code
	 */
	public function render() {
		
		if (!$this->getAlt()) {
			
			$this->createDefaultAlt();
		}

		return $this->prepareHtml(array('name' => 'Img', 'paired' => FALSE));
	}

}
