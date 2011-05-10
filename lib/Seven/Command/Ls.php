<?php

namespace Seven\Command;

/**
 * Seven\Ls
 *
 * Implementation of list command
 *
 * @package    Seven
 * @subpackage Seven\Command
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/import/seven
 */
class Ls extends \Seven\Command {
    const COMMAND = 'list';

    const PARAMETER_XML = 'xml';
    const PARAMETER_USERNAME = 'username';
    const PARAMETER_PASSWORD = 'password';    
    const PARAMETER_REVISION = 'revision';

    public function __construct() {
        $this->setCommand(\Seven\Command::SVN)
                ->setSubCommand(self::COMMAND)
                ->setOptions(array(
                    self::PARAMETER_XML => true
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
