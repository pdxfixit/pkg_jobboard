<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JobboardModelCareerlevels extends JModel {

    var $_total = null;
    var $_pagination = null;
    var $_search = null;
    var $_query = null;
    var $data = null;

    function __construct() {
        parent::__construct();

        $option = 'com_jobboard';;
        $app = JFactory::getApplication();

        // Get pagination request variables
        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');

        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function getTotal() {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }

        return $this->_total;
    }

    function getPagination() {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
        }

        return $this->_pagination;
    }

    function getData() {
        $app = JFactory::getApplication();

        if (empty($this->data)) {
            $query = $this->_buildQuery();

            $this->data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
            $this->count = $this->getTotal();
            $app->setUserState('com_jobboard.careerlevels.count', $this->count);
        }

        return $this->data;
    }

    function getSearch() {
        if (!$this->_search) {
            $app = JFactory::getApplication();

            $search = $app->getUserStateFromRequest("com_jobboard.careerlevels.search", 'search', '', 'string');
            $this->_search = JString::strtolower($search);
        }

        return $this->_search;
    }

    function _buildQuery() {
        if (!$this->_query) {
            $search = $this->getSearch();
            $this->_query = "SELECT id, description
                    FROM #__jobboard_career_levels ";

            if ($search != '') {
                $fields = array('description');
                $where = array();
                $search = $this->_db->getEscaped($search, true);

                foreach ($fields as $field) {
                    $where[] = $field . " LIKE '%{$search}%'";
                }

                $this->_query .= ' WHERE ' . implode(' OR ', $where);
            }

            $this->_query .= $this->_buildQueryOrderBy();
        }

        return $this->_query;
    }

    /**
     * Builds an ORDER BY clause for the getData query
     * @return string
     */
    function _buildQueryOrderBy() { // get the application and DBO
        $app = JFactory::getApplication();

        $db = $this->getDBO();
        $defaultOrderField = 'description';
        $order = $app->getUserStateFromRequest('com_jobboard.careerlevels.filterOrder', 'filter_order', $defaultOrderField, 'word');
        $orderDirection = $app->getUserStateFromRequest('com_jobboard.careerlevels.filterOrderDirection', 'filter_order_Dir', 'DESC', 'cmd');
        $orderDirection = (strtoupper($orderDirection) == 'ASC') ? 'DESC' : 'ASC';

        return ' ORDER BY ' . $db->nameQuote($order) . " $orderDirection ";
    }

    function deleteCareers($serialised_id_array) {
        $db = $this->getDBO();
        $this->_query = 'DELETE FROM #__jobboard_career_levels'
            . ' WHERE id IN ( ' . $serialised_id_array . ' )';
        $db->setQuery($this->_query);
        $delete_result = $db->Query();
        $delete_result = ($delete_result == true) ? $delete_result : $db->getErrorMsg(true);

        return $delete_result;
    }
}

?>