<?php

namespace Tests\Unit;

use App\Helpers\Status;
use PHPUnit\Framework\TestCase;

class StatusHelperTest extends TestCase
{
    /**
     * Проверка фильтра статуса пользователя.
     * Диапазон принимаемых значений - целое число от 1 до 3
     * Если передано что-то отличное от этого, возвращается 1 (онлайн)
     * @test
     * @return void
     */
    public function filtrate()
    {
        $validated = Status::filtrate(2);
        $this->assertEquals(2, $validated);

        $validated = Status::filtrate(5);
        $this->assertEquals(1, $validated);

        $validated = Status::filtrate('test');
        $this->assertEquals(1, $validated);
    }
}
