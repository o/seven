<?php

namespace Seven;

/**
 * Seven\Browser
 *
 * Dispatcher for routing requests and includes browser helper methods
 *
 * @package    Seven
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Version @package_version@
 * @since      Class available since Release 1.0.0
 * @link       http://github.com/osmanungur/seven
 */
class Browser {

    /**
     * Returns repository name and url's from config
     *
     * @return array
     */
    private function getRepositories() {
        $result = new \ArrayObject();
        $values = \Seven\Config::getValues();
        foreach ($values['repositories'] as $repository) {
            $result->append(new \ArrayObject(array(
                        'name' => $repository['name'],
                        'url' => $this->getShortUrl($repository['url'])
                    )));
        }
        return \iterator_to_array($result);
    }

    /**
     * Returns all information of given repository
     *
     * @param int $id
     * @return Repository
     */
    private function getRepositoryInfo($id) {
        $values = \Seven\Config::getValues();
        $repository = $values['repositories'][$id];
        return new Repository($repository['name'], $repository['url'], $repository['username'], $repository['password']);
    }

    /**
     *
     * Returns log of repository
     *
     * @param int $repository_id
     * @param int $limit
     * @param string|int $revision_start
     * @param string|int $revision_end
     * @return array
     */
    private function getRepositoryLog($repository_id, $limit = 10, $revision = false) {
        $log = new \Seven\Command\Log();
        $result = $log->setRepository($this->getRepositoryInfo($repository_id))
                        ->setLimit($limit)
                        ->setRevision($revision)
                        ->execute();
        $parser = new \Seven\Parser\Log($result);
        return $parser->parse();
    }
    
    private function getRepositoryFiles($repository_id, $revision = false) {
        $list = new \Seven\Command\Ls();
        $result = $list->setRepository($this->getRepositoryInfo($repository_id))
                ->setRevision($revision)
                ->execute();
        $parser = new \Seven\Parser\Ls($result);
        return $parser->parse();
    }

    /**
     * Returns value of given post key
     *
     * @param string $key
     * @return string
     */
    private function getPostRequest($key) {
        if (\array_key_exists($key, $_POST)) {
            if ($_POST[$key]) {
                return $_POST[$key];
            }
        }
        return false;
    }

    /**
     * Returns host or shorten url of url
     *
     * @param string $url
     * @return string
     */
    private function getShortUrl($url) {
        $parsed = \parse_url($url);
        if (\array_key_exists('host', $parsed)) {
            return $parsed['host'];
        } else {
            if (strlen($url) > 20) {
                return \substr($url, 0, 20) . "...";
            }
            return $url;
        }
    }

    /**
     * Basic request router
     *
     * @return mixed
     */
    public function dispatch() {
        if ($this->getPostRequest('action')) {
            switch ($this->getPostRequest('action')) {
                case 'repositories':
                    return \json_encode(
                            $this->getRepositories()
                    );
                    break;

                case 'log':
                    return \json_encode(
                            $this->getRepositoryLog(
                                    $this->getPostRequest('repository_id'),
                                    $this->getPostRequest('limit'),
                                    $this->getPostRequest('revision')
                    ));
                    break;

                case 'ls':
                    return \json_encode(
                            $this->getRepositoryFiles(
                                    $this->getPostRequest('repository_id'),
                                    $this->getPostRequest('revision')
                    ));
                    break;                

                default:
                    return \json_encode(array('message' => 'Wrong action given'));
                    break;
            }
        } else {
            return \json_encode(array('message' => 'No action given'));
        }
    }

}
