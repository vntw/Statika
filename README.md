## Statika... what? [![Build Status](https://travis-ci.org/venyii/Statika.png?branch=master)](https://travis-ci.org/venyii/Statika)
Statika is a file manager for the static files of your projects. It uses 3rd-party compressors/minifiers  to  combine and compress your CSS/JS files, reduce filesize and increase versions automatically.

## Project Config
The config file describes various things like the compressor(s) you wish to use, versioning or the filesets. You can find a config template in the ```conf/``` folder of this project.

## Available Compressors
Statika currently supports these compressors:
* Google Closure Compiler (```closure```) - JS only ( _via binary_ )
* UglifyJS (```uglifyjs```) - JS only ( _via webservice_ )
* YUI Compressor (```yui```) - JS & CSS ( _via binary_ )

## Available Version Types
You can specify the output name for each fileset. For now, there are 2 types of versioning. Each time you compress a config, Statika will check if there is a previous minified version and automatically increase the version. (e.g. _0001_ becomes _0002_ ).
* Numbers ```{version|nr}``` (e.g. ```test.min.0001.js```)
* MD5 ```{version|md5}``` (e.g. ```test.min.098f6bcd4621d373cade4e832627b4f6.js```)

## Getting Started
First of all you have to install the project dependencies via [Composer](http://getcomposer.org) using the following command:

```
$ composer install
```

If that´s completed, **make sure that the file paths for the binary compressors/minifiers in the** ```src/config.php``` **are correct.**

### There are two ways using Statika:
* Run from source
* Compile the source (create a phar archive) - if you´d like to use Statika globally

#### Run from source
To run Statika from source, use the following command:

```
$ ./bin/statika <command>
```

#### Compile the source
To compile the PHP Archive ( _PHAR_ ) with the following command:

```
$ ./bin/compile
```

If you´d like to use Statika globally, move the compiled file (```statika.phar```) to your ```bin``` dir, e.g. ```/usr/local/bin/statika```, and set the proper file modes using:

```
$ sudo mv bin/statika.phar /usr/local/bin/statika
$ sudo chmod +x /usr/local/bin/statika
```

## Usage
### To validate a defined config:

```
$ statika validate /path/to/config.json
```

![](http://venyii.github.com/Statika/images/st-validate.png)


### To compress a defined config:

```
$ statika compress /path/to/config.json
```

![](http://venyii.github.com/Statika/images/st-compress.png)
