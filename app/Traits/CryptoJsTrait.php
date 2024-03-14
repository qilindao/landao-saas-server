<?php

namespace App\Traits;

use App\Support\CryptoJsSup;

trait CryptoJsTrait
{
    protected $cryptoJs = null;

    public function __construct()
    {
    }

    /**
     * @param $screctKey
     * @return void
     */
    public function setCryptoJs($screctKey): void
    {
        $this->cryptoJs = new CryptoJsSup($screctKey);
    }

    /**
     * 对返回的字段进行解密
     * @param array $row
     * @return array
     */
    public function decryptRow(array $row)
    {
        foreach ($this->DbAttribute as $key) {
            if (isset($row[$key])) {
                $row[$key] = $this->cryptoJs->decrypt((string)$row[$key]);
            }
        }
        return $row;
    }

    /**
     * 某字符串进行解密
     * @param $value
     * @return mixed
     */
    public function decrypt($value)
    {
        return $this->cryptoJs->decrypt((string)$value);
    }

    /**
     * 数组集进行解密
     * @param array $rows
     * @return array
     */
    public function decryptRows(array $rows):array
    {
        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->decryptRow($row);
        }
        return $list;
    }

    /**
     * 对返回的 字段 进行加密
     * @param array $row
     * @return array
     */
    public function encryptRow(array $row):array
    {
        foreach ($this->DbAttribute as $key) {
            if (isset($row[$key])) {
                $row[$key] = $this->cryptoJs->encrypt((string)$row[$key]);
            }
        }
        return $row;
    }

    /**
     * 数组集进行加密
     * @param array $rows
     * @return array
     */
    public function encryptRows(array $rows):array
    {
        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->encryptRow($row);
        }
        return $list;
    }

}
