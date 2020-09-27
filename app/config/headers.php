<?php


//header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type, Accept, Origin, User-Agent, Cache-Control, X-Requested-With, Access-Control-Allow-Origin");
header("X-Frame-Options: sameorigin");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Content-Security-Policy: default-src 'none'; script-src 'self'; connect-src 'self'; img-src 'self'; style-src 'self';");
header("Expect-CT: max-age=7776000, enforce");
header("X-Permitted-Cross-Domain-Policies: none");
header("Referrer-Policy: no-referrer");
header("Connection: close");
header_remove("X-Powered-By");
header_remove("Server");



