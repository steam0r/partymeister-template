<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
//use Orchestra\Testbench\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\WebDriverDimension;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

//    protected static $baseServeHost = '127.0.0.1';
//    protected static $baseServePort = 9000;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     *
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--no-sandbox',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }

//    protected function captureFailuresFor($browsers)
//    {
//        $browsers->each(function (Browser $browser, $key) {
//            $body = $browser->driver->findElement(WebDriverBy::tagName('body'));
//            if (!empty($body)) {
//                $currentSize = $body->getSize();
//                $size = new WebDriverDimension($currentSize->getWidth(), $currentSize->getHeight());
//                $browser->driver->manage()->window()->setSize($size);
//            }
//            $name = str_replace('\\', '_', get_class($this)).'_'.$this->getName(false);
//
//            $browser->screenshot('failure-'.$name.'-'.$key);
//        });
//    }
}
