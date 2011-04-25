<?php

namespace Seven\Command;

/**
 * Seven\Log
 *
 * Implementation of log command
 *
 * @package    Seven
 * @subpackage Seven\Command
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
class Log extends \Seven\Command {
    const COMMAND = 'log';
    const REV_SEPERATOR = ':';

    const PARAMETER_XML = 'xml';
    const PARAMETER_VERBOSE = 'verbose';
    const PARAMETER_MERGE_HISTORY = 'use-merge-history';
    const PARAMETER_USERNAME = 'username';
    const PARAMETER_PASSWORD = 'password';
    const PARAMETER_REVISION = 'revision';
    const PARAMETER_LIMIT = 'limit';

    public function __construct() {
        $this->setCommand(\Seven\Command::SVN)
                ->setSubCommand(self::COMMAND)
                ->setOptions(array(
                    self::PARAMETER_XML => true,
                    self::PARAMETER_VERBOSE => true,
                    self::PARAMETER_MERGE_HISTORY => true
                ));
        ;
    }

    /**
     *
     * @param \Seven\Repository $repository
     * @return Log
     */
    public function setRepository(\Seven\Repository $repository) {
        if ($repository->getPath()) {
            $repository->setUrl(
                    $repository->getUrl() .
                    $repository->getPath()
            );
        }
        $this->addArgument($repository->getUrl());
        if ($repository->getUsername()) {
            $this->setOption(
                    self::PARAMETER_USERNAME,
                    $repository->getUsername()
            );
        }
        if ($repository->getPassword()) {
            $this->setOption(
                    self::PARAMETER_PASSWORD,
                    $repository->getPassword()
            );
        }

        return $this;
    }

    /**
     *
     * @param int $limit
     * @return Log
     */
    public function setLimit($limit) {
        if (\is_numeric($limit)) {
            $this->setOption(
                    self::PARAMETER_LIMIT,
                    $limit
            );
        }
        return $this;
    }

    /**
     *
     * @param string|int $revision
     * @return Log
     */
    public function setRevision($revision) {
        $this->setOption(
                self::PARAMETER_REVISION,
                $revision
        );
        return $this;
    }

}

?>
