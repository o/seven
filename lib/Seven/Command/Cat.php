<?php

namespace Seven\Command;

/**
 * Seven\Command\Cat
 *
 * Implementation of cat command
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
class Cat extends \Seven\Command\Shared {
    const COMMAND = 'cat';

    public function __construct() {
        $this->setCommand(\Seven\Command::SVN)
                ->setSubCommand(self::COMMAND)
        ;
    }

}

?>
