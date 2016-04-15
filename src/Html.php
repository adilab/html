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



use Adi\Helpers\Structure;
use Adi\Helpers\String;
use Adi\Mvc\Controller\Route;
use Adi\Mvc\Controller\Controller;
use Adi\Helpers\UTF8;
/**
 * Html handler
 *
 *
 *
 * @package adi_base
 * @author Adrian Zurkiewicz (adrian.zurkiewicz@gmail.com)
 * @version 1.0
 *
 */

class Html {
	
	static private $unpairedTags = ['meta','param','link','isindex','input','img','hr','frame','col','br','basefont','base','area'];
	
	
 /*
 | ----------------------------------
 |	closeTags 		(21/02/2014)
 | ----------------------------------
 */ 

 /**
 * Close all open tags.
 *
 * <code>
 * echo HTML::closeTags($html);
 * </code>  
 *
 * @param string $string HTML string
 * @return string
 * 
 */ 	
	
	static public function closeTags($string) {
		
		$string = UTF8::decode($string);
		
		if (!$string = trim($string)) { return NULL; }
		
		$string = "<div id='body-af79f41f-993d-4562-9a09-1c1da54c1c46'>{$string}</div>";
		
		$doc = new \DOMDocument();
		
		$doc->loadHTML($string);
		
		$element = $doc->getElementById('body-af79f41f-993d-4562-9a09-1c1da54c1c46');
		
		if (!$children) { return UTF8::encode($string); } // @FIXME In some versions of PHP $element is NULL.
		
		$children  = $element->childNodes;
		
		$innerHTML = NULL;
		
		foreach ($children as $child) {	$innerHTML .= $element->ownerDocument->saveHTML($child); }
		
		return UTF8::encode($innerHTML);		
		
	} /* -- end of method -- */		

	
	
 /*
 | ----------------------------------
 |	tag 		(29/01/2014)
 | ----------------------------------
 */ 

 /**
 * Renders a tag
 *
 *
 *
 * @param string $name Description
 * @param string $inner Inner HTML
 * @param array $attributes Tag attributes
 * @param array $param Additional parameters:
 * <br>$param['prefix'] : Tag prefix
 * <br>$param['suffix'] : Tag suffix
 * @return string
 * 
 */ 	
	
	static public function tag($name, $inner = NULL, $attributes = array(), $param = array()) {
		
		$name = trim(strtolower($name));

		$is_unpaired = in_array($name, self::getUnpaired());
		
		if (($inner) and ($is_unpaired)) { throw new \Exception("Unpaired tag cannot take inner value"); }
		
		$attr = NULL;
		
		foreach ($attributes as $attribute => $value) {
			
			if (strtolower($attribute) == 'checked') {
				
				$attr .= $value ? " checked " : NULL;
				
			} else {
			
				$value = str_replace("'", '&#39;', $value);

				$attr .= " {$attribute}='{$value}'";
			
			}
			
		}
		

		$prefix = @$param['prefix']; 
		$suffix = @$param['suffix']; 
		

		if ($is_unpaired) {
			
			return "{$prefix}<{$name}{$attr}>{$suffix}";
			
		} else {
			
			return "{$prefix}<{$name}{$attr}>{$inner}</{$name}>{$suffix}";
			
		}
		
		
	} /* -- end of method -- */	
	

	


	/**
	* Returns list of unpaired tags as array
	* 
	* @return array
	*/ 	
	static public function getUnpaired() {

		return self::$unpairedTags;
		
	}
	
	/**
	 * Returns TRUE if is unpaired tag
	 * 
	 * @param string $name
	 * @return boolean
	 */
	static public function isUnpaired($name) {

		$name = trim($name);
		
		return in_array($name, self::getUnpaired());
	}
	

 /*
 | ----------------------------------
 |	attrString		(29/01/2014)
 | ----------------------------------
 */	
	
 /**
 * Returns string ready to put as an attribute of tag
 *
 * <code>
 * $title = Tag::attr_string($title);
 * </code>
 *
 * @param string $string
 * @return string
 */
	
	static public function attrString($string) {
			
		if ((strpos($string, "'") !== false) and (strpos($string, '"') !== false)) {
			
			$string = str_replace("'", '&#180;', $string);
		}
			
		$string = str_replace("'", '&#39;', $string);
		$string = str_replace('"', '&#34;', $string);
			
		return $string;
		
	} /* -- end of method -- */		
	
	
	
	
	
	
	
	
 /*
 | ----------------------------------
 |	a 		(29/01/2014)
 | ----------------------------------
 */ 

 /**
 * Renders A tag
 *
 *
 *
 * @param mixed $url Url as string or as route array (see Route::url() documentation)
 * @param string $text
 * @param array $attributes Tag attributes 
 * @param array $param Additional parameters (see Html::tag() documentation)
 * <br>$param['lang']
 * <br>$param['module']
 * <br>$param['controller']
 * <br>$param['action']
 * <br>$param['params']
 * <br>$param['url_params']
 * @return string
 * 
 */ 	
	
	static public function a($url, $text = NULL, $attributes = array(), $param = array()) {
		
		if (is_array($url)) {
				
				
			if (@$url['module'] === NULL) {
					
				$bt = debug_backtrace(0, 2);
				$module = @$bt[1]['class'];
				$module = trim(strtolower(String::segment('\\', $module, 1)));
					
				if (!$module) {
		
					$module = get_class(Controller::getInstance());
					$module = trim(strtolower(String::segment('\\', $module, 1)));
		
				}
		
		
				if ($module) {
						
					$url['module'] = $module;
		
				} else {
						
					$url['module'] = false;
						
				}
					
			}
				
		}		
		

		if (is_array($url)) { $url = Route::url($url); }
		
		if ($text === NULL) { $text = $url; }
		
		Structure::arrayOverwrite(array('href' => $url), $attributes);
		
		return self::tag('a', $text, $attributes, $param);
		
		
	}
	
	/**
	 * Implode associative array into string of attributes of HTML tag
	 * 
	 * @param array $attributes
	 * @return string
	 */
	static public function implodeAttributes(array $attributes) {
		
		$result = NULL;
		
		foreach ($attributes as $name => $value) {
			
			$name = trim($name);
			$value = trim($value);
			
			if (($name) and ($value)) {
				
				$result .= "{$name}='{$value}' ";
				
			}		
		}
		
		return trim($result);
		
	}

	/**
	* Renders BR tag
	*
	*
	*
	* @param integer $x Number of occurrences, default: 1
	* @param array $attributes Tag attributes 
	* @param array $param Additional parameters (see Html::tag() documentation)
	* @return string
	* 
	*/ 	
	static public function br($x = 1, $attributes = array(), $param = array()) {

		$result = NULL;
		
		for ($i = 0; $i < $x; $i++) {
			
			$result .= self::tag('br', NULL, $attributes, $param);
			
		}
		
		return $result;
	}
	
	

	/**
	* 
	* @param string $inner Inner HTML
	* @param array $attributes Tag attributes
	* @param array $param Additional parameters (see Html::tag() documentation)
	* @return string
	* 
	*/ 	
	static public function __callStatic($name, $arguments) {
		
		$inner = @$arguments[0] ? @$arguments[0] : NULL;
		$attr = @$arguments[1] ? @$arguments[1] : array();
		$param = @$arguments[2] ? @$arguments[2] : array();

		return self::tag($name, $inner, $attr, $param);
		
	} 
	
	
	
	
	
}