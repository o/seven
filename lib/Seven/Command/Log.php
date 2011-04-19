<?php

namespace Seven\Command;

/**
 * Log
 * 
 *
 * @package    Seven_Command
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
    const PARAMETER_USERNAME = 'username';
    const PARAMETER_PASSWORD = 'password';
    const PARAMETER_REVISION = 'revision';
    const PARAMETER_LIMIT = 'limit';

    private $repository;
    private $revision;
    private $limit;

    private function getRepository() {
        return $this->repository;
    }

    public function setRepository(\Seven\Repository $repository) {
        $this->repository = $repository;
        return $this;
    }

    private function getRevision() {
        return $this->revision;
    }

    public function setRevision($start, $end = NULL) {
        if ($end) {
            $this->revision = $start . self::REV_SEPERATOR . $end;
        } else {
            $this->revision = $start;
        }
        return $this;
    }

    private function getLimit() {
        return $this->limit;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    protected function init() {
        $this->setCommand(\Seven\Command::SVN)
                ->setSubCommand(self::COMMAND)
                ->setOptions(array(
                    self::PARAMETER_XML => true,
                    self::PARAMETER_VERBOSE => true
                ));

        if ($this->getRepository()->getPath()) {
            $this->getRepository()->setUrl(
                    $this->getRepository()->getUrl() .
                    $this->getRepository()->getPath()
            );
        }
        $this->addArgument($this->getRepository()->getUrl());
        if ($this->getRepository()->getUsername()) {
            $this->setOption(
                    self::PARAMETER_USERNAME,
                    $this->getRepository()->getUsername()
            );
        }
        if ($this->getRepository()->getPassword()) {
            $this->setOption(
                    self::PARAMETER_PASSWORD,
                    $this->getRepository()->getPassword()
            );
        }
        if ($this->getRevision()) {
            $this->setOption(
                    self::PARAMETER_REVISION,
                    $this->getRevision()
            );
        }
        if ($this->getLimit()) {
            $this->setOption(
                    self::PARAMETER_LIMIT,
                    $this->getLimit()
            );
        }
        return $this;
    }

}

?>
