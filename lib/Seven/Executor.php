<?php

namespace Seven;

/**
 * Executor
 *
 *
 * @package    Seven
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
class Executor {
    const LONG_OPTION = '--';

    private $command;
    private $subCommand;
    private $arguments = array();
    private $options = array();

    public function setCommand($command) {
        $this->command = $command;
        return $this;
    }

    public function setSubCommand($subCommand) {
        $this->subCommand = $subCommand;
        return $this;
    }

    public function setArguments($arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    public function addArgument($value) {
        $this->arguments[] = $value;
        return $this;
    }

    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }

    public function setOption($name, $value = true) {
        $this->options[$name] = $value;
        return $this;
    }

    public function getCommand() {
        return $this->command;
    }

    public function getSubCommand() {
        return $this->subCommand;
    }

    public function getArguments() {
        return $this->arguments;
    }

    public function getOptions() {
        return $this->options;
    }

    public function prepare() {
        $result = array();
        \array_push($result, $this->getCommand());
        \array_push($result, $this->getSubCommand());
        foreach ($this->getOptions() as $key => $option) {
            \array_push($result, self::LONG_OPTION . $key);
            if ($option !== true) {
                \array_push($result, \escapeshellarg($option));
            }
        }
        foreach ($this->getArguments() as $argument) {
            \array_push($result, \escapeshellarg($argument));
        }
        return \implode(\chr(32), $result);
    }

    public function execute($cmd) {
        return \shell_exec($cmd);
    }

}

?>
