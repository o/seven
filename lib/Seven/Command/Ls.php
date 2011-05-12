<?php

namespace Seven\Command;

/**
 * Seven\Command\Ls
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
class Ls extends \Seven\Command\Shared{
    const COMMAND = 'list';

    public function __construct() {
        $this->setCommand(\Seven\Command::SVN)
                ->setSubCommand(self::COMMAND)
                ->setOptions(array(
                    self::PARAMETER_XML => true
                ));
        ;
    }   
    
}

?>
