<?php
namespace  Chive\Helper\Mongo;


use Chive\Helper\Mongo\Exception\MongoDBException;
use Chive\Helper\Mongo\Pool\PoolFactory;
use Hyperf\Utils\Context;

/**
 * Class MongoDb
 * @package Hyperf\Mongodb
 */
class MongoDb
{
    /**
     * @var PoolFactory
     */
    protected $factory;

    /**
     * @var string
     */
    protected $poolName = 'default';

    public function __construct(PoolFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * 返回满足filer的全部数据
     *
     * @param string $namespace
     * @param array $filter
     * @param array $options
     * @return array
     * @throws MongoDBException
     */
    public function fetchAll(string $namespace, array $filter = [], array $options = []): array
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->executeQueryAll($namespace, $filter, $options);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 返回满足filer的分页数据
     *
     * @param string $namespace
     * @param int $limit
     * @param int $currentPage
     * @param array $filter
     * @param array $options
     * @return array
     * @throws MongoDBException
     */
    public function fetchPagination(string $namespace, int $limit, int $currentPage, array $filter = [], array $options = []): array
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->execQueryPagination($namespace, $limit, $currentPage, $filter, $options);
        } catch (\Exception  $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 批量插入
     * @param $namespace
     * @param array $data
     * @return bool|string
     * @throws MongoDBException
     */
    public function insertAll($namespace, array $data)
    {
        if (count($data) == count($data, 1)) {
            throw new  MongoDBException('data is can only be a two-dimensional array');
        }
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->insertAll($namespace, $data);
        } catch (MongoDBException $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 数据插入数据库
     *
     * @param $namespace
     * @param array $data
     * @return bool|mixed
     * @throws MongoDBException
     */
    public function insert($namespace, array $data = [])
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->insert($namespace, $data);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 更新数据满足$filter的行的信息成$newObject
     *
     * @param $namespace
     * @param array $filter
     * @param array $newObj
     * @return bool
     * @throws MongoDBException
     */
    public function updateRow($namespace, array $filter = [], array $newObj = []): bool
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->updateRow($namespace, $filter, $newObj);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 只更新数据满足$filter的行的列信息中在$newObject中出现过的字段
     *
     * @param $namespace
     * @param array $filter
     * @param array $newObj
     * @return bool
     * @throws MongoDBException
     */
    public function updateColumn($namespace, array $filter = [], array $newObj = []): bool
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->updateColumn($namespace, $filter, $newObj);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

//    /**
//     * 更新数据自定义适合复杂更新sql
//     *
//     * @param $namespace
//     * @param array $filter
//     * @param array $newObj
//     * @return bool
//     * @throws MongoDBException
//     */
//    public function update($namespace, array $filter = [], array $newObj = []): bool
//    {
//        try {
//            /**
//             * @var $collection MongoDBConnection
//             */
//            $collection = $this->getConnection();
//            return $collection->update($namespace, $filter, $newObj);
//        } catch (\Exception $e) {
//            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
//        }
//    }

    /**
     * 删除满足条件的数据，默认只删除匹配条件的第一条记录，如果要删除多条$limit=true
     *
     * @param string $namespace
     * @param array $filter
     * @param bool $limit
     * @return bool
     * @throws MongoDBException
     */
    public function delete(string $namespace, array $filter = [], bool $limit = false): bool
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->delete($namespace, $filter, $limit);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 删除满足条件的所有数据，不做条数限制
     *
     * @param string $namespace
     * @param array $filter
     * @return bool
     * @throws MongoDBException
     */
    public function deleteAll(string $namespace, array $filter = []): bool
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->deleteAll($namespace, $filter);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 返回collection中满足条件的数量
     *
     * @param string $namespace
     * @param array $filter
     * @return bool
     * @throws MongoDBException
     */
    public function count(string $namespace, array $filter = [])
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->count($namespace, $filter);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }


    /**
     * 聚合查询
     * @param string $namespace
     * @param array $filter
     * @return bool
     * @throws MongoDBException
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function command(string $namespace, array $filter = [])
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->command($namespace, $filter);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    private function getConnection()
    {
        $connection = null;
        $hasContextConnection = Context::has($this->getContextKey());
        if ($hasContextConnection) {
            $connection = Context::get($this->getContextKey());
        }
        if (!$connection instanceof MongoDbConnection) {
            $pool = $this->factory->getPool($this->poolName);
            $connection = $pool->get()->getConnection();
        }
        return $connection;
    }

    /**
     * The key to identify the connection object in coroutine context.
     */
    private function getContextKey(): string
    {
        return sprintf('mongodb.connection.%s', $this->poolName);
    }

    /**
     * 根据条件去修改记录
     *
     * @param string $namespace
     * @param array $filter
     * @return bool
     * @throws MongoDBException
     */
    public function update(string $namespace, array $filter = [], array $update = [])
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->update($namespace, $filter, $update);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    /**
     * 根据条件去修改记录(返回具体更新条数)
     *
     * @param string $namespace
     * @param array $filter
     * @return bool
     * @throws MongoDBException
     */
    public function updateReturnRow(string $namespace, array $filter = [], array $update = [])
    {
        try {
            /**
             * @var $collection MongoDBConnection
             */
            $collection = $this->getConnection();
            return $collection->updateReturnRow($namespace, $filter, $update);
        } catch (\Exception $e) {
            throw new MongoDBException($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }



}