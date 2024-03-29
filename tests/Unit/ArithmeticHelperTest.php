<?php


use PHPUnit\Framework\TestCase;

class ArithmeticHelperTest extends TestCase
{
    public function test_add_can_sum_numbers_up()
    {
        $num1 = 5;
        $num2 = 10;
        $sum = $num1 + $num2;

        $result = \App\Helpers\Math\ArithmeticHelper::add($num1, $num2,);

        $this->assertSame($sum, $result, 'Does not add numbers correctly.');
    }

    public function test_add_can_take_in_multiple_numbers()
    {
        $num1 = 5;
        $num2 = 10;
        $num3 = 120;
        $sum = $num1 + $num2 + $num3;

        $result = \App\Helpers\Math\ArithmeticHelper::add($num1, $num2, $num3);

        $this->assertSame($sum, $result, 'Does not work when has multiple arguments.');
    }

    public function test_add_cannot_take_in_string_arguments()
    {
        $this->expectException(InvalidArgumentException::class);

        $result = \App\Helpers\Math\ArithmeticHelper::add("abc");
    }

    public function test_add_cannot_take_in_array_arguments()
    {
        $this->expectException(InvalidArgumentException::class);

        $result = \App\Helpers\Math\ArithmeticHelper::add(["abc"]);
    }

    public function test_add_cannot_take_in_null_arguments()
    {
        $this->expectException(InvalidArgumentException::class);

        $result = \App\Helpers\Math\ArithmeticHelper::add(null);
    }

    public function test_add_can_only_take_in_boolean_arguments()
    {
        $this->expectException(InvalidArgumentException::class);

        $result = \App\Helpers\Math\ArithmeticHelper::add(true);
    }

    public function test_add_cannot_take_in_function_arguments()
    {
        $this->expectException(InvalidArgumentException::class);

        $result = \App\Helpers\Math\ArithmeticHelper::add(fn ()=> true);
    }

    public function test_add_needs_at_least_one_argument()
    {
        $this->expectException(InvalidArgumentException::class);

        $result = \App\Helpers\Math\ArithmeticHelper::add();
    }
}
