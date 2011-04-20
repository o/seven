<?php

namespace Seven;

/**
 * Config
 *
 * Object for accessing YAML configuration entries
 *
 * @package    Seven
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
class Config {
    const FILENAME = 'config.yml';
    static private $values;

    static public function getValues() {
        if (!self::$values) {
            self::$values = self::parse();
        }
        return self::$values;
    }

    private static function parse() {
        try {
            $yaml = new \sfYamlParser();
            $values = $yaml->parse(file_get_contents(self::FILENAME));
        } catch (Exception $exc) {
            return false;
        }
        return $values;
    }

    private function __construct() {
        
    }

}