<?php


class FileWatcher
{

    private $inFile;
    private $outFile;
    private $lastModified;

    public function __construct($in, $out)
    {
        $this->inFile = $in;
        $this->outFile = $out;

        $this->createFiles($in, $out);
    }


    function createFiles($inFile, $outFile)
    {
        $inHandle = fopen($inFile, 'w') or die("Couldn't create a file...");;
        fclose($inHandle);

        $outHandle = fopen($outFile, 'w') or die("Couldn't create a file...");;
        fclose($outHandle);

        echo "inFile.txt and outFile.txt created successаully\n";
    }


    public function watchFile()
    {
        if (!isset($this->lastModified)) {
            $this->lastModified = hash_file('md5', $this->inFile);
        }

        $currentState = hash_file('md5', $this->inFile);

        if ($this->lastModified !== $currentState) {
            file_put_contents($this->outFile, file_get_contents($this->inFile));
            $this->lastModified = $currentState;
            echo "File changed...\n";
        }
    }

}

$f1 = 'inFile.txt';
$f2 = 'outFile.txt';

$fileWatcher = new \FileWatcher($f1, $f2);
$sleepTime = 3; //seconds

while (true) {

    $fileWatcher->watchFile();
    sleep($sleepTime);
}



