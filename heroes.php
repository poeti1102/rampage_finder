<?php
    $getHeroes = json_decode(CallAPI('GET', 'https://api.stratz.com/api/v1/Hero'));
    $heroes = [];
    foreach($getHeroes as $result) {
        $hero = $result->id;
        $name = $result->displayName;
        $heroes[$hero] = $name;
    }
?>