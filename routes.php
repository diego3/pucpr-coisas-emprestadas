<?php 

return [
    "/" => "login::index",
    "/login" => "login::index",
    "/logout" => "login::logout",
    "/login/submit" => "login::submit",
    "/home" => "home::index",
    "/admin" => "admin::index",
    "/diagnostic" => "microfone::index",
    "/rest/item" => "itemRest::findAll",
    "/rest/new-item" => "itemRest::postItem"
];