<?php
/**
 * @package   JobBoard
 * @copyright Copyright (c)2010-2012 Tandolin <http://www.tandolin.com>
 * @license   : GNU General Public License v2 or later
 * ----------------------------------------------------------------------- */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

class JobBoardImageHelper {

    /**
     * Get image
     *
     * @params string
     **/
    function getImage($val) {
        $document = JFactory::getDocument();
        $document->setMimeEncoding('image/jpg');

        $im = @imagecreatetruecolor(100, 40)
            or die('Cannot create image');
        $text_color = imagecolorallocate($im, 233, 14, 91);
        Imagestring($im, 1, 5, 5, $val, $text_color);
        @ImageJPEG($img, null, 100);
        Imagedestroy($im);
    }
}

?>