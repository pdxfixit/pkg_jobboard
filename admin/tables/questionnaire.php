<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');

class TableQuestionnaire extends JTable {

    var $id = null;
    var $qid = null;
    var $created_by = null;
    var $params = null;
    var $name = null;
    var $title = null;
    var $description = null;
    var $layout = null;
    var $fields = null;

    function __construct(&$db) {
        parent::__construct('#__jobboard_questionnaires', 'id', $db);
    }
}

?>
