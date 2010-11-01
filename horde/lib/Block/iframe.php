<?php

$block_name = _("View an external web page");

/**
 * @package Horde_Block
 */
class Horde_Block_Horde_iframe extends Horde_Block
{
    protected $_app = 'horde';

    /**
     *
     * @return array
     */
    protected function _params()
    {
        return array('iframe' => array('type' => 'text',
                                       'name' => _("URL"),
                                       'default' => ''),
                     'title'  => array('type' => 'text',
                                       'name' => _("Title")),
                     'height' => array('type' => 'enum',
                                       'name' => _("Height"),
                                       'default' => '600',
                                       'values' => array('480' => _("Small"),
                                                         '600' => _("Medium"),
                                                         '768' => _("Large"),
                                                         '1024' => _("Extra Large"))));
    }

    /**
     * The title to go in this block.
     *
     * @return string   The title text.
     */
    protected function _title()
    {
        global $registry;

        $title = !empty($this->_params['title']) ? $this->_params['title'] : $this->_params['iframe'];
        $url = new Horde_Url(Horde::externalUrl($this->_params['iframe']));
        
        return htmlspecialchars($title) . $url->link(array('target' => '_blank'))
            . Horde::img('external.png', '', array('style' => 'vertical-align:middle;padding-left:.3em')) . '</a>';
    }

    /**
     * The content to go in this block.
     *
     * @return string   The content
     */
    protected function _content()
    {
        global $browser;

        if (!$browser->hasFeature('iframes')) {
            return _("Your browser does not support this feature.");
        }

        if (empty($this->_params['height'])) {
            if ($browser->isBrowser('msie') || $browser->isBrowser('webkit')) {
                $height = '';
            } else {
                $height = ' height="100%"';
            }
        } else {
            $height = ' height="' . htmlspecialchars($this->_params['height']) . '"';
        }
        return '<iframe src="' . htmlspecialchars($this->_params['iframe']) . '" width="100%"' . $height . ' marginheight="0" scrolling="auto" frameborder="0"></iframe>';
    }

}
