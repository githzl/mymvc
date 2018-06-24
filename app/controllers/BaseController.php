<?php
/**
 * Created by IntelliJ IDEA.
 * User: hezhongli
 * Date: 18/6/23
 * Time: 下午2:57
 */

namespace app\controllers;

use Latte\Engine;
use Pheasant;

class BaseController
{
    private $config;
    private $latte;

    public function __construct()
    {
        $this->loadConfig();
        $this->initDb();
        $this->initTpl();
    }

    private function loadConfig()
    {
        $this->config = require '../config/base.php';
    }

    private function initDb()
    {
        Pheasant::setup($this->config['dsn']);
    }

    public function initTpl()
    {
        $this->latte = new Engine();
        $this->latte->setTempDirectory(APP_ROOT.'/storage/views');
        $set = new \Latte\Macros\MacroSet($this->latte->getCompiler());
        $set->addMacro('url',function($write){
            return $write->write('echo "'.SITE_URL.'%node.args'.'"');
        });
    }

    public function render($name,array $params =[],$block = NULL)
    {
        $params['sitename'] = 'sijiaomao mvc framework';
        $tplFile = APP_ROOT . '/views/' . $name . '.latte';
        $this->latte->render($tplFile, $params, $block);
    }

    public function redirect($name)
    {
        header('Location:' . SITE_URL . '/' . $name);
        exit;
    }

}