<?php

namespace Seven;

/**
 * LogParser
 *
 *
 * @package    Seven
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
class LogParser {
    /**
     * XML output tags and attributes
     */
    const XML_ROOT_TAG = 'log';
    const XML_ITEM_TAG = 'logentry';
    const XML_REVISION_ATTRIBUTE = 'revision';
    const XML_AUTHOR_TAG = 'author';
    const XML_DATE_TAG = 'date';
    const XML_MESSAGE_TAG = 'msg';
    const XML_PATHS_TAG = 'paths';
    const XML_PATH_TAG = 'path';
    const XML_ACTION_ATTRIBUTE = 'action';
    const XML_KIND_ATTRIBUTE = 'kind';

    private $fileActions = array('A' => 'Added', 'D' => 'Deleted', 'M' => 'Modified', 'C' => 'Conflicted', 'G' => 'Merged', 'R' => 'Replaced');
    private $xml;

    public function __construct($xml) {
        $this->setXml($xml);
        $this->load();
    }

    private function getFileAction($action) {
        return $this->fileActions[(string) $action];
    }

    private function load() {
        libxml_use_internal_errors(true);
        $xml = new \SimpleXMLElement($this->getXml());
        if (!libxml_get_errors()) {
            $this->setXml($xml);
        } else {
            throw new Exception("Some errors occured when loading XML", 1);
            libxml_clear_errors();
        }
        return $this;
    }

    public function parse() {
        $result = new \ArrayObject();
        foreach ($this->getXml() as $commits) {
            $changedfiles = false;
            if ($commits->{self::XML_PATHS_TAG}->{self::XML_PATH_TAG}) {
                foreach ($commits->{self::XML_PATHS_TAG}->{self::XML_PATH_TAG} as $files) {
                    $changedfiles = new \ArrayObject(array(
                                'filename' => (string) $files,
                                'action' => $this->getFileAction($files[self::XML_ACTION_ATTRIBUTE])
                            ));
                }
            }

            $result->append(new \ArrayObject(array(
                        'revision' => (int) $commits[self::XML_REVISION_ATTRIBUTE],
                        'author' => (string) $commits->{self::XML_AUTHOR_TAG},
                        'message' => (string) trim($commits->{self::XML_MESSAGE_TAG}),
                        'date' => (string) $commits->{self::XML_DATE_TAG},
                        $changedfiles
                    )));
        };
        return $result;
    }

    private function getXml() {
        return $this->xml;
    }

    private function setXml($xml) {
        $this->xml = $xml;
        return $this;
    }

}