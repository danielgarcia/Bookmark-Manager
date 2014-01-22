<?php

class Database extends PDO {

    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS) {
        parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS);
    }
    
    /**
     * SQL Select function
     *
     * @param string $sql The SQL string
     * @param array $array The Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return an array of information
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC) {
        $sth = $this->prepare($sql);
        
        foreach ($array as $key => $value) {
            $sth->bindValue("$key", $value);
        }

        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }
    
    /**
     * SQL Insert function
     *
     * @param string $table The name of table to insert into
     * @param string $data The associative array
     * @return boolean if the insert was a success
     */
    public function insert($table, $data) {
        ksort($data);
        
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));
        
        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        return $sth->execute();
    }
    

    /**
     * SQL Update function
     *
     * @param string $table The name of table to insert into
     * @param string $data The associative array
     * @param string $where The WHERE query part
     * @return boolean if the update was a success
     */
    public function update($table, $data, $where) {
        ksort($data);
        
        $fieldDetails = NULL;
        foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        return $sth->execute();
    }
    

    /**
     * SQL Delete function
     * 
     * @param string $table The name of table to insert into
     * @param string $where The WHERE query part
     * @param integer $limit The LIMIT query part
     * @return integer Affected Rows
     */
    public function delete($table, $where, $limit = 1) {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }
    
}