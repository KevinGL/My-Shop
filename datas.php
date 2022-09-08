<?php

class gestionSQL
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = new PDO("mysql:dbname=my_shop;port=8000;host=localhost", "Kevin", "DdSs601WwAa");
    }

    public function select(array $fields, string $table, array $conditions, bool $search=false)
    {
        $query = "SELECT " ;

        if($fields != ["*"])
        {
            $it = 0;
            foreach($fields as $f)
            {
                if($it < count($fields)-1)
                    $query .= $f . ", ";
                else
                    $query .= $f;

                $it++;
            }
        }

        else
            $query .= "*";

        $query .= " FROM " . $table;

        if(!empty($conditions))
        {
            $query .= " WHERE ";

            for($i=0 ; $i<count($conditions) ; $i+=2)
            {
                if(!$search)
                    $query .= $conditions[$i] . " LIKE '" . $conditions[$i+1] . "'";
                else
                    $query .= $conditions[$i] . " LIKE '%" . $conditions[$i+1] . "%'";

                if($i<count($conditions)-2)
                    $query .= " AND ";
            }

            //echo $query . '\n';

            $r = $this->pdo->query($query);

            //var_dump($r);

            $res = $r->fetch(PDO::FETCH_ASSOC);

            return $res;
        }
        
        else
        {
            $r = $this->pdo->query($query);

            $res = $r->fetchAll(PDO::FETCH_ASSOC);

            return $res;
        }

        //var_dump($query);
    }

    public function add(string $table, array $fields, array $values)
    {
        if(count($fields) != count($values))
        {
            echo "Erreur : Tableaux de tailles différentes !\n";
            return false;
        }

        if(count($fields) == 0 || count($values) == 0)
        {
            echo "Erreur : Tableau vide !\n";
            return false;
        }

        $query = "INSERT INTO " . $table . " (";

        $it = 0;
        foreach($fields as $f)
        {
            if($it < count($fields)-1)
                $query .= $f . ", ";
            else
                $query .= $f . ") VALUES (";

            $it++;
        }

        $it = 0;
        foreach($values as $v)
        {
            if($it < count($values)-1)
                $query .= "'" . $v . "', ";
            else
                $query .= "'" . $v . "');";

            $it++;
        }

        //echo $query;
        $this->pdo->query($query);
    }

    public function update(string $table, array $columns, array $conditions)
    {
        $query = "UPDATE " . $table . " SET ";

        for($i=0 ; $i<count($columns) ; $i+=2)
        {
            if($i < count($columns)-2)
                $query .= $columns[$i] . " = '" . $columns[$i+1] . "', ";
            else
                $query .= $columns[$i] . " = '" . $columns[$i+1] . "'";
        }

        if(!empty($conditions))
        {
            $query .= " WHERE ";
            
            for($i=0 ; $i<count($conditions) ; $i+=2)
            {
                if($i < count($conditions)-2)
                    $query .= $colconditionsumns[$i] . " LIKE '" . $conditions[$i+1] . "', ";
                else
                    $query .= $conditions[$i] . " LIKE '" . $conditions[$i+1] . "';";
            }
        }

        //echo $query;
        $this->pdo->query($query);
    }
}

$sql = new gestionSQL();

//$sql->update("users", ["username", "matthieu", "email", "matthieu@matthieu.fr"], ["username", "mathieu"]);