<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 02/11/2018
 * Time: 15:06
 * Classe per la gestione del gruppo richiesto
 */

namespace Classes;

use Slim\Http\Request;

class Group {
    protected $group;

    public function __construct(Request $request) {
        $this->setGroup($request);
    }

    private function setGroup(Request $request) {
        $this->group = explode('/', $request->getServerParam('REQUEST_URI'))[1];
    }

    public function getGroup() {
        return $this->group;
    }
}