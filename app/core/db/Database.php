<?php

declare(strict_types=1);

namespace Core\Db;

use Phalcon\DI\Injectable;

/*
 * Database Manage Acces to SQL Server Database via ODBC Connector
 */
class Database extends Injectable
{

    public $link;
    public $resultSet;
    public $result = array();
    public $sql;

    /*
     * Create a new instance of link to Database
     */
    public function __construct() {
        $this->link = $this->di->get('db');
    }

    /*
     * Execute an SQL Query and return rows of result
     * 
     * @param   string $sql 
     * @return  array
     */
    
    public function select(string $sql):array {
        $this->resultSet = odbc_exec($this->link, $sql);
        while ($row = odbc_fetch_array($this->resultSet)) {
            array_push($this->result, $this->encodeResult($row));
        }
        return $this->result;
    }


    /*
     * Generate and Execute an SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sql
     * 
     * @return array containing single row [result int, uuid varchar(36), message varchar(500)]
     */
    
    public function execSP(string $sp, array $params = null):array
    {  
        
        $sql = 'BEGIN TRY ';
            $sql .= 'DECLARE @_result int, @_uuid varchar(36), @_message varchar(500); ';
            $sql .= 'exec @_result =  ' . $sp . $this->formatParams($params) . ' @Uuid_ = @_uuid output, @Msg_ = @_message output;';
            $sql .= 'SELECT @_result as result, @_uuid as uuid, @_message as message;';
        $sql .= 'END TRY      ';
        $sql .= 'BEGIN CATCH  ';
            $sql .= 'SELECT   0 AS result, \'\' AS uuid ,ERROR_MESSAGE() AS message;';
        $sql .= 'END CATCH    ';
        
        $this->resultSet = odbc_exec($this->link, $sql);
        if ($this->resultSet) {
            $this->result = $this->encodeResult(odbc_fetch_array($this->resultSet));
        } else {
            $this->result = $this->resultSet;
        }
        $result             = $this->result;
       
        // Séparation du nom de la procedure 
        $message            = explode('>>>', $result['message']);
        
        if (isset($message[1])){
            $result['code']     = $message[0];
            $result['message']  = $message[1];
        }
        //return $sql;
        return $result;
    }

    /*
     * Generate and Execute an SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sql
     * 
     * @return Single Row of Result
     */
    public function execBulkSP()
    {

    }

    /*
     * Format params to be used in SQL Query for SQL Server Stored Procedure
     * 
     * @param  $params array
     * 
     * @return string
     */
    private function formatParams(array $params):string 
    {

        $formated_params = '';

        foreach ($params as $key => $value) {
              if (($value == '') || ($value === null)){
                    $formated_params .= ' @'.$key.'_ = NULL ';
              }else{
                    $formated_params .= ' @'.$key.'_ =  \'' . utf8_decode($value) . '\',';
              }
        }

        return $formated_params;
    }

    /*
     * Encode a row result with utf8_encode
     * 
     * @return array
     */
    public function encodeResult(array $row):array 
    {
        if (is_array($row)) {
            foreach ($row as $index => $champ) {
                $row[$index] = utf8_encode($champ);
            }
        }
        return $row;
    }
}