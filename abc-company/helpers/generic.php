<?php

if (!function_exists("is_user_auth")  ){
    function is_user_auth(App\Entity\User $user){
        if (!$user instanceof App\Entity\User) {
           throw new \Exception('The user is not authenticated.');
        }
        return true;
    }
}