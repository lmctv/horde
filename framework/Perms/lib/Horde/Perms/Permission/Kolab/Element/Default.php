<?php
/**
 * Copyright 2006-2013 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Perms
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @link     http://pear.horde.org/index.php?package=Perms
 */

/**
 * Maps a single Horde default permission element to a Kolab_Storage ACL.
 *
 * @category Horde
 * @package  Perms
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @link     http://pear.horde.org/index.php?package=Perms
 */
class Horde_Perms_Permission_Kolab_Element_Default
extends Horde_Perms_Permission_Kolab_Element
{
    /**
     * Get the Kolab_Storage ACL id for this permission.
     *
     * @return string The ACL string.
     */
    public function getId()
    {
        return 'anyone';
    }

    /**
     * Unset the element in the provided permission array.
     *
     * @param array &$current The current permission array.
     */
    public function unsetInCurrent(&$current)
    {
        unset($current['default']);
    }
}
