<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->group('/user', function () {
    $this->group('/get', function () {
        $this->get('/sale/{prov}/{product}', function (Request $request, Response $response, $args){
            $prov = $args['prov'];
            $product = $args['product'];
            $result = $this->db->query("SELECT * FROM prod_sale 
                                        WHERE name_prod = '$product' 
                                        AND province = '$prov'
                                        AND status = 'available'")->fetchAll();
            if(!$result){
                return $response->withJson(false,422);
            } else {
                return $response->withJson($result ,200);
            }
        });
    });

    $this->group('/post', function () {

        $this->post('/suggestions', function(Request $request, Response $response){
            $suggestion = $request->getParsedBody();
            $cell = $suggestion['cell'];
           $result = $this->db->query("INSERT INTO suggestions(id, cell) 
                                       VALUES ('$this->token_id', '$cell')");
            if(!$result){
                return $response->withJson(false,422);
                } else {
                return $response->withJson(true ,200);
            }
        });

        $this->post('/newSale', function(Request $request, Response $response) {
            $newSale = $request->getParsedBody();
            $address = $newSale['address'];
            $product= $newSale['prod'];
            $province = $newSale['province'];
            $region = $newSale['region'];
            $sendType = $newSale['send_type'];
            $title = $newSale['title'];
            $result = $this->db->query("INSERT INTO prod_sale(seller, name_prod, region, province, address, send_type, title) 
                              VALUES ('$this->token_id', '$product', '$region','$province', '$address', '$sendType', '$title')");
            if(!$result){
                return $response->withJson(false,422);
            } else {
                return $response->withJson(true ,200);
            }
        });
    });

    $this->group('/put', function () {
        $this->put('/credentials/{cell}', function(Request $request, Response $response, $args){
            $cell = $args['cell'];
            $result = $this->db->query("UPDATE suggestions SET cell = '$cell' WHERE id = '$this->token_id'");
            if(!$result){
                return $response->withJson(false,422);
            } else {
                return $response->withJson($result ,200);
            }
        });
    });

    $this->group('/delete', function () {

    });
    
})->add($mw); 


$app->group('/staff', function () {

})->add($mw);


$app->group('/adimn', function () {

})->add($mw);

