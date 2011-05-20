<?php

namespace Seven\Command;

/**
 * Seven\Command\Log
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
 * @link       http://github.com/import/seven
 */
class Log extends \Seven\Command\Shared {
    const COMMAND = 'log';
    const REV_SEPERATOR = ':';

    const PARAMETER_VERBOSE = 'verbose';
    const PARAMETER_LIMIT = 'limit';

    public function __construct() {
        $this->setCommand(\Seven\Command::SVN)
                ->setSubCommand(self::COMMAND)
                ->setOptions(array(
                    self::PARAMETER_XML => true,
                    self::PARAMETER_VERBOSE => true,
                    self::PARAMETER_NON_INTERACTIVE => true
                ));
        ;
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

}

?>
