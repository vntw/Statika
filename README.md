## Statika... what?
Statika is a file manager for the static files of your projects. It uses 3rd-party compressors/minifiers like ```YUI Compressor/Google Closure Compiler``` to  combine and compress your CSS/JS files, reduce filesize and increase versions automatically.

## Project Config
The config file describes various things like the compressor(s) you wish to use, versioning or the filesets. You can find a config template in the ```conf/``` folder of this project.

## Available Compressors
Currently there are two compressors implemented:
* Google Closure Compiler (```closure```)
* YUI Compressor (```yui```)

More are planned, including webservices like UglifyJS.

## Getting Started
First of all you have to install the project dependencies via [Composer](http://getcomposer.org).

If that´s completed, make sure that the file paths for the binary compressors/minifiers in the ```src/config.php``` are correct.

### There are two ways using Statika:
* Run from source
* Compile the source (create a phar archive) - if you´d like to use Statika globally

#### Run from source
To run Statika from source, use the following command:
```
./bin/statika <command>
```

#### Compile the source
To compile the source, use the following command:
```
./bin/compile
```
If you´d like to use Statika globally, move the compiled file (```statika.phar```) to your ```bin``` dir, e.g. ```/usr/local/bin/statika```, and set the proper file modes using:
```
sudo mv bin/statika.phar /usr/local/bin/statika
sudo chmod +x /usr/local/bin/statika
```

## Usage
To compress a defined config:
```
$ statika compress /path/to/config.json
```

To validate a defined config:
```
$ statika validate /path/to/config.json
```

## Versions
You can specify the output name for each fileset. For now, there are 2 ways of versioning. Each time you compress a config, Statika will check if there is a previous minified version and automatically increase it. (e.g. _0001 -> 0002_ )
* Numbers ```{version|nr}``` (e.g. ```test.min.0001.js```)
* MD5 ```{version|md5}``` (e.g. ```test.min.098f6bcd4621d373cade4e832627b4f6.js```)
