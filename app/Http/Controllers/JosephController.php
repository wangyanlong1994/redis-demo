<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\String_;

class JosephController extends Controller
{

    private $n = 3;

    private $m = 10;


    //“约瑟夫环”是一个数学的应用问题：一群猴子排成一圈，按1,2,…,n依次编号。然后从第1只开始数，数到第m只,把它踢出圈，从它后面再开始数， 再数到第m只，在把它踢出去…，如此不停的进行下去， 直到最后只剩下一只猴子为止，那只猴子就叫做大王。要求编程模拟此过程，输入m、n, 输出最后那个大王的编号。
    public function joseph($type = 1)
    {
        $name = 'joseph' . $type;
        return $this->$name();
    }

    private function joseph1($n = 3, $m = 10)
    {
        $arr = range(1, $m);
        $i = 0;
        for (; $i >= 0;) {
            $arr_sum = count($arr);
            if ($arr_sum == 1) {
                return $arr;
            }
            $i++;
            if ($i == $n) {
                unset($arr[0]);
                $i = 0;
            } else {
                $head = array_shift($arr);
                array_push($arr, $head);
            }
        }
    }

    private function joseph2($n = 10, $m = 3)
    {
        $monkey[0] = 0;
        //将1-n只猴子顺序编号 入数组中
        for ($i = 1; $i <= $n; $i++) {
            $monkey[$i] = $i;
        }
        $len = count($monkey);
        //循环遍历数组元素(猴子编号)
        for ($i = 0; $i < $len; $i = $i) {
            $num = 0;
            /*
             * 遍历$monkey数组，计算数组中值不为0的元素个数（剩余猴子的个数）
             * 赋值为$num，并获取值不为0的元素的元素值
            */
            foreach ($monkey as $key => $value) {
                if ($value == 0) continue;
                $num++;
                $values = $value;
            }
            //若只剩一只猴子 则输出该猴子编号(数组元素值) 并退出循环
            if ($num == 1) {
                return $values;
                exit;
            }
            /*
             * 若剩余猴子数大于1（$num > 1）
             * 继续程序
            */
            //将第$i只猴子踢出队伍(相应数组位置元素值设为0)
            $monkey[$i] = 0;
            /*
             * 获取下一只需要踢出队伍的猴子编号
             * 在$m值范围内遍历猴子 并设置$m的计数器
             * 依次取下一猴子编号
             * 若元素值为0，则该位置的猴子已被踢出队伍
             * 若不为0，继续获取下一猴子编号，且计数器加1
             * 若取得的猴子编号大于数组个数
             * 则从第0只猴子开始遍历(数组指针归零) 步骤同上
             * 直到计数器到达$m值 * 最后获取的$i值即为下一只需要踢出队伍的猴子编号
             */
            //设置计数器
            for ($j = 1; $j <= $m; $j++) {
                //猴子编号加一，遍历下一只猴子
                $i++;
                //若该猴子未被踢出队伍,获取下一只猴子编号
                if ($monkey[$i] > 0) continue;
                //若元素值为0，则猴子已被踢出队伍，进而循环取下一只猴子编号
                if ($monkey[$i] == 0) {
                    //取下一只猴子编号
                    for ($k = $i; $k < $len; $k++) {
                        //值为0，编号加1
                        if ($monkey[$k] == 0) $i++;
                        //否则，编号已取得，退出
                        if ($monkey[$k] > 0) break;
                    }
                }
                //若编号大于猴子个数，则从第0只猴子开始遍历(数组指针归零) 步骤同上
                if ($i == $len) $i = 0;
                //同上步骤，获取下一只猴子编号
                if ($monkey[$i] == 0) {
                    for ($k = $i; $k < $len; $k++) {
                        if ($monkey[$k] == 0) $i++;
                        if ($monkey[$k] > 0) break;
                    }
                }
            }
        }
    }

    private function joseph3($n = 3, $m = 10)
    {
        $monkeys = range(1, $m);
        return $this->killMonkey($monkeys, 3);
    }

    // 递归算法
    private function killMonkey($monkeys, $m, $current = 0)
    {
        $number = count($monkeys);
        $num = 1;
        if (count($monkeys) == 1) {
            return $monkeys[0];
        } else {
            while ($num++ < $m) {
                $current++;
                $current = $current % $number;
            }
            array_slice($monkeys, $current, 1);
            $this->killMonkey($monkeys, $m, $current);
        }
    }

}
