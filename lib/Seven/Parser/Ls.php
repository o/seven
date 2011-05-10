<?php

namespace Seven\Parser;

/**
 * Ls
 *
 * Parser for subversion ls output
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
class Ls extends \Seven\Parser {
    /**
     * XML output tags and attributes
     */
    const XML_ROOT_TAG = 'list';
    const XML_ENTRY_TAG = 'entry';
    const XML_KIND_ATTRIBUTE = 'kind';
    const XML_NAME_TAG = 'name';
    const XML_COMMIT_TAG = 'commit';
    const XML_REVISION_ATTRIBUTE = 'revision';
    const XML_AUTHOR_TAG = 'author';
    const XML_DATE_TAG = 'date';
    const XML_SIZE_TAG = 'size';
    const XML_PATH_ATTRIBUTE = 'path';

    /**
     *
     * @param string $xml
     */
    public function __construct($xml) {
        $this->setXml($xml);
        $this->load();
    }

    public function parse() {
        if (!$this->getXml()) {
            return false;
        }
        $result = new \ArrayObject();
        if ($this->getXml()->{self::XML_ROOT_TAG}->{self::XML_ENTRY_TAG}) {
            foreach ($this->getXml()->{self::XML_ROOT_TAG}->{self::XML_ENTRY_TAG} as $file) {
                $result->append(new \ArrayObject(array(
                            'kind' => (string) $file[self::XML_KIND_ATTRIBUTE],
                            'name' => (string) $file->{self::XML_NAME_TAG},
                            'size' => (int) $file->{self::XML_SIZE_TAG},
                            'revision' => (int) $file->{self::XML_COMMIT_TAG}[self::XML_REVISION_ATTRIBUTE],
                            'author' => (string) $file->{self::XML_COMMIT_TAG}->{self::XML_AUTHOR_TAG},
                            'date' => (string) $file->{self::XML_COMMIT_TAG}->{self::XML_DATE_TAG}
                        )));
            }
        }
        return \iterator_to_array($result);
    }

}

?>
