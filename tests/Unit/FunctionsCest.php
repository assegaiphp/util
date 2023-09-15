<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;

class FunctionsCest
{
  public function _before(UnitTester $I): void
  {
    $functionsFilePath = dirname(__DIR__, 2) . '/src/Functions.php';

    // Check if the file has already been included.
    if (! in_array($functionsFilePath, get_included_files()) )
    {
      require_once $functionsFilePath;
    }
  }

  // tests
  public function testArrayFunctions(UnitTester $I): void
  {
    $needle = 'needle';
    $haystack = ['foo', 'bar', 'needle', 'baz'];
    $needleLessHaystack = ['foo', 'bar', 'baz'];
    $emptyHaystack = [];

    $I->wantToTest('that the array_first function works as expected');
    $I->assertEquals('foo', array_first($haystack));
    $I->assertNull(array_first($emptyHaystack));
    $I->expectThrowable('TypeError', function () use ($needle) { array_first($needle); });

    $I->wantToTest('that the array_last function works as expected');
    $I->assertEquals('baz', array_last($haystack));
    $I->assertNull(array_last($emptyHaystack));
    $I->expectThrowable('TypeError', function () use ($needle) { array_last($needle); });

    $I->wantToTest('that the array_find function works as expected');
    $I->assertEquals('needle', array_find($haystack, function ($item) use ($needle) { return $item === $needle; }));
    $I->assertNull(array_find($needleLessHaystack, function ($item) use ($needle) { return $item === $needle; }));
    $I->assertNull(array_find($emptyHaystack, function ($item) use ($needle) { return $item === $needle; }));

    $I->expectThrowable('TypeError', function () use ($needle) { array_find($needle, function ($item) use ($needle) { return $item === $needle; }); });

    $I->wantToTest('that the array_find_last function works as expected');
    $haystack = ['foo', 'bar', 'needle', 'needle', 'baz'];
    $I->assertEquals('needle', array_find_last($haystack, function ($item) use ($needle) { return $item === $needle; }));
    $I->assertNull(array_find_last($needleLessHaystack, function ($item) use ($needle) { return $item === $needle; }));
    $I->assertNull(array_find_last($emptyHaystack, function ($item) use ($needle) { return $item === $needle; }));

    $I->wantToTest('that the array_is_associative function works as expected');
    $associativeArray = ['foo' => 'bar', 'baz' => 'qux'];
    $sequentialArray = ['foo', 'bar', 'baz'];

    $I->assertTrue(array_is_associative($associativeArray));
    $I->assertFalse(array_is_associative($sequentialArray));
    $I->expectThrowable('TypeError', function () use ($needle) { return array_is_associative($needle); });

    $I->wantToTest('that the array_is_sequential function works as expected');
    $I->assertTrue(array_is_sequential($sequentialArray));
    $I->assertFalse(array_is_sequential($associativeArray));
    $I->expectThrowable('TypeError', function () use ($needle) { return array_is_sequential($needle); });

    $I->wantToTest('that the array_is_multi_dimensional function works as expected');
    $multiDimensionalArray = [['foo', 'bar'], ['baz', 'qux']];
    $I->assertTrue(array_is_multi_dimensional($multiDimensionalArray));
    $I->assertFalse(array_is_multi_dimensional($associativeArray));
    $I->assertFalse(array_is_multi_dimensional($sequentialArray));
    $I->expectThrowable('TypeError', function () use ($needle) { return array_is_multi_dimensional($needle); });

    $I->wantToTest('that the array_trim function works as expected');
    $array = [null, '', 'foo', '', 'bar', null, 'baz', false, 'qux', false, null];
    $I->assertEquals(['foo', '', 'bar', null, 'baz', false, 'qux'], array_trim($array));
    $I->assertEquals([], array_trim($emptyHaystack));
    $I->expectThrowable('TypeError', function () use ($needle) { return array_trim($needle); });

    $I->wantToTest('that the array_clean function works as expected');
    $cleanableArray = ['foo', '', 'bar', null, 'baz', false, 'qux'];
    $I->assertEquals(['foo', 'bar', 'baz', 'qux'], array_clean($cleanableArray));
    $I->assertEquals(['foo', '', 'bar', 'baz', false, 'qux'], array_clean($cleanableArray, true));
    $I->assertEquals([], array_clean($emptyHaystack));
    $I->expectThrowable('TypeError', function () use ($needle) { return array_clean($needle); });
  }

  public function testObjectFunctions(UnitTester $I): void
  {
    $I->wantToTest('that the object_to_array function works as expected');
    $object = new \stdClass();
    $object->foo = 'bar';
    $object->baz = 'qux';

    $I->assertEquals(['foo' => 'bar', 'baz' => 'qux'], object_to_array($object));
    $I->expectThrowable('TypeError', function () use ($object) { object_to_array($object->foo); });
  }

  public function testStringFunctions(UnitTester $I): void
  {
    $I->wantToTest('that the strtocamel function works as expected');
    $I->assertEquals('fooBar', strtocamel('foo_bar'));
    $I->assertEquals('fooBar', strtocamel('foo-bar'));
    $I->assertEquals('fooBar', strtocamel('foo bar'));
    $I->assertEquals('fooBar', strtocamel('fooBar'));
    $I->expectThrowable('TypeError', function () { strtocamel(null); });

    $I->wantToTest('that the strtopascal function works as expected');
    $I->assertEquals('FooBar', strtopascal('foo_bar'));
    $I->assertEquals('FooBar', strtopascal('foo-bar'));
    $I->assertEquals('FooBar', strtopascal('foo bar'));
    $I->assertEquals('FooBar', strtopascal('fooBar'));
    $I->assertEquals('Foobar', strtopascal('FOOBAR'));
    $I->expectThrowable('TypeError', function () { strtopascal(null); });

    $I->wantToTest('that the strtosnake function works as expected');
    $I->assertEquals('foo_bar', strtosnake('foo_bar'));
    $I->assertEquals('foo_bar', strtosnake('foo-bar'));
    $I->assertEquals('foo_bar', strtosnake('foo bar'));
    $I->assertEquals('foo_bar', strtosnake('fooBar'));
    $I->assertEquals('foobar', strtosnake('FOOBAR'));
    $I->expectThrowable('TypeError', function () { strtosnake(null); });

    $I->wantToTest('that the strtokebab function works as expected');
    $I->assertEquals('foo-bar', strtokebab('foo_bar'));
    $I->assertEquals('foo-bar', strtokebab('foo-bar'));
    $I->assertEquals('foo-bar', strtokebab('foo bar'));
    $I->assertEquals('foo-bar', strtokebab('fooBar'));
    $I->assertEquals('foobar', strtokebab('FOOBAR'));
    $I->expectThrowable('TypeError', function () { strtokebab(null); });

    $I->wantToTest('that the strtokebab_ucfirst function works as expected');
    $I->assertEquals('Foo-bar', strtokebab_ucfirst('foo_bar'));
    $I->assertEquals('Foo-bar', strtokebab_ucfirst('foo-bar'));
    $I->assertEquals('Foo-bar', strtokebab_ucfirst('foo bar'));
    $I->assertEquals('Foo-bar', strtokebab_ucfirst('fooBar'));
    $I->assertEquals('Foobar', strtokebab_ucfirst('FOOBAR'));
    $I->expectThrowable('TypeError', function () { strtokebab_ucfirst(null); });

    $I->wantToTest('that the extract_class_name function works as expected');
    $dummySource = <<<EOT
<?php

namespace App\Controllers;

class DummyController
{
}
EOT;

    $I->assertEquals('DummyController', extract_class_name($dummySource));
    $I->expectThrowable('TypeError', function () { extract_class_name(null); });
  }

  public function testDirectoryFunctions(UnitTester $I): void
  {
    $I->wantToTest('that the empty_directory function works as expected');
    $emptyDirectory = dirname(__DIR__, 2) . '/tests/_data/empty_directory';
    $nonEmptyDirectory = dirname(__DIR__, 2) . '/tests/_data/non_empty_directory';
    $filename = $nonEmptyDirectory . '/foo.txt';

    if (file_exists($nonEmptyDirectory))
    {
      touch($filename);
    }

    $I->assertTrue(empty_directory($emptyDirectory));
    $I->assertFalse(empty_directory($filename));
    $I->assertTrue(empty_directory($nonEmptyDirectory));
    $I->expectThrowable('TypeError', function () { empty_directory(null); });
  }
}