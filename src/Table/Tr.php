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

use Adi\Html\AbstractPairedArrayTag;
use Adi\Html\Table\Column;
use Adi\Html\Table\Td;
use Adi\Html\Table\Tr;
use Frontend\Exception\Exception;


/**
 * Helper for Tr tag
 *
 * @author adrian
 */
class Tr extends AbstractPairedArrayTag {
	
	/**
	 *
	 * @var Table
	 */
	private $table;
	
	/**
	 *
	 * @var array
	 */
	private $column = array();	

	/**
	 * Add class to tag
	 * 
	 * @param string $class Class or class list as string separated by comma
	 * @return self
	 */
	public function addClass($class) {
		return parent::addClass($class);
	}

	/**
	 * Set value of attribute
	 * 
	 * @param string $name Attribute name
	 * @param  string $value
	 * @return self
	 */
	public function setAttribute($name, $value) {
		return parent::setAttribute($name, $value);
	}

	/**
	 * Set ID value
	 * 
	 * @param string $id
	 * @return self
	 */
	public function setId($id) {
		return parent::setId($id);
	}


	/**
	 * Returns default Column instance
	 * 
	 * @param mixed $name Column name if associative table or index number
	 * @return Column|NULL
	 */
	public function getColumn($name) {
		return @$this->column[$name];
	}

	/**
	 * Set default Column instance
	 * 
	 * @param mixed $name Column name if associative table or index number
	 * @param Column|Td|Tr $column
	 * @return self
	 */
	public function setColumn($name, $column) {
		
		if ((!$column instanceof Column) and (!$column instanceof Td) and (!$column instanceof Td)) {
			
			throw new Exception('The $column parameter must be instance of Column|Td|Th.');
		}
		
		$this->column[$name] = $column;
		return $this;
	}

	/**
	 * Get CSS style value
	 * 
	 * @param string $css Css style string
	 * @return string|NULL
	 */
	public function setStyle($css) {
		return parent::setStyle($css);
	}
	
	/**
	 * Add CSS style
	 * 
	 * @param string $property CSS property
	 * @param string $value CSS value
	 * @return self
	 */
	public function addStyle($property, $value = NULL) {
		return parent::addStyle($property, $value);
	}

	/**
	 * Remove class from tag
	 * 
	 * @param string $class Class or class list as string separated by comma
	 * @return self
	 */
	public function removeClass($class) {
		return parent::removeClass($class);
	}

	/**
	 * Remove CSS style
	 * 
	 * @param string $property CSS property
	 * @return self
	 */
	public function removeStyle($property) {
		return parent::removeStyle($property);
	}

	/**
	 * Returns instance of table 
	 * 
	 * @return Table|NULL
	 */
	public function getTable() {
		return $this->table;
	}

	/**
	 * Set context of rendering
	 * 
	 * @param Table $table
	 * @return self
	 */
	public function setTable(Table $table) {
		$this->table = $table;
		return $this;
	}

	/**
	 * Prepares HTML code of tag
	 * 
	 * @param array $params Parameter not used in this version
	 * @return string
	 */
	protected function prepareHtml($params = array()) {	

		$attributes = $this->prepareAttributes();
		$table = $this->getTable();

		$result = "<tr {$attributes}>";

		foreach ($this->getData() as $name => $data) {
			
			if ($table = $this->getTable()) {
			
				if (count($table->getVisibleColumns())) {

					if (!in_array($name, $table->getVisibleColumns())) {

						continue;
					}

				}
			
			}
			
			if (($data instanceof Column) or ($data instanceof Td)) {
				
				$td = $data;
				
				if ($table) {
					
					$table->importFromColumn($td, $name);
				}
				
			} else {
			
				if ($td = $this->getColumn($name)) {

					$td->setData($data);

				} else {

					$td = new Td($data);
				}

			}

			$result .= $td->render();
		}

		$result .= "</tr>";

		return $result;
	}

	
	/**
	 * 
	 * @return string
	 */
	public function render() {
		
		return $this->prepareHtml();
		
	}

	

}
