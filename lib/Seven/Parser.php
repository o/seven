<?php

namespace Seven;

/**
 * Parser
 *
 * Abstract class for parsing XML's
 *
 * @package    Seven
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
abstract class Parser {

    private $xml;

    /**
     *
     * @return string|SimpleXMLElement
     */
    protected function getXml() {
        return $this->xml;
    }

    /**
     *
     * @param string|SimpleXMLElement $xml
     * @return Parser
     */
    protected function setXml($xml) {
        $this->xml = $xml;
        return $this;
    }

    /**
     * Loads XML as SimpleXMLElement for parsing
     *
     * @return Parser
     */
    protected function load() {
        libxml_use_internal_errors(true);
        $xml = \simplexml_load_string($this->getXml());
        if (!libxml_get_errors()) {
            $this->setXml($xml);
        } else {
            libxml_clear_errors();
            $this->setXml(false);
        }
        return $this;
    }

    abstract public function parse();

    /**
     * Returns an English representation of a past date within the last month, stolen from http://ejohn.org/files/pretty.js
     *
     * @param string $ts
     * @return string
     */
    protected function time2str($ts) {
        if (!ctype_digit($ts))
            $ts = strtotime($ts);

        $diff = time() - $ts;
        if ($diff == 0)
            return 'now';
        elseif ($diff > 0) {
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 60)
                    return 'just now';
                if ($diff < 120)
                    return '1 minute ago';
                if ($diff < 3600)
                    return floor($diff / 60) . ' minutes ago';
                if ($diff < 7200)
                    return '1 hour ago';
                if ($diff < 86400)
                    return floor($diff / 3600) . ' hours ago';
            }
            if ($day_diff == 1)
                return 'Yesterday';
            if ($day_diff < 7)
                return $day_diff . ' days ago';
            if ($day_diff < 31)
                return ceil($day_diff / 7) . ' weeks ago';
            if ($day_diff < 60)
                return 'last month';
            return date('F Y', $ts);
        }
        return date('F Y', $ts);
    }    
    
}

?>
