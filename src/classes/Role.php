<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 02/11/2018
 * Time: 15:27
 * Classe per la gestione del ruolo a cui appartiene il richiedente.
 * Il ruolo viene ottenuto dal token di autenticazione e viene poi implementata
 * una funzione per ottenerlo.
 */

namespace Classes;


class Role {
    protected $role;

    public function __construct($tokenInfo) {
        $this->setRole($tokenInfo);
    }

    private function setRole($tokenInfo) {
        $this->role = ((array)$tokenInfo)['https://hack2018api.com/roles'];
    }

    public function getRole(){
        return $this->role;
    }
}