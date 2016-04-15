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

use Adi\Css\Css;
use Adi\Html\AbstractPairedArrayTag;
use Adi\Html\AbstractPairedStringTag;
use Exception;




/**
 * Helper for Table tag. Uses an array to generate code of html table. 
 * Array must be composed of nested array where first level items are rows and second level items are cells.
 * First level item can be replaced by instances of Tr class, and second level items can be replaced by instances of Td class.
 * 
 * <code>
 * $data = array(
 * 	array('aaa', 'bbb', Td::create('ccc')->addClass('ccc')),
 * 	array('ddd', 'eee', 'fff'),
 * 	Tr::create(array('ggg', 'hhh', 'iii'))->addClass('selected'),
 * );
 * echo Table::create($data);
 * </code>
 * 
 * <code>
 * $data = array(
 * 	array('A' => 'aaa', 'B' => 'bbb', 'C' => 'ccc'),
 * 	array('A' => 'ddd', 'B' => 'eee', 'C' => 'fff'),
 * 	array('A' => 'ggg', 'B' => 'hhh', 'C' => Td::create('iii')->setId('i')),
 * );
 * $table = new Table($data);
 * $table->setColumn('B', Column::create()->addStyle('color', '#ff0000'));
 * $table->setHeader('B', '[B]');
 * $table->setHeader('C', Th::create('[C]')->addStyle('color', '#0000ff'));
 * echo $table;
 * </code>
 * 
 *
 * @author adrian
 */
class Table extends AbstractPairedArrayTag {

	/**
	 * Default Tr instance
	 *
	 * @var Tr
	 */
	private $tr;

	/**
	 * Default Column instances
	 *
	 * @var array
	 */
	private $column = array();

	/**
	 *
	 * @var array 
	 */
	private $headers = array();
	
	/**
	 *
	 * @var boolean
	 */
	private $show_headers = true;
	
	/**
	 *
	 * @var array 
	 */
	private $visible_columns = array();

	/**
	 * Returns list of visible columns
	 * 
	 * @return array
	 */
	public function getVisibleColumns() {
		return $this->visible_columns;
	}

	/**
	 * Set list of visible columns
	 * 
	 * @param array $visible_columns
	 * @return self
	 */
	public function setVisibleColumns($visible_columns) {
		$this->visible_columns = $visible_columns;
		return $this;
	}

	/**
	 * Set show headers
	 * 
	 * @param boolean $show_headers
	 * @return Table
	 */
	public function showHeaders($show_headers = TRUE) {
		$this->show_headers = $show_headers;
		return $this;
	}

			
	/**
	 * Returns default Tr instance
	 * 
	 * @return Tr|NULL
	 */
	public function getTr() {
		return $this->tr;
	}

	/**
	 * Set default Tr instance
	 * 
	 * @param Tr $tr
	 * @return self
	 */
	public function setTr(Tr $tr) {
		$this->tr = $tr;
		return $this;
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
	 * @param Column $column
	 * @return self
	 */
	public function setColumn($name, Column $column) {
		$this->column[$name] = $column;
		return $this;
	}
	
	/**
	 * Assigns headers
	 * 
	 * @param array $headers
	 */
	public function setHeaders($headers) {

		foreach ($headers as $key => $title) {

			$this->setHeader($key, $title);
		}
	}

	/**
	 * Returns list of columns names as array of strings
	 * 
	 * @return array
	 */
	public function getColumns() {

		$result = array();

		if (!is_array($this->getData())) {

			return $result;
		}

		if (!count($this->getData())) {

			return $result;
		}

		$row = $this->getData();
		$row = $row[0];

		if ($row instanceof Tr) {

			$row = $row->getData();
		}

		foreach ($row as $column => $value) {

			$result[] = $column;
		}

		return $result;
	}

	/**
	 * Returns TRUE if the table has headers
	 * 
	 * @return boolean
	 */
	public function hasHeaders() {
		
		if (!$this->show_headers) {
			
			return FALSE;
		}
		
		if (count($this->headers)) {
		
			return TRUE;
		}
		
		$i = 0;

		foreach ($this->getColumns() as $culumn) {

			if ($culumn !== $i) {

				return TRUE;
			}

			$i++;
		}

		return FALSE;
	}

	/**
	 * Get header of column
	 * 
	 * @param string $column Column name if associative table or index number
	 * @return string|Th|NULL
	 */
	public function getHeader($column) {

		if (!$result = @$this->headers[$column]) {

			$result = $column;
		}

		return $result;
	}

	/**
	 * Set header of column
	 * 
	 * @param string $column Column name if associative table or index number
	 * @param string|Th $headers
	 * @return self
	 */
	public function setHeader($column, $headers) {

		if (is_object($headers)) {

			if (!$headers instanceof Th) {

				throw new Exception('The $headers parameter must be instance of Th.');
			}
		} else {

			$headers = (string) $headers;
		}

		$this->headers[$column] = $headers;
		return $this;
	}

	
	/**
	 * Imports arguments of column
	 * 
	 * @param AbstractPairedStringTag $tag
	 * @param string $column
	 */
	public function importFromColumn(AbstractPairedStringTag $tag, $column) {
		
		if (!$column = $this->getColumn($column)) {
			
			return;
		}
		
		$attributes = $column->getAttributes();
		
		foreach ($attributes as $name => $value) {
			
			$name = strtolower($name);
			
			if ($name == 'class') {
				
				$tag->addClass($value);
				
			} else if ($name == 'style') { 
				
				$css = new Css($column->getStyle());
				$css->set($tag->getStyle());
				$tag->setAttribute('style', $css->render());
				
			} else {
				
				if (!$tag->getAttribute($name)) {
				
					$tag->setAttribute($name, $value);
				}
				
			}
						
		}
	
	}
	
	/**
	 * Prepares tr th html
	 * 
	 * @return string
	 */
	protected function prepareHeaders() {

		$result = NULL;

		foreach ($this->getColumns() as $name) {
			
			if (count($this->visible_columns)) {
				
				if (!in_array($name, $this->visible_columns)) {
					
					continue;
				}
				
			}
			

			$header = $this->getHeader($name);

			if (($header instanceof Column) or ( $header instanceof Th)) {

				$this->importFromColumn($header, $name);
				$result .= $header->render();
			} else {

				if ($column = $this->getColumn($name)) {

					$column->setData($header);
					$column->setHeader();
				} else {

					$column = Th::create($header);
				}

				$result .= $column->render();
			}
		}

		return "<tr class='header'>{$result}</tr>\n";
	}

	/**
	 * Prepares HTML code of tag
	 * 
	 * @param array $params Parameter not used in this version
	 * @return string
	 */
	protected function prepareHtml($params = array()) {

		if (!$tr = $this->getTr()) {

			$tr = new Tr(array());
		}

//		$tr->setVisibleColumns($this->getVisibleColumns());
		$tr->setTable($this);
		
		$attributes = $this->prepareAttributes();
		$columns = $this->getColumns();

		$result = "\n<table {$attributes}>\n";

		if ($this->hasHeaders()) {

			$result .= $this->prepareHeaders();
		}

		foreach ($this->getData() as $row) {

			if (!$row instanceof Tr) {

				$tr->setData($row);
				$row = $tr;				
				
			} else {
				
//				$row->setVisibleColumns($this->getVisibleColumns());
				$row->setTable($this);
				
			}

			foreach ($columns as $name) {

				if (!$row->getColumn($name)) {

					if ($column = $this->getColumn($name)) {

						$column->setRow();
						$row->setColumn($name, $this->getColumn($name));
					}
				}
			}

			$row->addClass('row');
			$result .= $row->render() . "\n";
		}

		$result .= "</table>\n";

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
