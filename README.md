Statika - Static File Manager
=============================

Statika is a file manager for the static files of your projects. It can combine and compress your CSS/JS files. All you have to do is to set up a configuration file where you define your filesets. You can find a config template in the ```conf/``` folder of this project.

Usage
-----

To compress a defined config:
```./statika compress /path/to/config```

To validate a defined config:
```./statika validate /path/to/config```

Versions
--------

You can specify the output name for each fileset. For now, there are 2 ways of versioning. Each time you compress a config, Statika will check if there is a previous minified version and automatically increase it. (e.g. _0001 -> 0002_ )
* Numbers ( _test.min.0001.js_ )
* MD5 ( _test.min.098f6bcd4621d373cade4e832627b4f6.js_ )

