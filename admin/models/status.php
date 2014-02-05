<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JobboardModelStatus extends JModel {

    var $_query = null;

    function getStatuses() {
        $db = JFactory::getDBO();
        $this->_query = "SELECT * FROM #__jobboard_statuses";
        $db->setQuery($this->_query);

        return $db->loadObjectList();
    }

    function getDepartments() {
        $db = JFactory::getDBO();
        $this->_query = "SELECT * FROM #__jobboard_departments";
        $db->setQuery($this->_query);

        return $db->loadObjectList();
    }
}

?>