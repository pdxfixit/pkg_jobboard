<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');

class TableUnsolicited extends JTable {

    var $id = null;
    var $request_date = null;
    var $last_updated = null;
    var $job_id = null;
    var $first_name = null;
    var $last_name = null;
    var $email = null;
    var $tel = null;
    var $title = null;
    var $filename = null;
    var $file_hash = null;
    var $cover_note = null;
    var $status = null;

    function __construct(&$db) {
        parent::__construct('#__jobboard_unsolicited', 'id', $db);
    }
}

?>
