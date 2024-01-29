<?php
    namespace project\core;

    spl_autoload_register(function() {
        require __DIR__ . "/../control/" . Router::$file . ".php";
    });

    final class Router {
        public static string $file;
        public static string $controller;
        public string $method;
        public array $args;
        public bool $active_user;

        public function __construct() {
            $this->parseRequest();
        }

        public function action(): void {
            try {
                if($this->args)
                    (new Router::$controller)->{$this->method}($this->args);
                else
                    (new Router::$controller)->{$this->method}();
            }
            catch(Throwable) {
                header("Location: ../errors/view");
            }
        }

        public function parseRequest(): void {
            $request = explode('/', $_SERVER['REQUEST_URI']);
            $controllerPart;
            $methodPart;
            $argsPart = [];

            $this->defineUser();
            $this->setArgs($request, $argsPart);
            $this->setController($request, $controllerPart);
            $this->setMethod($request, $methodPart);
            $this->setProperties($controllerPart, $methodPart, $argsPart);
            $this->setFile();
        }





        private function setFile(): void {
            $filename_array = explode('\\', Router::$controller);
            Router::$file = end($filename_array);
        }

        private function setController(array $request, &$controllerPart): void {  // определение контроллера
            if(isset($request[1]))
                if($request[1])
                    $controllerPart = 'project\control\\' . ucfirst($request[1]);
                else 
                    $this->setHeader();
            else 
                $this->setHeader();
        }

        private function setMethod(array $request, &$methodPart): void {  // определение метода 
            if(isset($request[2]))
                if($request[2])
                    $methodPart = $request[2];
                else 
                    $this->setHeader();
            else 
                $this->setHeader();
        }

        private function setArgs(array &$request, &$argsPart): void {  // определение аргументов 
            if($_SERVER['REQUEST_METHOD'] == 'GET') {
                if($_GET) {
                    $counter = 0;
                    foreach($request as $key => $value) {
                        if(str_contains($value, '?')) {
                            $clearArg = explode('?', $request[$counter])[0];
                            $request[$counter] = $clearArg;
                            break;
                        }
                        else 
                            $counter++;
                    }
                    goto collectArgs;
                }
                else goto collectArgs;
            }
            else goto collectArgs;
            collectArgs:
                for($i = 3; $i < sizeof($request); $i++) 
                    $argsPart[] = $request[$i];
        }

        private function setProperties(         // инициализация свойств
                string &$controllerPart = '', 
                string &$methodPart = '', 
                array &$argsPart = []
            ): void {

            Router::$controller = $controllerPart;
            $this->method = $methodPart;
            $this->args = $argsPart;
        }

        private function setHeader(): void {
            if($this->active_user) {
                header("Location: ../calendar/view");
            }
            else 
                header("Location: ../log/view");
        }

        private function defineUser(): void {
            if(false) {
                
            }
            else 
                $this->active_user = false;
        }
    }