<?php

namespace Seven;

/**
 * Browser
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
class Browser {

    private function getRepositories() {
        $result = array();
        $values = \Seven\Config::getValues();
        foreach ($values['repositories'] as $repository) {
            $result[] = new Repository($repository['name'], $repository['url']);
        }
        return $result;
    }

    private function getRepository($id) {
        $values = \Seven\Config::getValues();
        $repository = $values['repositories'][$id];
        return new Repository($repository['name'], $repository['url'], $repository['path'], $repository['username'], $repository['password']);
    }

    private function getRepositoryLog($repository_id, $revision_start, $revision_end, $limit) {
        $log = new \Seven\Command\Log();
        return $log->setRepository($this->getRepository($repository_id))
                ->setRevision($revision_start, $revision_end)
                ->setLimit($limit)
                ->execute();
    }

    private function getPostRequest($key) {
        if (\array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
        return false;
    }

    public function dispatch() {
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
                                $this->getPostRequest('revision_start'),
                                $this->getPostRequest('revision_end'),
                                $this->getPostRequest('limit')
                ));
                break;


            default:
                return \json_encode(array('message' => 'Wrong action given'));
                break;
        }
    }

}
