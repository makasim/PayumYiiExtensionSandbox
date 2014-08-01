<?php

Yii::setPathOfAlias('Payum', dirname(__FILE__).'/../extensions/PayumYiiExtension/vendor');
Yii::setPathOfAlias('Payum.YiiExtension', Yii::getPathOfAlias('Payum').'/payum/payum-yii-extension/src/Payum/YiiExtension');
Yii::import('Payum.autoload', true);

use Buzz\Client\Curl;
use Payum\Core\Storage\FilesystemStorage;
use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Payum\Paypal\ExpressCheckout\Nvp\PaymentFactory as PaypalEcPaymentFactory;

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

        'payum' => array(
            'class' => '\Payum\YiiExtension\PayumComponent',
            'tokenStorage' => new FilesystemStorage(__DIR__.'/../data', 'PaymentSecurityToken', 'hash'),
            'payments' => array(
//                'paypal_ec' => PaypalEcPaymentFactory::create(new Api(new Curl(), array(
//                    'username' => 'REPLACE WITH YOURS',
//                    'password' => 'REPLACE WITH YOURS',
//                    'signature' => 'REPLACE WITH YOURS',
//                    'sandbox' => true
//                )))
                'paypal_ec' => PaypalEcPaymentFactory::create(new Api(new Curl(), array(
                    'username' => 'testrj_1312968849_biz_api1.remixjobs.com',
                    'password' => '1312968888',
                    'signature' => 'Azgw.f7NYjBAlDQEpbI1D06D4ACAAXfoVSV7k4JUuGAPRHzhDbQR2r90',
                    'sandbox' => true
                )))
            ),
            'storages' => array(
                'PaymentDetails' => new FilesystemStorage(__DIR__.'/../data', 'PaymentDetails', 'id'),
            )
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),

    'controllerMap'=>array(
        'payment'=>array(
            'class'=>'Payum\YiiExtension\PaymentController',
        ),
    ),
);