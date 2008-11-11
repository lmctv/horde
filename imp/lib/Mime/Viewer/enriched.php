<?php
/**
 * The IMP_Horde_Mime_Viewer_enriched class renders out plain text from
 * enriched content tags, ala RFC 1896
 *
 * Copyright 2001-2008 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/gpl.html.
 *
 * @author  Eric Rostetter <eric.rostetter@physics.utexas.edu>
 * @package Horde_Mime
 */
class IMP_Horde_Mime_Viewer_enriched extends Horde_Mime_Viewer_enriched
{
    /**
     * Return the full rendered version of the Horde_Mime_Part object.
     *
     * @return array  See Horde_Mime_Viewer_Driver::render().
     */
    protected function _render()
    {
        $ret = parent::_render();
        $ret['data'] = $this->_IMPformat($ret['data']);
        return $ret;
    }

    /**
     * Return the rendered inline version of the Horde_Mime_Part object.
     *
     * @return array  See Horde_Mime_Viewer_Driver::render().
     */
    protected function _renderInline()
    {
        $ret = parent::_renderInline();
        $ret['data'] = $this->_IMPformat($ret['data']);
        return $ret;
    }

    /**
     * Format output text with IMP additions.
     *
     * @param string $text  The HTML text.
     *
     * @return string  The text with extra IMP formatting applied.
     */
    protected function _IMPformat($text)
    {
        // Highlight quoted parts of an email.
        if ($GLOBALS['prefs']->getValue('highlight_text')) {
            $text = implode("\n", preg_replace('|^(\s*&gt;.+)$|', '<span class="quoted1">\1</span>', explode("\n", $text)));
            $indent = 1;
            while (preg_match('|&gt;(\s?&gt;){' . $indent . '}|', $text)) {
                $text = implode("\n", preg_replace('|^<span class="quoted' . ((($indent - 1) % 5) + 1) . '">(\s*&gt;(\s?&gt;){' . $indent . '}.+)$|', '<span class="quoted' . (($indent % 5) + 1) . '">\1', explode("\n", $text)));
                ++$indent;
            }
        }

        // Dim signatures.
        if ($GLOBALS['prefs']->getValue('dim_signature')) {
            $parts = preg_split('|(\n--\s*\n)|', $text, 2, PREG_SPLIT_DELIM_CAPTURE);
            $text = array_shift($parts);
            if (count($parts)) {
                $text .= '<span class="signature">' . $parts[0] .
                    preg_replace('|class="[^"]+"|', 'class="signature-fixed"', $parts[1]) .
                    '</span>';
            }
        }

        // Filter bad language.
        return IMP::filterText($text);
    }
}
