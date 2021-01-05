<?php
require_once __DIR__.'/Controller.php';
require_once __DIR__.'/../models/User.php';

class UserController extends Controller {
    function getUser($request) {
        $id = $request['id'];
        $name = 'Mr. Abul Kalam';
        User::create([
            'name' => $name,
            'age' => 43,
        ]);
        $this->viewEngine
            ->setView('user')
            ->setData( array(
                'id' => $id,
                'name' => $name,
            ))
            ->render();
    }
}