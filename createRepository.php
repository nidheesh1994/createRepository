<?php

class createRepository
{
    public $repository;

    public function __construct($arg)
    {
        $this->repository = $arg;
    }

    public function create()
    {
        $dir = "./app/Repositories/" . $this->repository;
        if (!file_exists($dir) && !is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $interfaceDir = $dir . "/" . $this->repository . "Interface.php";
        $interfaceContent = "<?php
namespace " . $this->repository . "\Repositories\\" . $this->repository . ";

interface " . $this->repository . "Interface
{

}
";
        $repositoryDir = $dir . "/" . $this->repository . "Repository.php";
        $repositoryContent = "<?php
namespace " . $this->repository . "\Repositories\\" . $this->repository . ";

class " . $this->repository . "Repository implements " . $this->repository . "Interface
{

}
";
        try {
            if (file_put_contents($interfaceDir, $interfaceContent) && file_put_contents($repositoryDir, $repositoryContent)) {
                echo 'Repository successfully created
';
            }
        } catch (Exception $exception){
            echo $exception;
        }


    }
}

$repo = new createRepository($argv[1]);

$repo->create();