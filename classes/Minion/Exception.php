<?php
/**
 * Minion exception
 *
 * @package    Kohana
 * @category   Minion
 * @author     Kohana Team
 * @copyright  (c) 2009-2013 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Minion_Exception extends Kohana_Minion_Exception {

  // this fixes a bug in Kohana 3.3.0 (fixed in 3.3.1) that really should not have been there
	public function format_for_cli() {
		return Kohana_Exception::text($this);
	}

}
