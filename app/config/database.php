<?php
   
return odbc_connect("Driver=" . $config->database->adapter . 
                    ";Server=". $config->database->host .
                    ";Database=".$config->database->dbname,
                                 $config->database->username,
                                 $config->database->password
                    );


