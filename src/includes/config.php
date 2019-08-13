<?php

return array(
    'database' => array(
        'driver' => getenv("DB_DRIVER"),
        'dbname' => getenv("DBNAME"),
        'host' => getenv("DB_HOST"),
        'user'  => getenv("DB_USER"),
        'passwd' => getenv("DB_PASSWD")    
    ),
    'api-twitter' => array(
        'oauth_access_token' => getenv("ACCESS_TOKEN"),
        'oauth_access_token_secret' => getenv("ACCESS_TOKEN_SECRET"),
        'consumer_key' => getenv("CONSUMER_KEY"),
        'consumer_secret' => getenv("CONSUMER_SECRET")
    )
);