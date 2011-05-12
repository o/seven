<?php

namespace Seven\Command;

/**
 * Seven\Command\Shared
 *
 * Class for shared subversion commands
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
abstract class Shared extends \Seven\Command {
    const PARAMETER_XML = 'xml';
    const PARAMETER_USERNAME = 'username';
    const PARAMETER_PASSWORD = 'password';
    const PARAMETER_REVISION = 'revision';

    /**
     *
     * @param \Seven\Repository $repository
     * @return Shared
     */
    public function setRepository(\Seven\Repository $repository, $path = false) {
        if ($path) {
            $repository->setUrl($path);
        }
        $this->addArgument($repository->getUrl());
        if ($repository->getUsername()) {
            $this->setOption(
                    self::PARAMETER_USERNAME, $repository->getUsername()
            );
        }
        if ($repository->getPassword()) {
            $this->setOption(
                    self::PARAMETER_PASSWORD, $repository->getPassword()
            );
        }

        return $this;
    }

    /**
     *
     * @param string|int $revision
     * @return Shared
     */
    public function setRevision($revision) {
        $this->setOption(
                self::PARAMETER_REVISION, $revision
        );
        return $this;
    }

}

?>
