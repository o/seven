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

    private $fileActions = array('A' => 'Added', 'D' => 'Deleted', 'M' => 'Modified', 'C' => 'Conflicted', 'G' => 'Merged', 'R' => 'Replaced');

    public function getRepositories() {
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

    public function getRepositoryLog($repository_id, $revision_start, $revision_end, $limit) {
        $log = new \Seven\Command\Log();
        return $log->setRepository($this->getRepository($repository_id))
                ->setRevision($revision_start, $revision_end)
                ->setLimit($limit)
                ->execute();
    }

    private function getFileAction($action) {
        return $this->fileActions[(string) $action];
    }

    private function getPostRequest($key) {
        if (\array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
        return false;
    }

}
