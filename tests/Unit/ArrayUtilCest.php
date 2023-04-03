<?php


namespace Tests\Unit;

use Assegai\Util\ArrayUtil;
use Tests\Support\UnitTester;

class ArrayUtilCest
{
  public function _before(UnitTester $I)
  {
  }

  // tests

  /**
   * @param UnitTester $I
   * @return void
   */
  public function testInArrayMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertTrue(ArrayUtil::inArray(1, $array));
    $I->assertFalse(ArrayUtil::inArray(6, $array));
  }

  public function testIsAssociativeMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertFalse(ArrayUtil::isAssociative($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $I->assertTrue(ArrayUtil::isAssociative($array));
  }

  public function testIsEmptyMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertFalse(ArrayUtil::isEmpty($array));
    $array = [];
    $I->assertTrue(ArrayUtil::isEmpty($array));
  }

  public function testIsMultidimensionalMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertFalse(ArrayUtil::isMultidimensional($array));
    $array = [[1, 2, 3], [4, 5, 6]];
    $I->assertTrue(ArrayUtil::isMultidimensional($array));
  }

  public function testIsNotEmptyMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertTrue(ArrayUtil::isNotEmpty($array));
    $array = [];
    $I->assertFalse(ArrayUtil::isNotEmpty($array));
  }

  public function testIsSequentialMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertTrue(ArrayUtil::isSequential($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $I->assertFalse(ArrayUtil::isSequential($array));
  }

  public function testIsNotSequentialMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertFalse(ArrayUtil::isNotSequential($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $I->assertTrue(ArrayUtil::isNotSequential($array));
  }

  public function testIsNotAssociativeMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertTrue(ArrayUtil::isNotAssociative($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $I->assertFalse(ArrayUtil::isNotAssociative($array));
  }

  public function testIsNotMultidimensionalMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertTrue(ArrayUtil::isNotMultidimensional($array));
    $array = [[1, 2, 3], [4, 5, 6]];
    $I->assertFalse(ArrayUtil::isNotMultidimensional($array));
  }

  public function testIsNotNumericMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertFalse(ArrayUtil::isNotNumeric($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $I->assertTrue(ArrayUtil::isNotNumeric($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3, 1, 2, 3];
    $I->assertTrue(ArrayUtil::isNotNumeric($array));
  }

  public function testIsNumericMethod(UnitTester $I): void
  {
    $array = [1, 2, 3, 4, 5];
    $I->assertTrue(ArrayUtil::isNumeric($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3];
    $I->assertFalse(ArrayUtil::isNumeric($array));
    $array = ['a' => 1, 'b' => 2, 'c' => 3, 1, 2, 3];
    $I->assertFalse(ArrayUtil::isNumeric($array));
  }
}
