<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

class JobBoardGuestHelper {

    /**
     * Get default configuration for file uploads
     *
     * @params none
     *
     * @return int
     */
    static function getMaxFileUploadSize() {
        $db = JFactory::getDBO();
        $sql = 'SELECT ' . $db->nameQuote('max_filesize') . '
                          FROM ' . $db->nameQuote('#__jobboard_config') . '
                          WHERE ' . $db->nameQuote('id') . ' = 1';
        $db->setQuery($sql);

        return $db->loadResult();
    }

    function getMaxFilesizeBytes() {
        $max_filesize = self::getMaxFileUploadSize();

        return ($max_filesize * 1024) * 1024;
    }
}

?>