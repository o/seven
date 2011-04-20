<?php

namespace Seven;

/**
 * Command
 *
 * Abstract class for interacting with command line
 *
 * @package    Seven
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
abstract class Command {
    const LONG_OPTION = '--';
    const SVN = 'svn';

    private $command;
    private $subCommand;
    private $arguments = array();
    private $options = array();

    protected function setCommand($command) {
        $this->command = $command;
        return $this;
    }

    protected function setSubCommand($subCommand) {
        $this->subCommand = $subCommand;
        return $this;
    }

    protected function setArguments($arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    protected function addArgument($value) {
        $this->arguments[] = $value;
        return $this;
    }

    protected function setOptions($options) {
        $this->options = $options;
        return $this;
    }

    protected function setOption($name, $value = true) {
        $this->options[$name] = $value;
        return $this;
    }

    private function getCommand() {
        return $this->command;
    }

    private function getSubCommand() {
        return $this->subCommand;
    }

    private function getArguments() {
        return $this->arguments;
    }

    private function getOptions() {
        return $this->options;
    }

    public function prepare() {
        $result = new \ArrayObject();
        $result->append($this->getCommand());
        $result->append($this->getSubCommand());
        foreach ($this->getOptions() as $key => $option) {
            if ($option === false) {
                continue;
            }
            $result->append(self::LONG_OPTION . $key);
            if ($option !== true) {
                $result->append(\escapeshellarg($option));
            }
        }
        foreach ($this->getArguments() as $argument) {
            $result->append(\escapeshellarg($argument));
        }
        return \implode(\chr(32), \iterator_to_array($result));
    }

    public function execute() {
        return \shell_exec($this->prepare());
    }

}

?>
