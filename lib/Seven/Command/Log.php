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
class Log {
    const COMMAND = 'log';

    private $repository;
    private $revision;
    private $limit;

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository(\Seven\Repository $repository) {
        $this->repository = $repository;
    }

    public function getRevision() {
        return $this->revision;
    }

    public function setRevision($revision) {
        $this->revision = $revision;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
    }

}

?>
