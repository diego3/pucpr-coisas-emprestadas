<?php 

return [
    "/" => "login::index",
    "/login" => "login::index",
    "/logout" => "login::logout",
    "/login/submit" => "login::submit",
    "/home" => "home::index",
    "/admin" => "admin::index",
    "/perfil/editar" => "user::index",
    "/emprestar" => "loan::index",

    "/rest/itens" => "itemRest::findAll",
    "/rest/home/itens" => "itemRest::findAllForHomePage",
    "/rest/new-item" => "itemRest::createItem",

    "/rest/users" => "userRest::findAll",
    "/rest/user"  => "userRest::findById",
    "/rest/new-user" => "userRest::createUser",
    "/rest/update-user" => "userRest::updateUser",

    "/rest/loans" => "loanRest::findAll",
    "/rest/loan" => "loanRest::findById",
    "/rest/new-loan" => "loanRest::createLoan",
    "/rest/devolution" => "loanRest::registerDevolution"
];