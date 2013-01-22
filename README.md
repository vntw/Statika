## Statika... what?
Statika is a file manager for the static files of your projects. It can combine and compress your CSS/JS files and increase versions automatically. All you have to do is to set up a configuration file for each of your projects where you´d like to use Statika.

## Project Config
The config file describes various things like the used compressor, versioning or the filesets. You can find a config template in the ```conf/``` folder of this project.

## Available Compressors
Currently there are two compressors implemented:
* Google Closure Compiler (```closure```)
* YUI Compressor (```yui```)

More are planned, including webservices like UglifyJS.

## Preparation
There are two ways using Statika:
* Run from source
* Compile the source (create a phar archive) - if you´d like to use Statika globally

### Run from source
To run Statika from source, use the following command:
```
./bin/statika <command>
```

### Compile the source
To compile the source, use the following command:
```
./bin/compile
```
If you´d like to use Statika globally, move the compiled file (_statika.phar_) to your ```bin``` dir, e.g. ```/usr/local/bin/statika```, and set the proper file modes using:
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
* Numbers (```test.min.0001.js```)
* MD5 (```test.min.098f6bcd4621d373cade4e832627b4f6.js```)
