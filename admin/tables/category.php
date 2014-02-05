<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');

class TableCategory extends JTable {

    var $id = null;
    var $type = null;
    var $enabled = null;

    function __construct(&$db) {
        parent::__construct('#__jobboard_categories', 'id', $db);
    }
}

?>
