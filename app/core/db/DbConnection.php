<?php

namespace Core\Db;

use Phalcon\DI\Injectable;

/*
 * DbConnection Manage Acces to SQL Server Database via ODBC Connector
 */

class DbConnection extends Injectable {

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
     * Execute an SQL Query and return 1 row of result
     * 
     * @param   string $sql 
     * @return  array
     */
    public function select($sql) {
        $this->resultSet = odbc_exec($this->link, $sql);
        $this->result = $this->encodeResult(odbc_fetch_array($this->resultSet));
        return $this->result;
    }

    /*
     * Execute an SQL Query and return all rows of result
     * 
     * @param   string $sql 
     * @return  array
     */

    public function selectAll($sql) {
        $this->resultSet = odbc_exec($this->link, $sql);
        while ($row = odbc_fetch_array($this->resultSet)) {
            array_push($this->result, $this->encodeResult($row));
        }
        return $this->result;
    }

    /*
     * Execute a specific SQL Query to return Document from Database
     * 
     * @param   string $sql 
     * @return  array
     */

    public function selectDocument($sql) {
        $this->resultSet = odbc_exec($this->link, $sql);
        $this->result = odbc_fetch_array($this->resultSet);
        return $this->result;
    }

    /*
     * Generate an insert SQL Query for a specific table
     * 
     * @param @table string
     * @param @data  array
     * 
     * @return string (id of the new inserted line)
     */

    public function insert($table, $data) {
        $this->sql = ' SET NOCOUNT ON INSERT INTO ' . $table . ' (';
        foreach ($data as $index => $value) {
            $this->sql .= $index . ', ';
        }
        $this->sql = substr_replace($this->sql, ' ', strlen($this->sql) - 2);
        $this->sql .= ') values ( ';
        foreach ($data as $value) {
            if (isset($value[1]) && ($value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double')) {
                $this->sql .= $value[0] . ", ";
            } else {
                $this->sql .= " '" . utf8_decode($value[0]) . "', ";
            }
        }
        $this->sql = substr_replace($this->sql, ' ', strlen($this->sql) - 2);
        $this->sql .= ')';
        $this->sql .= '; SELECT SCOPE_IDENTITY() AS id_inserted';

        $this->resultSet = odbc_exec($this->link, $this->sql);
        $this->result = odbc_fetch_array($this->resultSet);

        return $this->result;
    }
    /*
     * Generate an insert SQL Query for a table FILE
     * 
     * @param @table string
     * @param @data  array
     * 
     * @return string (id of the new inserted line)
     */

    public function insertFile($table, $data) {
        $this->sql = ' SET NOCOUNT ON INSERT INTO ' . $table . ' (';
        foreach ($data as $index => $value) {
            $this->sql .= $index . ', ';
        }
        $this->sql = substr_replace($this->sql, ' ', strlen($this->sql) - 2);
        $this->sql .= ') values ( ';
        foreach ($data as $value) {
            if (isset($value[1]) && ($value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double')) {
                $this->sql .= $value[0] . ", ";
            } else {
                $this->sql .= " '" . utf8_decode($value[0]) . "', ";
            }
        }
        $this->sql = substr_replace($this->sql, ' ', strlen($this->sql) - 2);
        $this->sql .= ')';
        $this->sql .= '; SELECT SCOPE_IDENTITY() AS id_inserted';

        $this->resultSet = odbc_exec($this->link, $this->sql);
        $this->result = odbc_fetch_array($this->resultSet);

        return $this->result;
    }

    /*
     * Generate and Execute an SQL Query to delete a row form a specific table
     * 
     * @param   string @table
     * @param   array  @whereConditions
     * 
     * @retrun 
     */

    public function delete($table, $whereConditions) {

        $this->sql = 'delete from ' . $table . ' ';
        $where = '';
        if (sizeof($whereConditions) > 0) {
            foreach ($whereConditions as $indexWhere => $valueWhere) {
                if (isset($whereConditions[1]) && ($whereConditions[1] == 'money' || $whereConditions[1] == 'integer' || $whereConditions[1] == 'double')) {
                    $where .= $indexWhere . ' = ' . $valueWhere[0] . ' AND ';
                } else {
                    $where .= $indexWhere . ' = \'' . $valueWhere[0] . '\' AND ';
                }
            }
            $this->sql .= ' where ' . substr_replace($where, ' ', strlen($where) - 4);
            $this->result = odbc_exec($this->link, $this->sql);
        }
        return $this->result;
    }

    /*
     * Generate and Execute an SQL Query to update a row form a specific table
     * 
     * @param   string @table
     * @param   array  @data
     * @param   array  @whereConditions
     * 
     * @return
     */
    
    public function ExecQuery($sql){
        $this->result = odbc_exec($this->link, $sql);
        return $this->result;
    }

    public function update($table, $data, $whereConditions) {
        $this->sql = 'update ' . $table . ' set ';

        /* Construction du bloc des colonnes à modifier */
        foreach ($data as $index => $value) {
            if (isset($value[1]) && ($value[1] == 'money' || $value[1] == 'int' || $value[1] == 'fk_key' )) {
                $this->sql .= $index . ' = ' . $value[0] . ', ';
            } else {
                $this->sql .= $index . ' = \'' . utf8_decode($value[0]) . '\', ';
            }
        }
        $this->sql = substr_replace($this->sql, ' ', strlen($this->sql) - 2);

        /* Construction du bloc des condition pour la requête update */
        $where = '';
        if (sizeof($whereConditions) > 0) {
            foreach ($whereConditions as $indexWhere => $valueWhere) {
                if (isset($value[1]) && ( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'fk_key' )) {
                    $where .= $indexWhere . ' = ' . $valueWhere[0] . ' AND ';
                } else {
                    $where .= $indexWhere . ' = \'' . utf8_decode($valueWhere[0]) . '\' AND ';
                }
            }
            $this->sql .= ' where ' . substr_replace($where, ' ', strlen($where) - 4);
        } else {
            return null;
        }
        /* Execution de la requête */
        $this->result = odbc_exec($this->link, $this->sql);
        return $this->result;
    }

    /*
     * Generate  SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sp_name String
     * @param   $data array
     * 
     * @return $SQL for Execut Stored Procedure
     */
     public function createSQLforSPWithParam($sp_name, $data) {
        $sql = 'execute @_Result = ' . $sp_name . ' ';
        $t = 0;
        foreach ($data as $key => $value) {
            if ($t == 0) {
                $t = 1;
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime')) {
                    if (($value[0] == '')){
                        $sql .= ' @'.$key.'_ = NULL ';
                    }else{
                        $sql .= ' @'.$key.'_  = ' . utf8_decode($value[0]);
                    }
                    
                } else {
                    $sql .= ' @'.$key.'_ =  \'' . utf8_decode($value[0]) . '\'';
                }
            } else {
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime' )) {
                    if (($value[0] == '')){
                        $sql .= ', @'.$key.'_= NULL ';
                    }else{
                        $sql .= ' ,@'.$key.'_ = ' . utf8_decode($value[0]);
                    }
                }else{
                    $sql .= ' , @'.$key.'_ =  \'' . utf8_decode($value[0]) . '\'';
                }
            }
        }
        return $sql;
    }
    /*
     * Generate  param Query for SQL Server Stored Procedure
     * 
     * @param   $sp_name String
     * @param   $data array
     * 
     * @return $SQL for Execut Stored Procedure
     */
     public function createParam($data) {
         $sql = '';
        $t = 0;
        foreach ($data as $key => $value) {
            if ($t == 0) {
                $t = 1;
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime')) {
                    if (($value[0] == '')){
                        $sql .= ' NULL';
                    }else{
                        $sql .= '  ' . utf8_decode($value[0]);
                    }
                    
                } else {
                    $sql .= '\'' . utf8_decode($value[0]) . '\'';
                }
            } else {
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime' )) {
                    if (($value[0] == '')){
                        $sql .= ' ,NULL';
                    }else{
                        $sql .= ' , ' . utf8_decode($value[0]);
                    }
                }else{
                    $sql .= ' , \'' . utf8_decode($value[0]) . '\'';
                }
            }
        }
        return $sql;
    }
    /*
     * Generate  SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sp_name String
     * @param   $data array
     * 
     * @return $SQL for Execut Stored Procedure
     */
     public function createSQLforSP($sp_name, $data) {
        $sql = 'execute @_Result = ' . $sp_name . ' ';
        $t = 0;
        foreach ($data as $key => $value) {
            if ($t == 0) {
                $t = 1;
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime')) {
                    if (($value[0] == '')){
                        $sql .= ' NULL';
                    }else{
                        $sql .= '  ' . utf8_decode($value[0]);
                    }
                    
                } else {
                    $sql .= '  \'' . utf8_decode($value[0]) . '\'';
                }
            } else {
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime' )) {
                    if (($value[0] == '')){
                        $sql .= ' ,NULL';
                    }else{
                        $sql .= ' , ' . utf8_decode($value[0]);
                    }
                }else{
                    $sql .= ' , \'' . utf8_decode($value[0]) . '\'';
                }
            }
        }
        return $sql;
    }
    
    /*
     * Generate  SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sp_name String
     * @param   $data array
     * 
     * @return $SQL for Execut Stored Procedure
     */
     public function createSQLforSPWithoutResult($sp_name, $data) {
        $sql = 'execute ' . $sp_name . ' ';
        $t = 0;
        foreach ($data as $key => $value) {
            if ($t == 0) {
                $t = 1;
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime')) {
                    if (($value[0] == '')){$sql .= ' @'.$key.'_  = NULL'; }
                    $sql .= ' @'.$key.'_  = ' . utf8_decode($value[0]);
                } else {
                    $sql .= ' @'.$key.'_  =   \'' . utf8_decode($value[0]) . '\'';
                }
            } else {
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime' )) {
                    if (($value[0] == '')){$sql .= ' , @'.$key.'_  = NULL'; }
                    else
                    {$sql .= ' ,  @'.$key.'_  = ' . utf8_decode($value[0]);}
                } else {
                    $sql .= ' ,   @'.$key.'_  =  \'' . utf8_decode($value[0]) . '\'';
                }
            }
        }
        return $sql;
    }
    
    /*
     * Generate  SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sp_name String
     * @param   $data array
     * 
     * @return $SQL for Execut Stored Procedure
     */   
     public function createSQLforFN($fn_name, $data) {
        $sql = 'select * from  dbo.' . $fn_name . '(';
        $t = 0;
        foreach ($data as $key => $value) {
            if ($t == 0) {
                $t = 1;
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime')) {
                    if (($value[0] == '')){$sql .= ' NULL'; }
                    $sql .= '  ' . utf8_decode($value[0]);
                } else {
                    $sql .= '  \'' . utf8_decode($value[0]) . '\'';
                }
            } else {
                if (( $value[1] == 'money' || $value[1] == 'int' || $value[1] == 'double' || $value[1] == 'datetime' )) {
                    if (($value[0] == '')){$sql .= ' ,NULL'; }
                    else
                    {$sql .= ' , ' . utf8_decode($value[0]);}
                } else {
                    $sql .= ' , \'' . utf8_decode($value[0]) . '\'';
                }
            }
        }
        $sql = $sql .");";
        return $sql;
    }

    /*
     * Generate and Execute an SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sql
     * 
     * @return Single Row of Result
     */
    public function execSP($param) {
        $sql = 'BEGIN TRY ';
            $sql .= 'DECLARE @_Result int, @_UUID varchar(36),@_Message varchar(500); ';
            $sql .= $param.', @Msg_ = @_Message output;';
            $sql .= 'SELECT @_Result as result, @_Message as message;';
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
            $result['message']  = $message[1];
        }

        return $result;
    }

    /*
     * Generate and Execute an SQL Query for SQL Server Stored Procedure
     * 
     * @param   $sql
     * 
     * @return Multiple Rows of Result
     */
    public function execSP_MultipleRows($sql) {
        $sql = 'Declare @_Result int, @_Message varchar(500); ' . $sql;
        $sql .= ', @Msg_ = @_Message output;';
        $sql .= 'Select @_Result as result, @_Message as message;';
        $this->resultSet = odbc_exec($this->link, $sql);
        if ($this->resultSet) {
            while ($row = odbc_fetch_array($this->resultSet)) {
                array_push($this->result, $this->encodeResult($row));
            }
        } else {
            $this->result = $this->resultSet;
        }

        return $this->result;
    }

    public function execSP_WithoutParams($sql) {
        $sql = 'Declare @_Result int, @_Message varchar(500); ' . $sql;
        $sql .= ' @Msg_ = @_Message output;';
        $sql .= 'Select @_Result as result, @_Message as message;';

        $this->resultSet = odbc_exec($this->link, $sql);
        if ($this->resultSet) {
            $this->result = odbc_fetch_array($this->resultSet);
        } else {
            $this->result = $this->resultSet;
        }

        return $this->result;
    }

    /*
     * Return rows number affected by a specific SQL Query
     */
    public function rowsNumber() {
        return odbc_num_rows($this->result);
    }

    /*
     * Close link to Database
     */
    public function close() {
        odbc_close($this->link);
    }

    /*
     * Encode a row result with utf8_encode
     * 
     * @return array
     */
    public function encodeResult($row) {
        if (is_array($row)) {
            foreach ($row as $index => $champ) {
                $row[$index] = utf8_encode($champ);
            }
        }
        return $row;
    }
    
    /*
     * Get Errors generated by the current SQL Query
     * 
     * @return string;
     */
    public function getErrors() {
        $message = odbc_errormsg();
        return $message;
    }

    /*
     * Get Columns names resulting from Current Select Query
     * 
     * @return array
     */
    public function getColumns() {
        $columns = array();
        for ($i = 1; $i <= odbc_num_fields($this->resultSet); $i++) {
            $columns[$i] = odbc_field_name($this->resultSet, $i);
        }
        return $columns;
    }
    
    /*
     * Get Columns types resulting from Current Select Query
     * 
     * @return array
     */
    public function getColumnsType(){
        $types = array();
        for ($i = 1; $i <= odbc_num_fields($this->resultSet); $i++) {
            $types[$i] = odbc_field_type($this->resultSet, $i);
        }
        return $types;
    }

}
