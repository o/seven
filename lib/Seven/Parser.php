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
}

?>
