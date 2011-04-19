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

    private $repository;
    private $revision;
    private $limit = 10;

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

    public function init() {
        $this->setCommand(\Seven\Command::SVN)
                ->setSubCommand(self::COMMAND)
                ->setOptions(array(
                    'xml' => true,
                    'verbose' => true
                ));

        if ($this->getRepository()->getPath()) {
            $this->getRepository()->setUrl(
                    $this->getRepository()->getUrl() .
                    $this->getRepository()->getPath()
            );
        }
        $this->addArgument($this->getRepository()->getUrl());
        if ($this->getRepository()->getUsername()) {
            $this->setOption('username',
                    $this->getRepository()->getUsername()
            );
        }
        if ($this->getRepository()->getPassword()) {
            $this->setOption('password',
                    $this->getRepository()->getPassword()
            );
        }
        if ($this->getRevision()) {
            $this->setOption('revision',
                    $this->getRevision()
            );
        }
        if ($this->getLimit()) {
            $this->setOption('limit',
                    $this->getLimit()
            );
        }
        return $this;
    }

}

?>
