<?php
/**
 * 数据库连接基类
 */
class Db
{
    /**
     * 数据库连接
     *
     * @var MySQLi
     */
    private $db = NULL;

    /**
     * 构造函数
     */
    public function __construct()
    {
        // 连接数据库
        $this->connect();
    }

    /**
     * 连接到数据库
     *
     * @return MySQLi
     */
    public function connect(): MySQLi
    {
        if(!$this->db) {
            $this->db = new MySQLi(
                Core::$config['db']['host'],
                Core::$config['db']['user'],
                Core::$config['db']['pass'],
                Core::$config['db']['name']
            );
            // 连接出错
            if($this->db->connect_errno) {
                die(sprintf('Db Error: (%s) %s', $this->db->connect_errno, $this->db->connect_error));
            }
        }
        return $this->db;
    }

    /**
     * 创建查询
     *
     * @param string $sql
     * @return mysqli_stmt
     */
    public function prepare(string $sql): mysqli_stmt
    {
        $sql = str_ireplace('@', Core::$config['db']['prefix'] . $this->table_name, $sql);
        return $this->db->prepare($sql);
    }
}
