<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

class JobBoardHelper {

    static function checkProfilePicStatus($uid, $umodel, $mode = 1) {
        $result = array();
        $prof_id = intval($umodel->userProfileExists($uid));
        if ($prof_id > 0) {
            $imgdata = $umodel->getProfileImageByUserId($uid);
            $imgdata->thumbpath = $imgdata->profile_image_path . DS . 'thumbs' . DS . 'thumb48_' . $imgdata->profile_image_name;
            $result['urithumb'] = str_replace('\\', '/', str_ireplace(JPATH_BASE . DS, '', $imgdata->thumbpath));
            switch ($mode) {
                case 1: //48 x 48 thumb only
                    //do nothing
                    break;
                case 2: //include 115 x 115 thumb
                    $imgdata->thumbpath = $imgdata->profile_image_path . DS . 'thumbs' . DS . 'thumb115_' . $imgdata->profile_image_name;
                    $result['urithumb2'] = str_replace('\\', '/', str_ireplace(JPATH_BASE . DS, '', $imgdata->thumbpath));
                    break;
                case 3: //Full picture
                    $result['fullpath'] = $imgdata->profile_image_path . DS . $imgdata->profile_image_name;
                    $result['rootpath'] = $imgdata->profile_image_path;
                    $result['picname'] = $imgdata->profile_image_name;
                    $result['uripath'] = str_replace('\\', '/', str_ireplace(JPATH_BASE . DS, '', $result['fullpath']));
                    break;

            }
            $is_profile_pic = $imgdata->profile_image_present;
        } else {
            $is_profile_pic = 0;
        }
        $result['is_profile_pic'] = $is_profile_pic;

        return $result;
    }

    static function getMonthsList() {
        jimport('joomla.utilities.date');
        $months = array();
        for ($m = 1; $m < 13; $m++) {
            $dt = new JDate('2000-' . sprintf("%02d", $m) . '-01');
            $months[] = $dt->toFormat("%b");
        }

        return $months;
    }

    static function getToday($ym = false) {
        jimport('joomla.utilities.date');
        $format = $ym == true ? '%Y-%m' : '%Y-%m-%d';
        $today_do = new JDate();

        return $today_do->toFormat($format);
    }

    static function getSite($site, $port = 80) {
        $fp = @fsockopen($site, $port, $errno, $errstr, 2);
        $result = !$fp ? false : true;
        @fclose($fp);

        return $result;
    }

    static function byteConvert($bytes) {
        $size = $bytes / 1024;
        if ($size < 1024) {
            $size = number_format($size, 2);
            $size .= ' KB';
        } else {
            if ($size / 1024 < 1024) {
                $size = number_format($size / 1024, 2);
                $size .= ' MB';
            } else if ($size / 1024 / 1024 < 1024) {
                $size = number_format($size / 1024 / 1024, 2);
                $size .= ' GB';
            }
        }

        return $size;
    }

    /**
     * Generate Random key
     **/
    static function randKey() {
        return sprintf(
            '%04x%02x%03x'
            , mt_rand()
            , mt_rand(0, 65535)
            , bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '0100', 11, 4))
        );
    }

    /**
     * Generate Random string
     **/
    static function randStr($s) {
        return sprintf(
            '%03x%02x', $s, mt_rand(0, 65535));
    }

    static function matchHumanCode($string) {
        $app = JFactory::getApplication();

        return (strlen($string) == 0 || $string != $app->getUserState('com_jobboard.humanv')) ? true : false;
    }

    static function renderJobBoard() {
        return base64_decode('PGRpdiBjbGFzcz0iY2xlYXIiPjxzbWFsbD5Qb3dlcmVkIGJ5Jm5ic3A7PGEgaHJlZj0iaHR0cDovL3d3dy50YW5kb2xpbi5jb20iIHRhcmdldD0iX2JsYW5rIj5Kb2IgYm9hcmQgZm9yIEpvb21sYSEgdjEuMi43PC9hPiZuYnNwOzwvc21hbGw+PC9kaXY+');
    }

    static function renderJobBoardx() {
        return base64_decode('PHRhYmxlIHN0eWxlPSJtYXJnaW4tYm90dG9tOiA1cHg7IHdpZHRoOiAxMDAlOyBib3JkZXItdG9wOiB0aGluIHNvbGlkICNlNWU1ZTU7Ij48dGJvZHk+PHRyPjx0ZCBzdHlsZT0idGV4dC1hbGlnbjogbGVmdDsgd2lkdGg6IDMzJTsiPjxoND5BYm91dCBUYW5kb2xpbjwvaDQ+Jm5ic3A7Jm5ic3A7Jm5ic3A7PGEgaHJlZj0iaHR0cDovL2V4dGVuc2lvbnMuam9vbWxhLm9yZy9leHRlbnNpb25zL2Fkcy1hLWFmZmlsaWF0ZXMvam9icy1hLXJlY3J1aXRtZW50LzE0MTE4IiB0YXJnZXQ9Il9ibGFuayI+V3JpdGUgYSBKRUQgcmV2aWV3IGFib3V0IEpvYiBCb2FyZDwvYT48YnIvPiZuYnNwOyZuYnNwOyZuYnNwOzxhIGhyZWY9Imh0dHA6Ly9kZW1vLnRhbmRvbGluLmNvLnphL3RhbmRvbGluLWZvcnVtLmh0bWwiIHRhcmdldD0iX2JsYW5rIj5WaXNpdCBmb3J1bTwvYT48YnIvPkNvbm5lY3Qgb24mbmJzcDsmbmJzcDsmbmJzcDs8YSBocmVmPSJodHRwOi8vYml0Lmx5L3RhbmRvbGluLXR3aXR0ZXIiIHRhcmdldD0iX2JsYW5rIj5Ud2l0dGVyPC9hPiB8Jm5ic3A7Jm5ic3A7Jm5ic3A7PGEgaHJlZj0iaHR0cDovL2JpdC5seS90YW5kb2xpbi1saW5rZWRpbiIgdGFyZ2V0PSJfYmxhbmsiPkxpbmtlZElOPC9hPiB8Jm5ic3A7Jm5ic3A7Jm5ic3A7PGEgaHJlZj0iaHR0cDovL2JpdC5seS90YW5kb2xpbi1mYiIgdGFyZ2V0PSJfYmxhbmsiPkZhY2Vib29rPC9hPjxici8+PC90ZD48dGQgc3R5bGU9InRleHQtYWxpZ246IGNlbnRlcjsgd2lkdGg6IDMzJTsiPkpvYiBCb2FyZCAtIFZlcnNpb24gMS4yLjcgZnJlZTogQSBqb2IgYm9hcmQgY29tcG9uZW50IGZvciBKb29tbGE8YnIvPkNvcHlyaWdodDogJmNvcHk7IDxhIGhyZWY9Imh0dHA6Ly93d3cudGFuZG9saW4uY28uemEiIHRhcmdldD0iX2JsYW5rIj5UYW5kb2xpbjwvYT48L3RkPjx0ZCBzdHlsZT0idGV4dC1hbGlnbjogcmlnaHQ7IHdpZHRoOiAzMyU7cGFkZGluZy10b3A6NXB4Ij48YSBocmVmPSJodHRwOi8vd3d3LnRhbmRvbGluLmNvbSIgdGFyZ2V0PSJfYmxhbmsiPjxpbWcgc3JjPSJjb21wb25lbnRzL2NvbV9qb2Jib2FyZC9pbWFnZXMvdGFuZG9saW5fbG9nby5wbmciPjwvaW1nPjwvYT48L3RkPjwvdHI+PC90Ym9keT48L3RhYmxlPg==');
    }

    static function getCountryName($id) {
        $db = JFactory::getDBO();
        $query = 'SELECT ' . $db->nameQuote('country_name') . ' FROM ' . $db->nameQuote('#__jobboard_countries') . '
            WHERE ' . $db->nameQuote('country_id') . ' = ' . $id;
        $db->setQuery($query);

        return $db->loadResult();

    }

    static function useSecure() {
        $db = JFactory::getDBO();
        $query = 'SELECT ' . $db->nameQuote('secure_login') . ' FROM ' . $db->nameQuote('#__jobboard_config') . '
            WHERE ' . $db->nameQuote('id') . ' = 1';
        $db->setQuery($query);

        return $db->loadResult();
    }

    static function allowRegistration() {
        $db = JFactory::getDBO();
        $query = 'SELECT ' . $db->nameQuote('allow_registration') . ' FROM ' . $db->nameQuote('#__jobboard_config') . '
            WHERE ' . $db->nameQuote('id') . ' = 1';
        $db->setQuery($query);

        return ($db->loadResult() == 1) ? true : false;
    }

    static function verifyLogin() {
        $db = JFactory::getDBO();
        $query = 'SELECT ' . $db->nameQuote('captcha_login') . ' FROM ' . $db->nameQuote('#__jobboard_config') . '
            WHERE ' . $db->nameQuote('id') . ' = 1';
        $db->setQuery($query);

        return ($db->loadResult() == 1) ? true : false;
    }

    static function verifyHumans() {
        $db = JFactory::getDBO();
        $query = 'SELECT ' . $db->nameQuote('captcha_public') . ' FROM ' . $db->nameQuote('#__jobboard_config') . '
            WHERE ' . $db->nameQuote('id') . ' = 1';
        $db->setQuery($query);

        return ($db->loadResult() == 1) ? true : false;
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