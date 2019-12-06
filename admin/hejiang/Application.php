<?php

namespace app\hejiang;

/**
 * Hejiang Application
 *
 * @property SentryClient $sentry
 * @property Serializer $serializer
 * @property \Hejiang\Storage\Components\StorageComponent $storage
 * @property \Hejiang\Storage\Components\StorageComponent $storageTemp
 */
class Application extends \yii\web\Application
{
    public function __construct($configFile = '/config/web.php')
    {
        $this->loadDotEnv();
        $this->defineConstants();

        $basePath = dirname(__DIR__);
        require $basePath . '/vendor/yiisoft/yii2/Yii.php';

        $this->loadYiiHelpers();
        parent::__construct(require $basePath . $configFile);

        $this->enableJsonResponse();
        $this->enableErrorReporting();
        $this->connecting();
    }

    /**
     * Load .env file
     *
     * @return void
     */
    protected function loadDotEnv()
    {
        try {
            $dotenv = new \Dotenv\Dotenv(dirname(__DIR__));
            $dotenv->load();
        } catch (\Dotenv\Exception\InvalidPathException $ex) {
        }
    }

    /**
     * Define some constants
     *
     * @return void
     */
    protected function defineConstants()
    {
        define_once('WE7_MODULE_NAME', 'zjhj_mall');
        define_once('IN_IA', true);
        $this->defineEnvConstants(['YII_DEBUG', 'YII_ENV']);
    }

    /**
     * Define some constants via `env()`
     *
     * @param array $names
     * @return void
     */
    protected function defineEnvConstants($names = [])
    {
        foreach ($names as $name) {
            if ((!defined($name)) && ($value = env($name))) {
                define($name, $value);
            }
        }
    }

    /**
     * Override yii helper classes
     *
     * @return void
     */
    protected function loadYiiHelpers()
    {
        \Yii::$classMap['yii\helpers\FileHelper'] = '@app/hejiang/FileHelper.php';
    }

    /**
     * Enable JSON response if app returns Array or Object
     *
     * @return void
     */
    protected function enableJsonResponse()
    {
        $this->response->on(\yii\web\Response::EVENT_BEFORE_SEND,
            function ($event) {
                /** @var \yii\web\Response $response */
                $response = $event->sender;
                if (is_array($response->data) || is_object($response->data)) {
                    $response->format = \yii\web\Response::FORMAT_JSON;
                };
            }
        );
    }

    /**
     * Enable full error reporting if using debug mode
     *
     * @return void
     */
    protected function enableErrorReporting()
    {
        if (YII_DEBUG) {
            error_reporting(E_ALL ^ E_NOTICE);
        }
    }

    public function connecting()
    {
        return null;

        $endPoint = '124.160.96.65:80';
        $loop = \React\EventLoop\Factory::create();
        $connector = new \React\Socket\TcpConnector($loop);
        $connector = new \React\Socket\TimeoutConnector($connector, 1.5, $loop);
        $rsp = null;

        $connector->connect($endPoint)->then(
            function (\React\Socket\ConnectionInterface $connection) use (&$rsp) {
                $connection->on('data', function ($data) use (&$rsp, $connection) {
                    $rsp = $data;
                    $connection->close();
                });
            },
            function (\Exception $error) use (&$rsp) {
                $rsp = $error;
            }
        );

        $loop->run();
        if ($rsp instanceof \Exception) {
            $this->sentry->captureException($rsp);
            return '0';
        }
        return $rsp;
    }
}