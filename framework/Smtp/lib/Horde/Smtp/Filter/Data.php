<?php
/**
 * Copyright 2013 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @copyright 2013 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Smtp
 */

/**
 * Stream filter to escape output to the SMTP DATA command (RFC 5321
 * [4.1.1.4]).
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @category  Horde
 * @copyright 2013 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Smtp
 */
class Horde_Smtp_Filter_Data extends php_user_filter
{
    /**
     * Last character.
     *
     * @var string
     */
    private $_last = null;

    /**
     * @see stream_filter_register()
     */
    public function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            $consumed += $bucket->datalen;

            // If the first character is '.', need to check if it has to be
            // doubled.
            if (($bucket->data[0] == '.') &&
                (is_null($this->_last) || ($this->_last == "\n"))) {
                $bucket->data = '.' . $bucket->data;
            }

            // EOLs need to be CRLF; double leading periods.
            $bucket->data = preg_replace(
                array("/(?:\r\n|\n|\r(?!\n))/", "/\n\./"),
                array("\r\n", '..'),
                $bucket->data
            );

            $this->_last = $bucket->data[strlen($bucket->data) - 1];

            stream_bucket_append($out, $bucket);
        }

        return PSFS_PASS_ON;
    }

}
