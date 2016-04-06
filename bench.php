<?php

date_default_timezone_set('UTC');

/**
 * Super Simple PHP Benchmark Performance Script
 * Based upon the PHP benchmark performance script by Alessandro Torrisi available http://www.php-benchmark-script.com/
 * as such both myself and Alessandro are listed as authors.
 *
 * @author Simon Dann <simon.dann@gmail.com>
 * @author Alessandro Torrisi <info@code24.nl>
 * @version 1.2
 * @licence Creative Commons CC BY 4.0 license
 * @date April 6th, 2016
 */
class Benchmark
{
    /**
     * Closure to benchmark
     *
     * @var Closure
     */
    private $closure;

    /**
     * Name of benchmark
     *
     * @var string
     */
    private $name;

    /**
     * List of timings
     *
     * @var array
     */
    private $timings = [];

    /**
     * The current timing batch number, is incrememnted by start on each iteration
     * @var int
     */
    private $batchNumber = 0;

    public function __construct($name, Closure $closure)
    {
        $this->name = $name;
        $this->closure = $closure;
    }

    public function start()
    {
        $time_start = microtime(true);
        call_user_func_array($this->closure, []);
        $this->timings[++$this->batchNumber] = (microtime(true) - $time_start);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTimings()
    {
        return $this->timings;
    }
}

$tests = [
    new Benchmark('Math Test', function ($iterations = 150000) {
        $functions = [
            "abs",
            "acos",
            "asin",
            "atan",
            "bindec",
            "floor",
            "exp",
            "sin",
            "tan",
            "pi",
            "is_finite",
            "is_nan",
            "sqrt"
        ];
        foreach ($functions as $key => $function) {
            if (!function_exists($function)) {
                unset($functions[$key]);
            }
        }
        unset($function, $key);

        for ($i = 0; $i < $iterations; $i++) {
            foreach ($functions as $function) {
                $r = call_user_func_array($function, array($i));
            }
        }
    }),
    new Benchmark('String Test', function ($iterations = 150000) {
        $functions = [
            "addslashes",
            "chunk_split",
            "metaphone",
            "strip_tags",
            "md5",
            "sha1",
            "strtoupper",
            "strtolower",
            "strrev",
            "strlen",
            "soundex",
            "ord"
        ];
        foreach ($functions as $key => $function) {
            if (!function_exists($function)) {
                unset($functions[$key]);
            }
        }
        unset($function, $key);

        $string = "the quick brown fox jumps over the lazy dog";

        for ($i = 0; $i < $iterations; $i++) {
            foreach ($functions as $function) {
                $r = call_user_func_array($function, array($string));
            }
        }
    }),
    new Benchmark('Loop Test', function ($iterations = 19000000) {
        for ($i = 0; $i < $iterations; ++$i) {
            ;
        }
        $i = 0;
        while ($i < $iterations) {
            ++$i;
        }
    }),
    new Benchmark('IfElse Test', function ($iterations = 9000000) {
        for ($i = 0; $i < $iterations; $i++) {
            if ($i == -1) {
            } elseif ($i == -2) {
            } else {
                if ($i == -3) {
                }
            }
        }

    })
];

/**
 * Cli Line Function
 * @param null $string
 * @param string $lineEnding
 * @param int $padding
 * @param int $lineLength
 */
function cli_line($string = null, $padding = STR_PAD_BOTH, $lineEnding = "\n", $lineLength = 70)
{
    $line = str_pad("-", $lineLength, "-");

    if (is_null($string)) {
        echo $line;
    } else {
        echo "|" . str_pad($string, ($lineLength - 2), " ", $padding) . "|";
    }

    echo $lineEnding;
}

//
// Welcome header
//

cli_line();
cli_line("PHP Benchmark Script");
cli_line(date('Y-m-d H:i:s P'));
cli_line("PHP Version: " . PHP_VERSION . ' // OS Version: ' . PHP_OS);
cli_line();

//
// Run the benchmarks
//

/**@var Benchmark $test */
for ($i = 1; $i <= 3; $i++) {
    foreach ($tests as $test) {
        cli_line(" Executing test [" . $test->getName() . " run #" . $i . "]", STR_PAD_RIGHT, "\r");
        $test->start();
    }
}

//
// Output the results
//

cli_line("Results");
$totalTime = 0;

foreach ($tests as $test) {
    cli_line();
    $timings = $test->getTimings();
    cli_line(" " . $test->getName() . ":", STR_PAD_RIGHT);
    cli_line();

    $min = round(min($timings), 3) . " sec";
    $max = round(max($timings), 3) . " sec";
    $avg = round((array_sum($timings) / count($timings)), 3) . " sec";

    cli_line(str_pad('Min', 22, " ", STR_PAD_BOTH) . '|' . str_pad('Max', 22, " ", STR_PAD_BOTH) . '|' . str_pad('Avg',
            22, " ", STR_PAD_BOTH), STR_PAD_RIGHT);
    cli_line(str_pad($min, 22, " ", STR_PAD_BOTH) . '|' . str_pad($max, 22, " ", STR_PAD_BOTH) . '|' . str_pad($avg, 22,
            " ", STR_PAD_BOTH), STR_PAD_RIGHT);

    $totalTime += array_sum($timings);
}

cli_line();
cli_line(" Total time taken: " . round($totalTime, 3) . " sec", STR_PAD_RIGHT);
cli_line(" Peak Memory usage: " . round(memory_get_peak_usage() / 1024, 2) . "MB", STR_PAD_RIGHT);
cli_line();
