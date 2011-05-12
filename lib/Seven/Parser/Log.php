<?php

namespace Seven\Parser;

/**
 * LogParser
 *
 * Parser for subversion log output
 *
 * @package    Seven
 * @subpackage Seven\Parser
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
class Log extends \Seven\Parser {
    /**
     * XML output tags and attributes
     */
    const XML_REVISION_ATTRIBUTE = 'revision';
    const XML_AUTHOR_TAG = 'author';
    const XML_DATE_TAG = 'date';
    const XML_MESSAGE_TAG = 'msg';
    const XML_PATHS_TAG = 'paths';
    const XML_PATH_TAG = 'path';
    const XML_ACTION_ATTRIBUTE = 'action';

    private $fileActions = array('A' => 'Added', 'D' => 'Deleted', 'M' => 'Modified', 'C' => 'Conflicted', 'G' => 'Merged', 'R' => 'Replaced');

    /**
     *
     * @param string $xml
     */
    public function __construct($xml) {
        $this->setXml($xml);
        $this->load();
    }

    /**
     * Returns explanation of action
     *
     * @param string $action
     * @return string
     */
    private function getFileAction($action) {
        return $this->fileActions[(string) $action];
    }

    /**
     * Parses XML document for outputting JSON output
     *
     * @return array
     */
    public function parse() {
        if (!$this->getXml()) {
            return false;
        }
        $result = new \ArrayObject();
        foreach ($this->getXml() as $commits) {
            $changedfiles = new \ArrayObject();
            if ($commits->{self::XML_PATHS_TAG}->{self::XML_PATH_TAG}) {
                foreach ($commits->{self::XML_PATHS_TAG}->{self::XML_PATH_TAG} as $files) {
                    $changedfiles->append(array(
                        'filename' => (string) $files,
                        'action' => $this->getFileAction($files[self::XML_ACTION_ATTRIBUTE])
                    ));
                }
            }

            $result->append(new \ArrayObject(array(
                        'revision' => (int) $commits[self::XML_REVISION_ATTRIBUTE],
                        'author' => (string) $commits->{self::XML_AUTHOR_TAG},
                        'message' => (string) trim($commits->{self::XML_MESSAGE_TAG}),
                        'date' => $this->time2str($commits->{self::XML_DATE_TAG}),
                        'files' => \iterator_to_array($changedfiles)
                    )));
        };
        return \iterator_to_array($result);
    }

}