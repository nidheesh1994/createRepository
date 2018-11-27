<?php

class createRepository
{
    public $repository;

    public function __construct($arg)
    {
        $this->repository = ucfirst($arg);
    }

    public function create()
    {
        $dir = "./app/Repositories/" . $this->repository;
        if (!file_exists($dir) && !is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $interfaceDir = $dir . "/" . $this->repository . "Interface.php";
        $interfaceContent = "<?php
namespace App\Repositories\\" . $this->repository . ";

interface " . $this->repository . "Interface
{

}
";
        $repositoryDir = $dir . "/" . $this->repository . "Repository.php";
        $repositoryContent = "<?php
namespace App\Repositories\\" . $this->repository . ";

class " . $this->repository . "Repository implements " . $this->repository . "Interface
{

}
";
        try {
            if (file_put_contents($interfaceDir, $interfaceContent) && file_put_contents($repositoryDir, $repositoryContent)) {
//                $this->app->bind(CrmInterface::class,CrmRepository::class);
//                use App\Repositories\Aller\AllerInterface;
                $use1 = 'use App\Repositories\\'.$this->repository.'\\'.$this->repository.'Interface;';
                $use2 = 'use App\Repositories\\'.$this->repository.'\\'.$this->repository.'Repository;';
                $data = '        $this->app->bind('.$this->repository.'Interface::class,'.$this->repository.'Repository::class);';
                $filename = "app/Providers/AppServiceProvider.php";
                $file = fopen($filename,"a+");
                $startFlag = false;
                $braces = 0;
                $i = 0;
                $lines = file($filename, FILE_IGNORE_NEW_LINES);
                $length = count($lines);

                while ($i<$length){
                    if($i==4){
                        $first_array = array_slice($lines,0, $i);
                        array_push($first_array, $use1);
                        array_push($first_array,$use2);
                        $remaing_array = array_slice($lines, $i);
                        $lines = array_merge($first_array,$remaing_array);
//                        print_r($lines);
                        $length = count($lines);
                    }
                    if(strpos($lines[$i],'public function register()')){
                        $startFlag = true;
                    }
                    if($startFlag){
                        if(strpos($lines[$i],'{')){
                            $braces++;
//                            echo $braces;
                        }
                    }
//                    sleep(1);
                    if($startFlag && strpos($lines[$i],'}') && $braces==1){
                        $first_array = array_slice($lines,0, $i);
                        array_push($first_array, $data);
                        $remaing_array = array_slice($lines, $i);
                        $lines = array_merge($first_array,$remaing_array);
                        print_r($lines);
                        break;
                    }
                    $i++;
                }
                print_r($lines);
                file_put_contents( $filename , implode( "\n", $lines ) );
//                foreach ($lines as $line){
//                    sleep(1);
//                    echo $line.'
//                    ';
//                }
//                file_put_contents( $filename , implode( "\n", $lines ) );
//                while(!feof($file)){
//                    $current = ftell($file);
//                    if($i==4){
//                        fseek($file, $current, SEEK_SET);
//                        fwrite($file,$use1);
//                        fwrite($file,$use2);
//                    }
//                    $line = fgets($file);
//                    sleep(1);
//                    echo $line;
//                    if(strpos($line,'public function register()')){
//                        $startFlag = true;
//                        echo 'Got';
//                    }
//                    if($startFlag){
//                        if(strpos($line,'{')){
//                            $braces++;
//                            echo $braces;
//                        }
//                    }
//                    if($startFlag && strpos($line,'}') && $braces==1){
//                        fseek($file, $current, SEEK_SET);
//                        fwrite($file,$data);
//                        break;
//                    }
//                    $i++;
//                }
//                fclose($file);
                echo 'Repository successfully created
';
            }
        } catch (Exception $exception) {
            echo $exception;
        }


    }
}

$repo = new createRepository($argv[1]);

$repo->create();