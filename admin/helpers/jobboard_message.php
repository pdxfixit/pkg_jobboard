<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

class JobBoardMessageHelper {

    static function getMsgId($type) {
        $db = JFactory::getDBO();
        $where = ' WHERE `type` = ' . $db->Quote($type);
        $sql = 'SELECT `id`
              FROM `#__jobboard_emailmsg`
              ' . $where;
        $db->setQuery($sql);

        return $db->loadResult();
    }

    static function getProfName($id) {
        $db = JFactory::getDBO();
        $where = ' WHERE `id` = ' . $id;
        $sql = 'SELECT `profile_name`
              FROM `#__jobboard_cvprofiles`
              ' . $where;
        $db->setQuery($sql);

        return $db->loadResult();
    }

    static function mailInvites($uid) {
        $db = JFactory::getDBO();
        $where = ' WHERE ' . $db->nameQuote('user_id') . ' = ' . $uid;
        $sql = 'SELECT ' . $db->nameQuote('email_invites') . '
              FROM ' . $db->nameQuote('#__jobboard_users') . '
              ' . $where;
        $db->setQuery($sql);

        return ($db->loadResult() == 1) ? true : false;
    }

    static function getUser($uid) {
        $db = JFactory::getDBO();
        $sql = 'SELECT ' . $db->nameQuote('name') . ', ' . $db->nameQuote('email') . '
               FROM ' . $db->nameQuote('#__users') . '
                    WHERE ' . $db->nameQuote('id') . ' = ' . intval($uid);
        $db->setQuery($sql);

        return $db->loadAssoc();
    }

    static function dispatchEmail($from, $fromname, $to_email, $subject, $body, $attachment = null) {
        if (!version_compare(JVERSION, '1.6.0', 'ge'))
            $sendresult = JUtility :: sendMail($from, $fromname, $to_email, $subject, $body, null, null, null, $attachment);
        else
            $sendresult = JFactory::getMailer()->sendMail($from, $fromname, $to_email, $subject, $body, null, null, null, $attachment);

        return $sendresult;
    }

}

?>