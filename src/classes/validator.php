<?php
namespace Classes;
use Auth0\SDK\JWTVerifier;

class Validator {

    protected $token;
    protected $tokenInfo;

    public function setCurrentToken($token) {

        try {
            $verifier = new JWTVerifier([
                'supported_algs' => ['RS256'],
                'valid_audiences' => ['https://www.hack2018api.com'],
                'authorized_iss' => ['https://gwynbleidd.eu.auth0.com/']
            ]);

            $this->token = $token;
            $this->tokenInfo = $verifier->verifyAndDecode($token);
        }
        catch(\Auth0\SDK\Exception\CoreException $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getTokenInfo(){
        return $this->tokenInfo;
    }
}