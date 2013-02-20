<?php
namespace simtpl\controls;
use simtpl\exceptions;

/**
 * Table control
 */
class table extends base {
	protected $rows;
	protected $header;
	protected $striped;
	protected $bordered;
	protected $hover;
	protected $compact;

	public function __construct($rows = array(), $header = null, $striped = false, $bordered = false, $hover = false, $compact = false) {
		$rows = is_array($rows) ? $rows : array($rows);
		$this->rows = array();
		foreach($rows as &$row) {
			if($row instanceof table\row) {
				$this->rows[] = $row;
			} else {
				throw new exceptions\source("Row is not instance of \\simtpl\\controls\\table\\row for table control");
			}
		}
		if($header instanceof table\row || is_null($header)) {
			$this->header = $header;
		} else {
			throw new exceptions\source("Header is not instance of \\simtpl\\controls\\table\\row for table control");
		}
		$this->addAttributes(array('class' => 'simtpl-table'));
		$this->addAttributes(array('class' => 'table'));
		$this->striped = $striped;
		$this->bordered = $bordered;
		$this->hover = $hover;
		$this->compact = $compact;
	}

	public function setStriped($striped) {
		$this->striped = $striped;
	}

	public function setBordered($bordered) {
		$this->bordered = $bordered;
	}

	public function setHover($hover) {
		$this->hover = $hover;
	}

	public function setCompact($compact) {
		$this->compact = $compact;
	}

	public function setHeader($header) {
		if($header instanceof table\row || is_null($header)) {
			$this->header = $header;
		} else {
			throw new exceptions\source("Header is not instance of \\simtpl\\controls\\table\\row for table control");
		}
	}

	public function addRow($row) {
		if($row instanceof table\row) {
			$this->rows[] = $row;
		} else {
			throw new exceptions\source("Row is not instance of \\simtpl\\controls\\table\\row for table control");
		}
	}


}

?>