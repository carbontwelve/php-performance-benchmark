# PHP Performance Benchmark Script

A super simple PHP script for testing PHP performance on various platforms, run it via the command `php bench.php`; example output:

```
C:\php bench.php
----------------------------------------------------------------------
|                        PHP Benchmark Script                        |
|                     2016-04-06 16:30:21 +02:00                     |
|              PHP Version: 5.6.8 // OS Version: WINNT               |
----------------------------------------------------------------------
|                              Results                               |
----------------------------------------------------------------------
| Math Test:                                                         |
----------------------------------------------------------------------
|         Min          |         Max          |         Avg          |
|      52.214 sec      |      52.474 sec      |      52.386 sec      |
----------------------------------------------------------------------
| String Test:                                                       |
----------------------------------------------------------------------
|         Min          |         Max          |         Avg          |
|      50.245 sec      |      50.56 sec       |      50.38 sec       |
----------------------------------------------------------------------
| Loop Test:                                                         |
----------------------------------------------------------------------
|         Min          |         Max          |         Avg          |
|      5.538 sec       |      5.569 sec       |      5.558 sec       |
----------------------------------------------------------------------
| IfElse Test:                                                       |
----------------------------------------------------------------------
|         Min          |         Max          |         Avg          |
|      3.893 sec       |      3.908 sec       |      3.899 sec       |
----------------------------------------------------------------------
| Total time taken: 336.667 sec                                      |
| Peak Memory usage: 279.02MB                                        |
----------------------------------------------------------------------

```

I have used this benchmark script to test a few platforms, by results can be found in [this gist here](https://gist.github.com/carbontwelve/94cbb6615070120a8cf236a5e9d7540a).


If you have any additional PHP system performance based tests that you would like to add to the mix, feel free to fork and send a PR.

## Todo

I would like to add disk i/o based performance testing to be able to see how the filesystem performs as that is one of the biggest bottlenecks I have found on certain cloud platforms.

## Not invented here
This PHP benchmark script was heaviliy influenced by one written by Alessandro Torrisi available [here](http://www.php-benchmark-script.com/).