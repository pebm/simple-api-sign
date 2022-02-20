<?php

namespace SimpleApiSign;

/**
 * 简单API签名工具类
 * 
 * @Author Pebm
 * @DateTime 2022-02-20
 */
class SimpleApiSign
{
    /**
     * 检查数据的sign
     * 
     * @param array $data
     * @param string $token
     * @return bool
     * @Author Pebm
     * @DateTime 2022-02-20
     */
    public function check($data, $token) 
    {
        if ( empty($data['timestamp'] ) 
            ||empty($data['random']) 
            ||empty($data['sign'])
        ) {
            return false;
        }
    
        $sign = $data['sign'];
        $timestamp = $data['timestamp'];
        $random = $data['random'];
    
        unset($data['sign']);
        unset($data['timestamp']);
        unset($data['random']);
        
        $data = $this->obj2List($data);
        ksort($data);

        return $sign === $this->createSignature(
            implode('', $data), $timestamp, $random, $token
        );
    }

    /**
     * 创建sign数据
     * @param array $data
     * @param string $token
     * @return array
     * @Author Pebm
     * @DateTime 2022-02-20
     */
    public function create($data, $token)
    {
        $list = $this->obj2List($data);
        ksort($list);
        $dataString = implode('', $list);

        $data['timestamp'] = time() * 1000;
        $data['random'] = mt_rand(100000, 999999);

        $data['sign'] = $this->createSignature(
            $dataString, $data['timestamp'], $data['random'], $token
        );

        return $data;
    }

    private function createSignature($dataString, $timestamp, $random, $token)
    {
        return strtoupper(md5($dataString . $timestamp . $random . $token));
    }
    
    /**
     * 将数据转为一维数组
     * 
     * @param array $data
     * @param string $parentKey
     * @return array
     * @Author Pebm
     * @DateTime 2022-02-20
     */
    private function obj2List($data, $parentKey = ''): array
    {
        $newData = [];
    
        foreach( $data as $key => $value ) {
            $key = $parentKey . $key;
            
            if (is_object($value) || is_array($value)) {
                $newData = array_merge($newData, $this->obj2List($value, $key));
            } else {
                $newData[$key] = $value;
            }
        }
    
        return $newData;
    }
}