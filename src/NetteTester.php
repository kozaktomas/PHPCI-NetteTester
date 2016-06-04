<?php

namespace Kozaktomas\PHPCI\Plugin;

use PHPCI;
use PHPCI\Builder;
use PHPCI\Model\Build;

class NetteTester implements PHPCI\Plugin, PHPCI\ZeroConfigPlugin
{

    /** @var string */
    private $directory;

    /** @var Builder */
    private $phpci;

    /** @var string */
    private $params = "";

    /**
     * Set up the plugin, configure options, etc.
     * @param Builder $phpci
     * @param Build $build
     * @param array $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->directory = $build->getBuildPath();

        if (isset($options['params'])) {
            $this->params = $options['params'] . " ";
        }
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $cmd = "php vendor/bin/tester " . $this->params . $this->directory . "tests/";
        $result = $this->phpci->executeCommand($cmd, $this->directory);
        $output = $this->phpci->getLastOutput();

        $status = true;
        if (preg_match("/OK/", $output)) {
            $this->phpci->logSuccess("Tests OK");
        } else {
            $status = false;
            $this->phpci->logFailure("Tests have failed.");
        }

        return $result && $status;
    }

    /**
     * @param $stage
     * @param Builder $builder
     * @param Build $build
     * @return bool
     */
    public static function canExecute($stage, Builder $builder, Build $build)
    {
        return true;
    }
}