<?php

namespace Seven;

/**
 * Repository
 *
 * Object for representing repositories
 *
 * @package    Seven
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
class Repository {

    public $name;
    public $url;
    public $path;
    private $username;
    private $password;

    function __construct($name, $url, $username = NULL, $password = NULL) {
        $this->setName($name)
                ->setUrl($url)
                ->setUsername($username)
                ->setPassword($password);
    }

    /**
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @param string $name
     * @return Repository
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     *
     * @param string $url
     * @return Repository
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     *
     * @param string $username
     * @return Repository
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     *
     * @param string $password
     * @return Repository
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

}

?>
