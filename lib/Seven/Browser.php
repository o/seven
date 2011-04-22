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

    private function getRepositoryInfo($id) {
        $values = \Seven\Config::getValues();
        $repository = $values['repositories'][$id];
        return new Repository($repository['name'], $repository['url'], $repository['path'], $repository['username'], $repository['password']);
    }

    private function getRepositoryLog($repository_id, $limit = 10, $revision_start = false, $revision_end = false) {
        $log = new \Seven\Command\Log();
        $result = $log->setRepository($this->getRepositoryInfo($repository_id))
                        ->setLimit($limit)
                        ->setRevision($revision_start, $revision_end)
                        ->execute();
        $parser = new LogParser($result);
        return $parser->parse();
    }

    private function getPostRequest($key) {
        if (\array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
        return false;
    }

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
                                    $this->getPostRequest('revision-start'),
                                    $this->getPostRequest('revision-end')
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
