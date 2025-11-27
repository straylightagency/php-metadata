# PHP Metadata

An helper package to build metadata tags on PHP pages.

## Installation

Require this package with composer.
```shell
composer require straylightagency/metadata
```

### Laravel without auto-discovery:

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`:

```php
Straylightagency\Metadata\Laravel\MetadataServiceProvider::class,
```

Then add this line to your facades in `config/app.php`:
```php
'Metadata' => Straylightagency\Metadata\Laravel\Metadata::class,
```

## Usage

### Without Laravel

Instantiate a new MetadataManager object and simply use methods provided by.

```php
$metadata = new \Straylightagency\Metadata\MetadataManager;

$metadata->title( 'Page Title' );
$metadata->description( 'Website description' );
$metadata->url( 'https://my-website-url.com/my_page/' );
$metadata->author( 'John Doe' );
$metadata->twitterCard( 'app' );
$metadata->twitterImage( asset( '/img/twitter_meta.jpg' ) );
$metadata->ogImage( asset( '/img/facebook_meta.jpg' ), width: 1200, height: 600, type: 'jpeg' );
$metadata->ogType( 'website' );
```

### With Laravel

The package provides by default a Facade for Laravel application. You can call methods directly using the Facade or use the alias instead.
```php
use Straylightagency\Metadata\Laravel\Metadata;

Metadata::title( 'Page title' );
```

### API documentation

Examples bellow are using Laravel Facade `Metadata`.

#### Set title

```php
Metadata::title( 'My page title', [flags: int = Metadata::ALL] );
Metadata::metaTitle( 'My page title' ); // only a simple meta title
Metadata::twitterTitle( 'My page title' ); // meta title for Twitter Card
Metadata::ogTitle( 'My page title' ); // meta title for Opengraph
```

#### Set description

```php
Metadata::description( 'My page description', [flags: int = Metadata::ALL] );
Metadata::metaDescription( 'My page description' ); // simply a meta description
Metadata::twitterDescription( 'My page description' ); // meta description for Twitter Card
Metadata::ogDescription( 'My page description' ); // meta description for Opengraph
```

#### Set images

You can set many images

```php
// Meta image for both Twitter Card and Opengraph
Metadata::image(
    url: 'https://my-website-url.com/metacard.jpg', 
    [secure_url: ?string = null], 
    [type: ?string = null], 
    [width: ?int = null], 
    [height: ?int = null], 
    [alt: ?string = null], 
    [flags: int = Metadata::ALL] 
);

// Twitter Card meta image
Metadata::twitterImage(
    url: 'https://my-website-url.com/metacard.jpg', [alt: ?string = null]
);

// Opengraph meta image
Metadata::ogImage(
    url: 'https://my-website-url.com/metacard.jpg', 
    [secure_url: ?string = null], 
    [type: ?string = null], 
    [width: ?int = null], 
    [height: ?int = null], 
    [alt: ?string = null]
);
```

#### Set videos for Opengraph

```php
Metadata::ogVideo(
    url: 'https://my-website-url.com/video.mp4', 
    [secure_url: ?string = null], 
    [type: ?string = null], 
    [width: ?string = null], 
    [height: ?string = null]
);
```

#### Set audios for Opengraph

```php
Metadata::ogAudio(
    url: 'https://my-website-url.com/audio.mp3', 
    [secure_url: ?string = null], 
    [type: ?string = null]
);
```

#### Set url

```php
Metadata::url( 'https://my-website-url.com/', [flags: int = Metadata::ALL] ); // meta URL for both Twitter and Opengraph
Metadata::twitterUrl( 'https://my-website-url.com/' ); // meta URL for Twitter Card
Metadata::ogUrl( 'https://my-website-url.com/' ); // meta URL for Opengraph
```

#### Set author

```php
Metadata::author( 'John Doe' );
```

#### Set Opengraph Type

```php
Metadata::ogType( 'website', [options: array = []]);
```

#### Set Twitter Card Type

```php
Metadata::twitterCard( 'summary' );
```

#### Set Twitter Site ID

```php
Metadata::twitterSite( '@my_website_twitter_id' );
```

#### Set Twitter Creator ID

```php
Metadata::twitterSite( '@creator_id' );
```

#### Set Facebook App ID

```php
Metadata::fbAppId( 'facebook_id' );
```

#### Set Facebook Admins ID

```php
Metadata::fbAdmins( 'facebook_admins' );
```

#### Set Opengraph Site Name

```php
Metadata::ogSiteName( 'My website name' );
```

#### Set Opengraph Locale

```php
Metadata::ogLocale( 'en_US' );
Metadata::ogLocaleAlternate( 'fr_FR', 'nl_BE', 'de_DE' ); // set alternates locales available for this page

// or you can combine both using second parameter of ogLocale : 
Metadata::ogLocale( 'en_US', 'fr_FR', 'nl_BE', 'de_DE' );
```

#### Set Google Site Verification ID

```php
Metadata::googleSiteVerification( 'google_site_verification_id_from_google_cloud_console' );
```

#### Set Google Bot and Google Bot News

```php
Metadata::googleBot( 'notranslate' );
Metadata::googleBotNews( 'nosnippet' );
```

#### Set Robots meta

```php
Metadata::robots( 'nofollow', 'noindex' );
Metadata::robots( [ 'nofollow', 'noindex' ] ); // works too
```

#### Disable Pinterest Rich Pin

```php
Metadata::disablePinterestRichPin([value: bool = true]);
```

#### Set website content rating

```php
Metadata::rating( 'adult' );
```

#### Set a simple meta value

```php
Metadata::meta( 'name', 'some meta value' );
```

#### Set a Twitter Card value

```php
Metadata::twitter( 'name', 'some Twitter Card value', [prefix: MetadataManager::TWITTER_PREFIX], [uniq: bool = false]);
```

#### Set an Opengraph value

```php
Metadata::opengraph( 'name', 'some Opengraph value', [prefix: MetadataManager::OPENGRAPH_PREFIX], [uniq: bool = false]);

// or use the alias method :
Metadata::og( 'name', 'some Opengraph value', [prefix: MetadataManager::OPENGRAPH_PREFIX], [uniq: bool = false]);
```

#### Generate the HTML tags

```php
$html = Metadata::toHtml( [flags: bool = MetadataManager::ALL] );
```

#### Print HTML

Simply call the print method will echo the content returned by toHtml() :

```php
Metadata::print( [flags: bool = MetadataManager::ALL] );

// or use the __toString magic method :
$metadata = new \Straylightagency\Metadata\MetadataManager;
$metadata->title( 'Page Title' );

echo $metadata; // print the meta title tag
```

### Requirement

PHP 8.3 or above

## See also

- [Google Documentation](https://developers.google.com/search/docs/crawling-indexing/special-tags)
- [Open Graph Documentation](https://ogp.me/)
- [Facebook OG Documentation](https://developers.facebook.com/docs/sharing/webmasters/)
- [Twitter Cards Documentation](https://developer.x.com/en/docs/x-for-websites/cards/guides/getting-started)

## Credits

- [Anthony Pauwels](https://github.com/anthonypauwels)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). 