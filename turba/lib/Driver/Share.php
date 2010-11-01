<?php
/**
 * The Turba_Driver:: class provides a common abstracted interface to the
 * various directory search drivers.  It includes functions for searching,
 * adding, removing, and modifying directory entries.
 *
 * Copyright 2009-2010 The Horde Project (http://www.horde.org)
 *
 * See the enclosed file LICENSE for license information (ASL).  If you did
 * did not receive this file, see http://www.horde.org/licenses/asl.php.
 *
 * @author   Chuck Hagenbuch <chuck@horde.org>
 * @author   Jon Parise <jon@csh.rit.edu>
 * @category Horde
 * @license  http://www.horde.org/licenses/asl.php ASL
 * @package  Turba
 */
class Turba_Driver_Share extends Turba_Driver
{
    /**
     * Horde_Share object for this source.
     *
     * @var Horde_Share
     */
    protected $_share;

    /**
     * Underlying driver object for this source.
     *
     * @var Turba_Driver
     */
    protected $_driver;

    /**
     * Checks if this backend has a certain capability.
     *
     * @param string $capability  The capability to check for.
     *
     * @return boolean  Supported or not.
     */
    public function hasCapability($capability)
    {
        return $this->_driver->hasCapability($capability);
    }

    /**
     * Checks if the current user has the requested permissions on this
     * address book.
     *
     * @param integer $perm  The permission to check for.
     *
     * @return boolean  True if the user has permission, otherwise false.
     */
    public function hasPermission($perm)
    {
        return $this->_share->hasPermission($GLOBALS['registry']->getAuth(), $perm);
    }

    /**
     * Return the name of this address book.
     *
     * @string Address book name
     */
    public function getName()
    {
        $share_parts = explode(':', $this->_share->getName());
        return array_pop($share_parts);
    }

    /**
     * Return the owner to use when searching or creating contacts in
     * this address book.
     *
     * @return string  TODO
     * @throws Turba_Exception
     */
    protected  function _getContactOwner()
    {
        $params = @unserialize($this->_share->get('params'));
        if (!empty($params['name'])) {
            return $params['name'];
        }

        throw new Turba_Exception(_("Unable to find contact owner."));
    }

    /**
     * @throws Turba_Exception
     */
    protected function _init()
    {
        $this->_share = &$this->_params['config']['params']['share'];
        $this->_driver = Turba_Driver::factory($this->_name, $this->_params['config']);
    }

    /**
     * Searches the address book with the given criteria and returns a
     * filtered list of results. If the criteria parameter is an empty array,
     * all records will be returned.
     *
     * @param array $criteria  Array containing the search criteria.
     * @param array $fields    List of fields to return.
     *
     * @return array  Hash containing the search results.
     * @throws Turba_Exception
     */
    protected function _search($criteria, $fields)
    {
        return $this->_driver->_search($criteria, $fields);
    }

    /**
     * Searches the current address book for duplicate entries.
     *
     * Duplicates are determined by comparing email and name or last name and
     * first name values.
     *
     * @return array  A hash with the following format:
     *                <code>
     *                array('name' => array('John Doe' => Turba_List, ...), ...)
     *                </code>
     * @throws Turba_Exception
     */
    public function searchDuplicates()
    {
        return $this->_driver->searchDuplicates();
    }

    /**
     * Reads the given data from the address book and returns the
     * results.
     *
     * @param string $key    The primary key field to use.
     * @param mixed $ids     The ids of the contacts to load.
     * @param string $owner  Only return contacts owned by this user.
     * @param array $fields  List of fields to return.
     *
     * @return array  Hash containing the search results.
     * @throws Turba_Exception
     */
    protected function _read($key, $ids, $owner, $fields,
                             $blob_fields = array())
    {
        return $this->_driver->_read($key, $ids, $owner, $fields, $blob_fields);
    }

    /**
     * Adds the specified object to the SQL database.
     *
     * TODO
     */
    protected function _add($attributes, $blob_fields = array())
    {
        $this->_driver->_add($attributes, $blob_fields);
    }

    /**
     * TODO
     */
    protected function _canAdd()
    {
        return $this->_driver->canAdd();
    }

    /**
     * Deletes the specified object from the SQL database.
     *
     * TODO
     */
    protected function _delete($object_key, $object_id)
    {
        $this->_driver->_delete($object_key, $object_id);
    }

    /**
     * Deletes all contacts from a specific address book.
     *
     * @throws Turba_Exception
     */
    protected function _deleteAll($sourceName = null)
    {
        if (is_null($sourceName)) {
            $sourceName = $this->getContactOwner();
        }
        $this->_driver->_deleteAll($sourceName);
    }

    /**
     * Saves the specified object in the SQL database.
     *
     * @return string  The object id, possibly updated.
     * @throws Turba_Exception
     */
    protected function _save($object)
    {
        return $this->_driver->_save($object);
    }

    /**
     * Stub for removing all data for a specific user.
     */
    public function removeUserData($user)
    {
        $this->_deleteAll();
        $GLOBALS['turba_shares']->removeShare($this->_share);
        unset($this->_share);
    }

    /**
     * TODO
     */
    protected function _makeKey($attributes)
    {
        return $this->_driver->_makeKey($attributes);
    }

    /**
     * TODO
     */
    public function getTimeObjectTurbaList($start, $end, $field)
    {
        return $this->_driver->getTimeObjectTurbaList($start, $end, $field);
    }

}
