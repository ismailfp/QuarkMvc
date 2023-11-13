<?php
namespace QuarkMvc\app;

//error_reporting(0);
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class Quark
{
    public Routes $routes;
    public Request $request;
    public static Environment $render;
    public static bool $isDebug;
    public static string $SUPER_DIR;
    public function __construct($isDebug=false)
    {
        self::$isDebug = $isDebug;
        $this->nativeErrorManager();
        self::$SUPER_DIR = dirname(__DIR__);
        $this->routes = new Routes();
        $this->request = new Request();
        $loader = new FilesystemLoader(self::$SUPER_DIR . '/views');
        self::$render = new Environment($loader, [
            'cache' => self::$SUPER_DIR . '/views/cache',
            'debug' => true
        ]);

    }
    public function run(): void
    {
        $this->routes->executeRoute();
    }

    private function nativeErrorManager(): void
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            Error::renderNativeError($errno, $errstr, $errfile, $errline);
        });
        set_exception_handler(function ($e) {
            Error::renderError("Exception",$e->getMessage());
        });

    }





}