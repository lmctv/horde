<?php

$block_name = _("Feed");

/**
 * This class extends Horde_Block:: to provide an api to embed news
 * in other Horde applications.
 *
 * Copyright 2002-2009 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you
 * did not receive this file, see http://cvs.horde.org/co.php/jonah/LICENSE.
 *
 * @author  Chuck Hagenbuch <chuck@horde.org>
 * @package Horde_Block
 */
class Horde_Block_Jonah_news extends Horde_Block {

    var $_app = 'jonah';

    function _params()
    {
        require_once dirname(__FILE__) . '/../Application.php';
        require JONAH_BASE . '/config/templates.php';

        $params['source'] = array('name' => _("Feed"),
                                  'type' => 'enum',
                                  'values' => array());

        $channels = $GLOBALS['injector']->getInstance('Jonah_Driver')->getChannels();
        foreach ($channels as $channel) {
            $params['source']['values'][$channel['channel_id']] = $channel['channel_name'];
        }
        natcasesort($params['source']['values']);

        $params['view'] = array('name' => _("View"),
                                'type' => 'enum',
                                'values' => array(),
                                );
        foreach ($templates as $key => $template) {
            $params['view']['values'][$key] = $template['name'];
        }

        $params['max'] = array('name' => _("Maximum Stories"),
                               'type' => 'int',
                               'default' => 10,
                               'required' => false);

        $params['from'] = array('name' => _("First Story"),
                                'type' => 'int',
                                'default' => 0,
                                'required' => false);

        return $params;
    }

    function _title()
    {
        try {
            $channel = $GLOBALS['injector']->getInstance('Jonah_Driver')->getChannel($this->_params['source']);
        } catch (Jonah_Exception $e) {
            return htmlspecialchars($e->getMessage());
        }

        if (!empty($channel['channel_link'])) {
            $title = Horde::link(htmlspecialchars($channel['channel_link']), '', '', '_blank')
                . htmlspecialchars($channel['channel_name'])
                . '</a>';
        } else {
            $title = htmlspecialchars($channel['channel_name']);
        }

        return $title;
    }

    function _content()
    {
        if (empty($this->_params['source'])) {
            return _("No feed specified.");
        }

        $view = isset($this->_params['view']) ? $this->_params['view'] : 'standard';

        return $GLOBALS['injector']->getInstance('Jonah_Driver')->renderChannel(
                $this->_params['source'],
                $view,
                $this->_params['max'],
                $this->_params['from']);
    }

}
