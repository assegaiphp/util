<div align="center" style="padding-bottom: 48px">
    <a href="https://assegaiphp.com/" target="blank"><img src="https://assegaiphp.com/images/logos/logo-cropped.png" width="200" alt="Assegai Logo"></a>
</div>

<p style="text-align: center">A progressive <a href="https://php.net">PHP</a> framework for building effecient and scalable server-side applications.</p>

## Description 
The Assegai Util package is a PHP package that provides a collection of utility classes to simplify common tasks and enhance application development. It includes various utility classes that can be used to perform common tasks, such as working with arrays, strings, dates, and more.

## Installation
The recommended way to install assegaiphp/util is through Composer. Run the following command in your terminal:

```bash
composer require assegaiphp/util
```

## Usage
Once you have installed assegaiphp/util, you can start using its utility classes by simply importing them into your PHP code. For example, to use the ArrayUtil class, you would add the following line at the top of your PHP file:

```php
use Assegai\Util\ArrayUtil;

$numericArray = [1, 2, 3, 4, 5];

if (ArrayUtil::contains($numericArray, 3)) {
    echo 'The array contains the value 3.';
} else {
    echo 'The array does not contain the value 3.';
}

```

You can then call any of the static methods of the ArrayUtil class to perform various array-related tasks.

## Contributing
Contributions are welcome! If you find a bug or would like to request a new feature, please open an issue on the GitHub repository. If you would like to contribute code, please fork the repository and submit a pull request.

## License
assegaiphp/util is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.