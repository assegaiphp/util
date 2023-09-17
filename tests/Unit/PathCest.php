<?php

namespace Tests\Unit;

use Assegai\Util\Path;
use Codeception\Attribute\Incomplete;
use SplFileInfo;
use stdClass;
use Tests\Support\UnitTester;
use TypeError;

class PathCest
{
  public function _before(UnitTester $I)
  {
  }

  // tests
  public function testTheBasenameMethod(UnitTester $I): void
  {
      $I->assertEquals('bar', Path::basename('foo/bar'));
  }

  public function testTheDelimiterMethod(UnitTester $I): void
  {
      $I->assertEquals('/', Path::delimiter());
  }

  public function testTheDirnameMethod(UnitTester $I): void
  {
      $I->assertEquals('foo', Path::dirname('foo/bar'));
  }

  public function testTheExtensionMethod(UnitTester $I): void
  {
      $I->assertEquals('php', Path::extension('foo/bar.php'));
  }

  public function testTheFormatMethod(UnitTester $I): void
  {
      $pathObject = new stdClass();
      $pathObject->dir = 'foo';
      $pathObject->base = 'bar';

      $I->assertEquals('foo/bar', Path::format($pathObject));

      $pathArray = [
          'dir' => 'foo',
          'base' => 'bar'
      ];
      $I->assertEquals('foo/bar', Path::format($pathArray));
  }

  public function testTheGetCwdMethod(UnitTester $I): void
  {
      $I->assertEquals(getcwd(), Path::getCwd());
  }

  public function testTheIsAbsoluteMethod(UnitTester $I): void
  {
      $I->assertTrue(Path::isAbsolute('/foo/bar'));
      $I->assertFalse(Path::isAbsolute('foo/bar'));
  }

  public function testTheJoinMethod(UnitTester $I): void
  {
    $I->assertEquals('foo/bar', Path::join('foo', 'bar'));
  }

  public function testTheNormalizeMethod(UnitTester $I): void
  {
    $I->assertEquals('foo/bar', Path::normalize('foo/can/../bar'));
    $I->assertEquals('/foo/bar/baz/asdf', Path::normalize('/foo/bar//baz/asdf/quux/..'));
    $I->expectThrowable(TypeError::class, function () {
      Path::normalize(null);
    });
  }

  public function testTheParseMethod(UnitTester $I): void
  {
    $I->assertEquals(
      [
        'dirname' => 'foo',
        'basename' => 'bar',
        'filename' => 'bar'
      ],
      Path::parse('foo/bar', Path::PARSE_ASSOC)
    );
    $I->assertEquals(
      [
        'dirname' => '/my/name/is',
        'basename' => 'kang.jpg',
        'extension' => 'jpg',
        'filename' => 'kang'
      ],
      Path::parse('/my/name/is/kang.jpg', Path::PARSE_ASSOC)
    );

    $pathObject = new stdClass();
    $pathObject->dirname = 'foo';
    $pathObject->basename = 'bar';
    $pathObject->filename = 'bar';
    $I->assertEquals($pathObject, Path::parse('foo/bar'));

    $pathObject = new stdClass();
    $pathObject->dirname = '/my/name/is';
    $pathObject->basename = 'kang.jpg';
    $pathObject->extension = 'jpg';
    $pathObject->filename = 'kang';
    $I->assertEquals($pathObject, Path::parse('/my/name/is/kang.jpg'));
  }

  public function testThePosixMethod(UnitTester $I): void
  {
    $I->assertEquals(new SplFileInfo('foo/bar'), Path::posix('foo\\bar'));
  }

  public function testTheRelativeMethod(UnitTester $I): void
  {
    if (PHP_OS_FAMILY === 'Windows')
    {
      $I->markTestSkipped('This test is not supported on Windows.');
    }
    $I->assertEquals('', Path::relative('foo/bar', 'foo/bar'));
    $I->assertEquals('..', Path::relative('foo/bar', 'foo'));
    $I->assertEquals('../../impl/bbb', Path::relative('/data/orandea/test/aaa', '/data/orandea/impl/bbb'));
    $I->assertEquals('baz', Path::relative('foo/bar', 'foo/bar/baz'));
    $I->assertEquals('../../../bar', Path::relative('foo/bar', 'foo/../../bar'));
    $I->assertEquals('../../bar', Path::relative('foo/bar', 'foo/../bar'));
  }

  public function testTheResolveMethod(UnitTester $I): void
  {
    $I->assertEquals('/foo/bar/baz', Path::resolve('/foo/bar', './baz'));
    $I->assertEquals('/tmp/file', Path::resolve('/foo/bar', '/tmp/file/'));
    $I->assertEquals(getcwd() . '/wwwroot/static_files/gif/image.gif', Path::resolve('wwwroot', 'static_files/png/', '../gif/image.gif'));
    $I->assertEquals('/home/user/dir/file', Path::resolve('dir', '..', '/home/user/dir/file'));
    $I->assertEquals(getcwd() . '/home/user/dir/file', Path::resolve('dir', '..', 'home/user/dir/file'));
    $I->expectThrowable(TypeError::class, function () {
      Path::resolve(null);
    });
  }

  public function testTheSepMethod(UnitTester $I): void
  {
    $I->assertEquals(PATH_SEPARATOR, Path::sep());
  }

  public function testTheWindowsMethod(UnitTester $I): void
  {
    $I->assertEquals('foo\\bar', Path::windows('foo/bar'));
  }
}
