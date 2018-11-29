<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

//----------------USER-----------------------------------
//______________GET_____________________________
$app->group('/user', function () {
    $this->group('/get', function () {
        $this->get('/credentials', function (Request $request, Response $response){
            $id = $this->token_id;
            $result = $this->db->query("SELECT name, surname, mail, birth, cell FROM users WHERE id ='$id'")->fetch();
            if($result){
                return $response->withJson($result,200);
            }else{
                return $response->withJson(false,422);
            }
       });
    });
//______________________________________________
    
//__________DELETE____________________________
    $this->group('/delete', function () {

    });
//_____________________________________________
    
})->add($mw); 

//---------END USER---------------------------

//--------------STAFF-------------------------

$app->group('/staff', function () {

})->add($mw);

//--------------ADMIN--------------------------

$app->group('/adimn', function () {

})->add($mw);


//------------ROUTES TEST------------------------
$app->get('/test/prova', function (Request $request, Response $response) {
    return $response->withJson($request->getMethod());
});
