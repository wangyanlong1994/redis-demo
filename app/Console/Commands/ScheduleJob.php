<?php

namespace App\Console\Commands;

use Illuminate\Cache\Lock;
use Illuminate\Cache\RedisLock;
use Illuminate\Console\Command;
use Illuminate\Redis\Connections\Connection as RedisConnection;
use Illuminate\Support\Facades\Storage;

class ScheduleJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:job {process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mock Schedule Jobs';

    protected Lock $lock;

    /**
     * Create a new command instance.
     *
     * @param RedisConnection $redis
     */
    public function __construct(RedisConnection $redis)
    {
        parent::__construct();
        // 基于 redis 实现锁 ，过期时间 60s
        $this->lock = new RedisLock($redis, 'schedule_job', 60);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $processNo = $this->argument('process');
//        for ($i = 1; $i <= 10; $i++) {
//            $log = "Running Job #{$i} In Process #{$processNo}";
//            // 将运行日志记录到本地文件存储
//            Storage::disk('local')->append('schedule_job_logs', $log);
//            sleep(1); //模拟长时间运行的任务
//        }

        // 如果没有获取到锁，阻塞 5s， 否则执行回调函数
        $this->lock->block(5, function () {
            $processNo = $this->argument('process');
            for ($i = 1; $i <= 10; $i++) {
                $log = "Running Job #{$i} In Process #{$processNo}";
                Storage::disk('local')->append('schedule_job_logs', $log);
            }
        });
    }
}
