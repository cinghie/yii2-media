# Yii2 Media
Yii2 Media to manage files on Yii2 site like Wordpress Media Management

Installation
-----------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require cinghie/yii2-media "*"
```

or add

```
"cinghie/yii2-media": "*"
```

Configuration
-----------------

### 1. Update yii2-media database schema

Make sure that you have properly configured `db` application component
and run the following command:
```
$ php yii migrate/up --migrationPath=@vendor/cinghie/yii2-media/migrations
```

### 2. Set configuration file

Set on your configuration file:

```
'modules' => [ 

	// Yii2 Media
	'media' => [
		'class' => 'cinghie\media\Media',
		'mediaNameType' = 'casual'; // casual or original
		'mediaPath' => '@frontend/web/media/',  
		'mediaThumbsPath' => '@frontend/web/media/thumbs/',  
		'mediaURL' => $params['media']['mediaURL'],  
		'mediaThumbsURL' => $params['media']['mediaThumbsURL'],  
		'mediaRoles' => ['admin'],
		'mediaType' = ['jpg','jpeg','gif','png','csv','xls','xlx','pdf','txt','doc','docs','mp3','mp4'];  
		'tinyPngAPIKey' => 'YOUR_TINIFY_API_KEY',
		'showTinify' => false,
		'showTitles' => false
	],
	
]	
```

### 2. Set frontend filter

To disable media management on frontend, set on config: 

```
'modules' => [ 

	// Yii2 Media
	'media' => [
		'class' => 'cinghie\media\Media',
		'as frontend' => 'cinghie\media\filters\FrontendFilter',
	],
	
]	
```

### 3. Install FFmpeg

On Linux

```
apt-get install ffmpeg

whereis ffmpeg
```
