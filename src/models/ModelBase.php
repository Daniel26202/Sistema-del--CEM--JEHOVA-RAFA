<?php

namespace App\models;

use PDO;
use App\models\interfaces\InterfaceConnection;

abstract class ModelBase
{

    private $tables;
    private $colums;
    private $condicionAditional;
    private $alias;
    private $union;
    private $ordenColumn;
    private $search;
    private $start;
    private $limit;
    private $ordenDir;
    private $conn;

    function __construct(InterfaceConnection $conn)
    {
        $this->conn = $conn->getConn();
        $this->tables = [];
        $this->colums = [" * "];
        $this->alias = [];
        $this->union = [];
        $this->condicionAditional = [];
        $this->ordenColumn = 'id';
        $this->limit = 0;
        $this->start = 0;
        $this->search = '';
        $this->ordenDir = 'DESC';
    }

    //conection
    protected function getPDO()
    {
        return $this->conn;
    }

    //begintrasaction
    protected function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    //commit
    protected function commit()
    {
        return $this->conn->commit();
    }

    //rollBack
    protected function rollBack()
    {
        return $this->conn->rollBack();
    }

    private function return_data($data)
    {
        $paramts = [];
        foreach ($data as $key => $value) {
            $paramts[":" . $key] = $value;
        }
        $columsSQL = implode(', ', array_keys($data));
        $placeholder = implode(', ', array_keys($paramts));
        return [$columsSQL, $placeholder, $paramts];
    }

    private function buildFromAndWhere()
    {
        $paramts = [];
        $paramts_count = [];
        $paramts_count_total = [];
        $cadena_sql = '';
        $sql_full = '';
        $sql_count = '';
        $sql_count_total = '';
        $cadena_sql .= (!empty($this->search) || !empty($this->condicionAditional)) ? " WHERE " : ' ';
        $conector = '';

        if (!empty($this->condicionAditional)) {
            if (count($this->condicionAditional['conectores']) != (count($this->condicionAditional['condiciones']) - 1)) {
                throw new \Exception('los conectores de la codicion tiene que ser 1 menor que el numero de las codiciones');
            }

            $operadoresPermitidos = ['=', '!=', '>', '<', '>=', '<=', 'LIKE', 'IS NOT', 'IS'];
            $no_permitidos = array_diff($this->condicionAditional['operadores'], $operadoresPermitidos);

            if (!empty($no_permitidos)) {
                throw new \Exception('El operador no esta permitido');
            }

            $ultimo_conector = '';

            $cont = 0;
            foreach ($this->condicionAditional['condiciones'] as $key => $condition) {
                $conect = isset($this->condicionAditional['conectores'][$cont]) ? $this->condicionAditional['conectores'][$cont] : '';
                $operador = isset($this->condicionAditional['operadores'][$cont]) ? $this->condicionAditional['operadores'][$cont] : '';

                $placeholder = (str_contains($key, '.')) ? explode('.', $key)[1] : $key;
                //si en valor es una funcion propia de sql la paso directo
                if (in_array($condition, ['CURRENT_DATE', 'NOW()'])) {
                    $cadena_sql .= " {$key} {$operador} {$condition} {$conect} ";
                } else {
                    $cadena_sql .= " {$key} {$operador} :{$placeholder} {$conect} ";
                    $paramts["{$placeholder}"] = $condition;
                }
                $ultimo_conector = $conect;
                $cont += 1;
            }

            $ultimo_and = strrpos($cadena_sql, $ultimo_conector);
            if ($ultimo_and) {
                $cadena_sql = substr($cadena_sql, 0, $ultimo_and);
            }

            $conector = " AND ";
        }

        $paramts_count = $paramts;
        $paramts_count_total = $paramts;

        //sql para obtener la totalidad de los registrso sin filtro
        $sql_count_total .= $cadena_sql;

        if (!empty($this->search)) {
            $cadena_sql .= $conector;
            foreach ($this->colums as $colum) {
                if (strrpos($colum, 'AS')) {
                    $alias = explode("AS", $colum);
                    $colum = $alias[0];
                }
                $cadena_sql .= "$colum LIKE :buscar OR ";
            }
            //eliminar el ultimo OR
            $ultimo_or = strrpos($cadena_sql, 'OR');

            if ($ultimo_or) {
                $cadena_sql = substr($cadena_sql, 0, $ultimo_or);
            }

            $paramts['buscar'] = "%$this->search%";
            $paramts_count['buscar'] = "%$this->search%";
        }

        //sql para obtener el total de registros filtrados
        $sql_count .= $cadena_sql;

        if ($this->limit > 0) {
            $cadena_sql .= " ORDER BY {$this->ordenColumn} {$this->ordenDir} LIMIT :inicio, :limite";
            $paramts['inicio'] = (int)$this->start;
            $paramts['limite'] = (int)$this->limit;
        }

        $sql_full .= $cadena_sql;

        return [
            ['sql_full' => $sql_full, 'paramts' => $paramts],
            ['sql_count' => $sql_count, 'paramts' => $paramts_count],
            ['sql_count_total' => $sql_count_total, 'paramts' => $paramts_count_total],
        ];
    }

    protected function read($all = true, $funcion = false, $paramt = '*',$for_update =false)
    {
        try {
            $paramts = [];
            $columsSQL = (!$funcion) ? implode(',', $this->colums) : "{$funcion}({$paramt}) AS total";
            $sql = "SELECT $columsSQL FROM ";
            $sql_full = '';

            //si el mas de una tabla se le agrega el inner join
            if (count($this->tables) > 1) {
                foreach ($this->tables as $key => $value) {
                    if (count($this->tables) != count($this->alias)) {
                        echo "El numero de tablas no coincide con el numero de alias";
                        return;
                    }
                    if ($key == 0) {
                        $sql .= " {$value} {$this->alias[$key]}";
                    } else {
                        $sql .= " INNER JOIN {$value} {$this->alias[$key]} ON {$this->union[$key - 1]}";
                    }
                }
            } else {
                $sql .= " {$this->tables[0]} ";
            }
            $for_update = $for_update ? ' FOR UPDATE ': '';
            $data_sql = $this->buildFromAndWhere();
            $sql_full .= $sql . ' ' . $data_sql[0]['sql_full'].' '. $for_update;
            $paramts = $data_sql[0]['paramts'];

            $query = $this->getPDO()->prepare($sql_full);
            foreach ($paramts as $key => $value) {
                $type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                $query->bindValue(":$key", $value, $type);
            }

            if ($query->execute()) {
                return (!empty($all)) ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC);
            }
        } catch (\Exception $e) {
            return 'Error read: ' . $e;
        }
    }

    protected function pagination()
    {
        try {
            $columsSQL =  implode(',', $this->colums);
            $cadena_sql = '';
            $sql_full = "SELECT $columsSQL FROM ";
            $sql_count = "SELECT COUNT(*) AS total FROM ";
            $sql_count_total = $sql_count;

            //si el mas de una tabla se le agrega el inner join
            if (count($this->tables) > 1) {
                foreach ($this->tables as $key => $value) {
                    if (count($this->tables) != count($this->alias)) {
                        echo "El numero de tablas no coincide con el numero de alias";
                        return;
                    }
                    if ($key == 0) {
                        $cadena_sql .= " {$value} {$this->alias[$key]} ";
                    } else {
                        $cadena_sql .= " INNER JOIN {$value} {$this->alias[$key]} ON {$this->union[$key - 1]}";
                    }
                }
            } else {
                $cadena_sql .= " {$this->tables[0]} ";
            }

            $data_sql = $this->buildFromAndWhere();

            $sql_full .= $cadena_sql . ' ' . $data_sql[0]['sql_full'];
            $sql_count .= $cadena_sql . ' ' . $data_sql[1]['sql_count'];
            $sql_count_total .= $cadena_sql . ' ' . $data_sql[2]['sql_count_total'];

            $paramts = $data_sql[0]['paramts'];
            $paramts_count = $data_sql[1]['paramts'];
            $paramts_count_total = $data_sql[2]['paramts'];

            $query = $this->getPDO()->prepare($sql_full);
            $query_2 = $this->getPDO()->prepare($sql_count);
            $query_3 = $this->getPDO()->prepare($sql_count_total);

            foreach ($paramts as $key => $value) {
                $type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                $query->bindValue(":$key", $value, $type);
            }

            foreach ($paramts_count as $key => $value) {
                $type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                $query_2->bindValue(":$key", $value);
            }

            foreach ($paramts_count_total as $key => $value) {
                $type = is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
                $query_3->bindValue(":$key", $value);
            }

            $data = ($query->execute()) ? $query->fetchAll(PDO::FETCH_ASSOC) : [];
            $total_filtrado = ($query_2->execute()) ? $query_2->fetch(PDO::FETCH_ASSOC) : 0;
            $total = ($query_3->execute()) ? $query_3->fetch(PDO::FETCH_ASSOC) : 0;

            return [
                'data' => $data,
                'total' => (int)$total['total'],
                'total_filtrado' => (int)$total_filtrado['total']
            ];
        } catch (\Exception $e) {
            return 'Error pagination: ' . $e;
        }
    }

    protected function create()
    {
        try {
            $columsSQL = $this->return_data($this->colums)[0];
            $placeholder = $this->return_data($this->colums)[1];
            $paramts = $this->return_data($this->colums)[2];

            $sql = "INSERT INTO {$this->tables[0]}  ($columsSQL) VALUES ($placeholder)";
            $query = $this->getPDO()->prepare($sql);
            foreach ($paramts as $key => $value) {
                $query->bindValue($key, $value);
            }
            $query->execute();
            return [$this->getPDO()->lastInsertId()];
        } catch (\Exception $e) {
            return $e;
        }
    }

    protected function update(array $data)
    {
        try {
            $paramts = $this->return_data($this->colums)[2];

            $sql = "UPDATE {$this->tables[0]} SET ";
            foreach ($this->colums as $key => $value) {
                $sql .= "$key =:$key, ";
            }
            $ultima_coma = strrpos($sql, ',');
            if ($ultima_coma) {
                $sql = substr($sql, 0, $ultima_coma);
            }
            $keys = array_filter(array_keys($data), function ($value) {
                return !is_int($value);
            });

            $sql .= " WHERE ";
            foreach ($keys as $key => $value) {
                $and = !$key == 0 ? 'AND' : '';
                $sql .= " {$and} {$value} =:{$value} ";
                $paramts[":{$value}"] = $data[$value];
            }

            $query = $this->getPDO()->prepare($sql);
            foreach ($paramts as $key => $value) {
                $query->bindValue($key, $value);
            }
            $query->execute();
            return [1];
        } catch (\Exception $e) {
            return $e;
        }
    }


    protected function delete(array $data)
    {
        try {
            $paramts = [];
            $sql = "DELETE FROM {$this->tables[0]} ";

            $keys = array_filter(array_keys($data), function ($value) {
                return !is_int($value);
            });

            $sql .= " WHERE ";
            foreach ($keys as $key => $value) {
                $and = !$key == 0 ? 'AND' : '';
                $sql .= " {$and} {$value} =:{$value} ";
                $paramts[":{$value}"] = $data[$value];
            }
            $query = $this->getPDO()->prepare($sql);
            foreach ($paramts as $key => $value) {
                $query->bindValue($key, $value);
            }
            $query->execute();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }

    protected function callStoredProdcedure(string $name, array $colums, $all = false,$insert = false)
    {
        try {
            $paramts = [];

            $sql = "call {$name}(";

            $keys = array_filter(array_keys($colums), function ($value) {
                return !is_int($value);
            });

            foreach ($keys as $key => $value) {
                $coma = !$key == 0 ? ',' : '';
                $sql .= "{$coma} :{$value}";
                $paramts[":{$value}"] = $colums[$value];
            }
            $sql .= ")";

            $query = $this->getPDO()->prepare($sql);
            foreach ($paramts as $key => $value) {
                $query->bindValue($key, $value);
            }
            $query->execute();
            
            if ($insert) {
                return $this->getPDO()->lastInsertId();
            }

            return $all ? $query->fetchAll(PDO::FETCH_ASSOC): 1;
        } catch (\Exception $e) {
            return $e;
        }
    }



    protected function get_tables()
    {
        return $this->tables;
    }

    protected function get_colums()
    {
        return $this->colums;
    }

    protected function get_alias()
    {
        return $this->alias;
    }

    protected function get_union()
    {
        return $this->union;
    }


    protected function get_orden_column()
    {
        return $this->ordenColumn;
    }

    protected function get_search()
    {
        return $this->search;
    }

    protected function get_start()
    {
        return $this->start;
    }

    protected function get_limit()
    {
        return $this->limit;
    }

    protected function get_orden_dir()
    {
        return $this->ordenDir;
    }

    protected function get_condicion_aditional()
    {
        return $this->condicionAditional;
    }


    protected function set_tables($tables)
    {
        $this->tables = $tables;
    }

    protected function set_colums($colums)
    {
        $this->colums = $colums;
    }

    protected function set_alias($alias)
    {
        $this->alias = $alias;
    }


    protected function set_union($union)
    {
        $this->union = $union;
    }


    protected function set_orden_column($ordenColumn)
    {
        $this->ordenColumn = $ordenColumn;
    }


    protected function set_search($search)
    {
        $this->search = $search;
    }

    protected function set_start($start)
    {
        $this->start = $start;
    }

    protected function set_limit($limit)
    {
        $this->limit = $limit;
    }

    protected function set_orden_dir($ordenDir)
    {
        $this->ordenDir = $ordenDir;
    }

    protected function set_condicion_aditional($condicionAditional)
    {
        $this->condicionAditional = $condicionAditional;
    }
}
