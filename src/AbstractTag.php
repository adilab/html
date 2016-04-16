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

use Adi\Object\Object;
use Adi\Css\Css;

/**
 * Helper of Tag
 *
 * @author adrian
 */
abstract class AbstractTag extends Object {

	/**
	 *
	 * @var string
	 */
	private $data;	
	
	/**
	 *
	 * @var array
	 */
	private $attributes = array();
	
	/**
	 * Creates HTML code
	 */
	abstract public function render();	
	
	
	/**
	 * 
	 * @return string
	 */
	public function getData() {
		return $this->data;
	}

	
	/**
	 * 
	 * @param string $data
	 * @return Tag
	 */
	public function setData($data) {
		$this->data = $data;
		return $this;
	}

	
	/**
	 * 
	 * @param string $data
	 */
	public function __construct($data = NULL) {
		$this->data = $data;
	}
	
	
	/**
	 * Prepares a string of attributes ready for use in the tag
	 * 
	 * @return string
	 */
	protected function prepareAttributes() {
		
		$result = NULL;
	
		foreach ($this->attributes as $name => $vale) {
			
			$vale = Html::attrString($vale);
			
			$result .= " {$name}='{$vale}'";
		}
		
		return trim($result);
	}
	
	/**
	 * Set value of attribute
	 * 
	 * @param string $name Attribute name
	 * @param  string $value
	 * @return self
	 */
	public function setAttribute($name, $value) {
		
		$this->attributes[$name] = $value;
		return $this;
	}
	
	/**
	 * Returns value of attribute
	 * 
	 * @param string $name Attribute name
	 * @return string|NULL
	 */
	public function getAttribute($name) {
		
		return @$this->attributes[$name];
	}
	
	
	/**
	 * Returns HTML attributes
	 * 
	 * @return array
	 */
	public function getAttributes() {
		
		return $this->attributes;
	}
	
	
	/**
	 * Set ID value
	 * 
	 * @param string $id
	 * @return self
	 */
	public function setId($id) {
		
		return $this->setAttribute('id', $id);
		
	}
	
	
	/**
	 * Set CSS style value. All the earlier styles will be overridden.
	 * 
	 * @param string $css Css style string
	 * @param string $value
	 * @return self
	 */
	public function setStyle($css, $value = NULL) {
		
		$style = new Css();
		
		if ($value)
			$style->set($css, $value);
		else
			$style->set($css);
		
		return $this->setAttribute('style', $style->render());
		
	}	
	
	
	/**
	 * Get CSS style value.
	 * 
	 * @param string $css Css style string
	 * @return string|NULL
	 */
	public function getStyle() {
		
		return $this->getAttribute('style');
		
	}		
	
	
	/**
	 * Add CSS style.
	 * 
	 * @param string $css CSS property or CSS expression string
	 * @param string $value CSS value
	 * @return self
	 */
	public function addStyle($css, $value = NULL) {
		
		$style = new Css($this->getStyle());
		
		if (func_num_args() == 1) {
			
			$style->set($css);
			
		} else {
			
			$style->set($css, $value);
		}
		
		$this->setStyle($style->render());
		return $this;
	}


	/**
	 * Remove CSS style
	 * 
	 * @param string $property CSS property
	 * @return self
	 */
	public function removeStyle($property) {
		
		$css = new Css($this->getStyle($css));
		$css->remove($property);
		$this->setStyle($css->render());
		return $this;
	}


	/**
	 * Returns ID value
	 * 
	 * @return string|NULL
	 */
	public function getId() {
		
		return $this->getAttribute('id');
	}

	
	/**
	 * Add class to tag
	 * 
	 * @param string $class Class or class list as string separated by comma
	 * @return self
	 */
	public function addClass($class) {
		
		$add		= explode(' ', $class);
		$current	= explode(' ', $this->getAttribute('class'));
		
		foreach ($add as $class) {
			
			if (!in_array($class, $current)) {
				
				$current[] = $class;
			}
		}
		
		$this->setAttribute('class', trim(implode(' ', $current)));
		return $this;
	}


	/**
	 * Remove class from tag
	 * 
	 * @param string $class Class or class list as string separated by comma
	 * @return self
	 */
	public function removeClass($class) {
		
		$new		= array();
		$remove		= explode(' ', $class);
		$current	= explode(' ', $this->getAttribute('class'));
		
		foreach ($current as $class) {
			
			if (!in_array($class, $remove)) {
				
				$new[] = $class;
			}
		}
		
		$this->setAttribute('class', trim(implode(' ', $new)));
		return $this;
		
	}


	/**
	 * Prepares HTML code of tag
	 * 
	 * @param array $params Parameters as associative array. Keys: tag => tag name, paired => is paired tag
	 * @return string
	 */
	protected function prepareHtml($params = array()) {
		
		$name = $params['name'];
		$paired = @$params['paired'];
		
		$attributes = $this->prepareAttributes();
		$data = $this->getData();	
		
		if ($paired === NULL) {
			
			$paired = !Html::isUnpaired($name);
		}

		if ($paired) {
			
			return "<{$name} {$attributes}>{$data}</{$name}>";
			
		} else {
			
			return "<{$name} {$attributes} />";
		}

	}


	/**
	 * 
	 * @return string
	 */
	public function __toString() {
	
		return $this->render();
		
	}
	
}
