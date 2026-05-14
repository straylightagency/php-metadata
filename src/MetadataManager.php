<?php
namespace Straylightagency\Metadata;

/**
 * Class MetadataManager
 *
 * @package Straylightagency\Metadata
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
class MetadataManager
{
    /** @var int All meta tags */
    const int ALL = 1;

    /** @var int Only common meta tags */
    const int META = 2;

    /** @var int Only Twitter meta tags */
    const int TWITTER = 4;

    /** @var int Alias to TWITTER const */
    const int X = 4;

    /** @var int Only Opengraph meta tags */
    const int OPENGRAPH = 8;

    /** @var int Alias to OPENGRAPH const */
    const int OG = 8;

    /** @var string Prefix for Twitter tags */
    const string TWITTER_PREFIX = 'twitter:';

    /** @var string Alias to TWITTER_PREFIX const */
    const string X_PREFIX = 'twitter:';

    /** @var string Prefix for Opengraph tags */
    const string OPENGRAPH_PREFIX = 'og:';

    /** @var string Alias to OPENGRAPH_PREFIX const */
    const string OG_PREFIX = 'og:';

    /** @var string Prefix for Facebook tags */
    const string FACEBOOK_PREFIX = 'fb:';

    /** @var string Alias to FACEBOOK_PREFIX const */
    const string FB_PREFIX = 'fb:';

    /** @var array Default meta tags, commonly used by search engine */
    protected array $meta = [];

    /** @var array Twitter meta tags, used only by Twitter */
    protected array $twitter = [];

    /** @var array Opengraph meta tags, used by Facebook, Instagram, Whatsapp, Discord, etc */
    protected array $opengraph = [];

    /**
     * Set the page title in meta tags
     *
     * @param string $title
     * @param int $flags
     * @return $this
     */
    public function title(string $title, int $flags = self::ALL): MetadataManager
    {
        if ( $this->ifMeta( $flags ) ) {
            $this->metaTitle( $title );
        }

        if ( $this->ifTwitter( $flags ) ) {
            $this->twitterTitle( $title );
        }

        if ( $this->ifOpengraph( $flags ) ) {
            $this->ogTitle( $title );
        }

        return $this;
    }

    /**
     * Set the page title in meta tags
     *
     * @param string $title
     * @return $this
     */
    public function metaTitle(string $title): MetadataManager
    {
        return $this->meta( 'title', $title, true );
    }

    /**
     * Set the page title in meta tags for Twitter Card
     *
     * @param string $title
     * @return $this
     */
    public function twitterTitle(string $title): MetadataManager
    {
        return $this->twitter( 'title', $title, self::TWITTER_PREFIX, true );
    }

    /**
     * Set the page title in meta tags for Opengraph
     *
     * @param string $title
     * @return $this
     */
    public function ogTitle(string $title): MetadataManager
    {
        return $this->opengraph( 'title', $title, self::OPENGRAPH_PREFIX, true );
    }

    /**
     * Set the page description in meta tags
     *
     * @param string $description
     * @param int $flags
     * @return $this
     */
    public function description(string $description, int $flags = self::ALL): MetadataManager
    {
        if ( $this->ifMeta( $flags ) ) {
            $this->metaDescription( $description );
        }

        if ( $this->ifTwitter( $flags ) ) {
            $this->twitterDescription( $description );
        }

        if ( $this->ifOpengraph( $flags ) ) {
            $this->ogDescription( $description );
        }

        return $this;
    }

    /**
     * Set the page description in meta tags
     *
     * @param string $description
     * @return $this
     */
    public function metaDescription(string $description): MetadataManager
    {
        return $this->meta( 'description', $description, true );
    }

    /**
     * Set the page description in meta tags for Twitter Cards
     *
     * @param string $description
     * @return $this
     */
    public function twitterDescription(string $description): MetadataManager
    {
        return $this->twitter( 'description', $description, self::TWITTER_PREFIX, true );
    }

    /**
     * Set the page description in meta tags for Opengraph
     *
     * @param string $description
     * @return $this
     */
    public function ogDescription(string $description): MetadataManager
    {
        return $this->opengraph( 'description', $description, self::OPENGRAPH_PREFIX, true );
    }

    /**
     * Set the image for the page used for cards inside app; Can be used to set image options like size or mimetype
     *
     * @param string $url
     * @param string|null $secure_url
     * @param string|null $type
     * @param string|null $width
     * @param string|null $height
     * @param string|null $alt
     * @param int $flags
     * @return $this
     */
    public function image(string $url,
                          ?string $secure_url = null,
                          ?string $type = null,
                          ?int $width = null,
                          ?int $height = null,
                          ?string $alt = null,
                          int $flags = self::TWITTER | self::OPENGRAPH): MetadataManager
    {
        if ( $type ) {
            switch ( $type ) {
                case 'jpeg' :
                case 'jpg' :
                case 'png' :
                case 'webp' :
                case 'gif' :
                    $type = 'image/' . strtolower( $type );
                    break;
            }
        }

        if ( $this->ifTwitter( $flags ) ) {
            $this->twitterImage( $url, $alt );
        }

        if ( $this->ifOpengraph( $flags ) ) {
            $this->ogImage( $url, $secure_url, $type, $width, $height, $alt );
        }

        return $this;
    }

    /**
     * Set the image with corrects options for Twitter Card
     *
     * @param string $url
     * @param string|null $alt
     * @return $this
     */
    public function twitterImage(string $url, ?string $alt = null): MetadataManager
    {
        $this->twitter( 'image', $url );

        foreach (
            compact( 'alt' )
            as $key => $value ) {
            if ( !empty( $value ) ) {
                $this->twitter( 'image:' . $key, (string) $value );
            }
        }

        return $this;
    }

    /**
     * Set the image with corrects options for Opengraph
     *
     * @param string $url
     * @param string|null $secure_url
     * @param string|null $type
     * @param int|null $width
     * @param int|null $height
     * @param string|null $alt
     * @return $this
     */
    public function ogImage(string $url,
                                   ?string $secure_url = null,
                                   ?string $type = null,
                                   ?int $width = null,
                                   ?int $height = null,
                                   ?string $alt = null
    ): MetadataManager
    {
        $this->opengraph( 'image', $url );

        foreach (
            compact( 'secure_url', 'type', 'width', 'height', 'alt' )
            as $key => $value ) {
            if ( !empty( $value ) ) {
                $this->opengraph( 'image:' . $key, (string) $value );
            }
        }

        return $this;
    }

    /**
     * Set the video with corrects options for Opengraph
     *
     * @param string $url
     * @param string|null $secure_url
     * @param string|null $type
     * @param int|null $width
     * @param int|null $height
     * @return $this
     */
    public function ogVideo(string $url,
                                   ?string $secure_url = null,
                                   ?string $type = null,
                                   ?int $width = null,
                                   ?int $height = null
    ): MetadataManager
    {
        $this->opengraph( 'video', $url );

        foreach (
            compact( 'secure_url', 'type', 'width', 'height' )
            as $key => $value ) {
            if ( !empty( $value ) ) {
                $this->opengraph( 'video:' . $key, $value );
            }
        }

        return $this;
    }

    /**
     * Set the audio with corrects options for Opengraph
     *
     * @param string $url
     * @param string|null $secure_url
     * @param string|null $type
     * @return $this
     */
    public function ogAudio(string $url,
                                   ?string $secure_url = null,
                                   ?string $type = null
    ): MetadataManager
    {
        $this->opengraph( 'video', $url );

        foreach (
            compact( 'secure_url', 'type' )
            as $key => $value ) {
            if ( !empty( $value ) ) {
                $this->opengraph( 'video:' . $key, $value );
            }
        }

        return $this;
    }

    /**
     * Set the page URL
     *
     * @param string $url
     * @param int $flags
     * @return $this
     */
    public function url(string $url, int $flags = self::TWITTER | self::OPENGRAPH): MetadataManager
    {
        if ( $this->ifTwitter( $flags ) ) {
            $this->twitterUrl( $url );
        }

        if ( $this->ifOpengraph( $flags ) ) {
            $this->ogUrl( $url );
        }

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function twitterUrl(string $url): MetadataManager
    {
        return $this->twitter( 'url', $url, self::TWITTER_PREFIX, true );
    }

    /**
     * @param string $url
     * @return $this
     */
    public function ogUrl(string $url): MetadataManager
    {
        return $this->opengraph( 'url', $url, self::OPENGRAPH_PREFIX, true );
    }

    /**
     * Set the author's name
     *
     * @param string $author
     * @return $this
     */
    public function author(string $author): MetadataManager
    {
        $this->meta( 'author', $author, true );

        return $this;
    }

    /**
     * Set the content og type
     *
     * @param string $type
     * @param array $options
     * @return $this
     */
    public function ogType(string $type, array $options = []): MetadataManager
    {
        $prefix = self::OPENGRAPH_PREFIX;
        $authorized_keys = [];

        switch ( $type ) {
            case 'music.song' :
                $prefix = 'music:';
                $this->opengraph( 'type', 'music.song', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['duration', 'album', 'album:disc', 'album:track', 'musician'];
                break;

            case 'music.album' :
                $prefix = 'music:';
                $this->opengraph( 'type', 'music.album', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['song', 'song:disc', 'song:track', 'musician', 'release_date'];
                break;

            case 'music.playlist' :
                $prefix = 'music:';
                $this->opengraph( 'type', 'music.playlist', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['song', 'song:disc', 'song:track', 'creator'];
                break;

            case 'music.radio_station' :
                $prefix = 'music:';
                $this->opengraph( 'type', 'music.radio_station', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['creator'];
                break;

            case 'music' :
                $this->opengraph( 'type', 'music', self::OPENGRAPH_PREFIX, true );
                break;

            case 'video.tv_show' :
            case 'video.other' :
            case 'video.movie' :
                $prefix = 'video:';
                $this->opengraph( 'type', 'video', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['actor', 'actor:role', 'director', 'writer', 'duration', 'release_date', 'tag'];
                break;

            case 'video.episode' :
                $prefix = 'video:';
                $this->opengraph( 'type', 'video', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['actor', 'actor:role', 'director', 'writer', 'duration', 'release_date', 'tag', 'series'];
                break;

            case 'video' :
                $this->opengraph( 'type', 'video', self::OPENGRAPH_PREFIX, true );
                break;

            case 'article' :
                $prefix = 'article:';
                $this->opengraph( 'type', 'article', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['published_time', 'modified_time', 'expiration_time', 'author', 'section', 'tag'];
                break;

            case 'book' :
                $prefix = 'book:';
                $this->opengraph( 'type', 'book', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['author', 'isbn', 'release_date', 'tag'];
                break;

            case 'profile' :
                $prefix = 'profile:';
                $this->opengraph( 'type', 'profile', self::OPENGRAPH_PREFIX, true );
                $authorized_keys = ['first_name', 'last_name', 'username', 'gender'];
                break;

            default :
                $this->opengraph( 'type', 'website', self::OPENGRAPH_PREFIX, true );
        }

        foreach ( $options as $key => $value ) {
            if ( empty( $authorized_keys ) || in_array( $key, $authorized_keys ) ) {
                $this->opengraph( $key, $value, $prefix, true );
            }
        }

        return $this;
    }

    /**
     * Set the Twitter card format
     *
     * @param string $card_type
     * @return $this
     */
    public function twitterCard(string $card_type): MetadataManager
    {
        if ( !in_array( $card_type, [ 'summary', 'summary_large_image', 'app', 'player' ] ) ) {
            $card_type = 'summary';
        }

        $this->twitter( 'card', $card_type, self::TWITTER_PREFIX, true );

        return $this;
    }

    /**
     * Set the Twitter website profile
     *
     * @param string $twitter_site
     * @return $this
     */
    public function twitterSite(string $twitter_site): MetadataManager
    {
        $this->twitter( 'site', $twitter_site, self::TWITTER_PREFIX, true );

        return $this;
    }

    /**
     * Set the twitter author profile
     *
     * @param string $twitter_creator
     * @return $this
     */
    public function twitterCreator(string $twitter_creator): MetadataManager
    {
        $this->twitter( 'creator', $twitter_creator, self::TWITTER_PREFIX, true );

        return $this;
    }

    /**
     * Set the facebook app_id
     *
     * @param string $app_id
     * @return $this
     */
    public function fbAppId(string $app_id): MetadataManager
    {
        $this->opengraph( 'app_id', $app_id, self::FACEBOOK_PREFIX, true );

        return $this;
    }

    /**
     * Set the facebook admins tag
     *
     * @param string $admins
     * @return $this
     */
    public function fbAdmins(string $admins): MetadataManager
    {
        $this->opengraph( 'admins', $admins, self::FACEBOOK_PREFIX, true );

        return $this;
    }

    /**
     * Set the og:site_name tag
     *
     * @param string $site_name
     * @return $this
     */
    public function ogSiteName(string $site_name): MetadataManager
    {
        $this->opengraph( 'site_name', $site_name, self::OPENGRAPH_PREFIX, true );

        return $this;
    }

    /**
     * Set the default og:locale tag on the format of language_TERRITORY like en_US
     *
     * @param string $locale
     * @param mixed ...$alternates
     * @return $this
     */
    public function ogLocale(string $locale, ...$alternates): MetadataManager
    {
        $this->opengraph( 'locale', $locale, self::OPENGRAPH_PREFIX, true );

        if ( !empty( $alternates ) ) {
            $this->ogLocaleAlternate( $alternates );
        }

        return $this;
    }

    /**
     * Set an array of locales available for this page on the format of language_TERRITORY like en_US
     *
     * @param mixed ...$locales
     * @return $this
     */
    public function ogLocaleAlternate(...$locales): MetadataManager
    {
        if ( isset( $locales[0] ) && is_array( $locales[0] ) ) {
            $locales = $locales[0];
        }

        foreach ( $locales as $locale ) {
            $this->opengraph( 'locale:alternate', (string) $locale, self::OPENGRAPH_PREFIX, false );
        }

        return $this;
    }

    /**
     * Set the Google Site Verification ID
     *
     * @param string $value
     * @return $this
     */
    public function googleSiteVerification(string $value): MetadataManager
    {
        $this->meta( 'google-site-verification', $value, true );

        return $this;
    }

    /**
     * Set the googlebot meta tag
     *
     * @param mixed ...$values
     * @return MetadataManager
     */
    public function googleBot(...$values): MetadataManager
    {
        if ( isset( $values[0] ) && is_array( $values[0] ) ) {
            $values = $values[0];
        }

        $this->meta('googlebot', implode(', ', $values ), true );

        return $this;
    }

    /**
     * Set the googlebot-news meta tag
     *
     * @param mixed ...$values
     * @return MetadataManager
     */
    public function googleBotNews(...$values): MetadataManager
    {
        if ( isset( $values[0] ) && is_array( $values[0] ) ) {
            $values = $values[0];
        }

        $this->meta('googlebot-news', implode(', ', $values ), true );

        return $this;
    }

    /**
     * Set the robot meta tag
     *
     * @param mixed ...$values
     * @return MetadataManager
     */
    public function robots(...$values): MetadataManager
    {
        if ( isset( $values[0] ) && is_array( $values[0] ) ) {
            $values = $values[0];
        }

        $this->meta('robots', implode(', ', $values ), true );

        return $this;
    }

    /**
     * Disable (or enable if $value is true) the pinterest-rich-pin
     *
     * @param bool $value
     * @return $this
     */
    public function disablePinterestRichPin(bool $value = true): MetadataManager
    {
        $this->meta( 'pinterest-rich-pin', $value ? 'false' : 'true', true );

        return $this;
    }

    /**
     * Set the rating value for Google Safe Search
     *
     * @param string $value
     * @return MetadataManager
     */
    public function rating(string $value): MetadataManager
    {
        $this->meta('rating', $value, true );

        return $this;
    }

    /**
     * Set a meta tag with given key and given value
     *
     * @param string $name
     * @param string $value
     * @param bool $uniq
     * @return $this
     */
    public function meta(string $name, string $value, bool $uniq = false): MetadataManager
    {
        if ( $uniq ) {
            $this->meta[ $name ] = compact( 'name', 'value' );
        } else {
            $this->meta[] = compact( 'name', 'value' );
        }

        return $this;
    }

    /**
     * Set a meta tag for Twitter
     *
     * @param string $name
     * @param string $value
     * @param string $prefix
     * @param bool $uniq
     * @return $this
     */
    public function twitter(string $name, string $value, string $prefix = self::TWITTER_PREFIX, bool $uniq = false): MetadataManager
    {
        if ( $uniq ) {
            $this->twitter[ $name ] = compact( 'name', 'value', 'prefix' );
        } else {
            $this->twitter[] = compact( 'name', 'value', 'prefix' );
        }

        return $this;
    }

    /**
     * Set a meta tag for Opengraph
     *
     * @param string $name
     * @param string $value
     * @param string $prefix
     * @param bool $uniq
     * @return $this
     */
    public function opengraph(string $name, string $value, string $prefix = self::OPENGRAPH_PREFIX, bool $uniq = false): MetadataManager
    {
        if ( $uniq ) {
            $this->opengraph[ $name ] = compact( 'name', 'value', 'prefix' );
        } else {
            $this->opengraph[] = compact( 'name', 'value', 'prefix' );
        }

        return $this;
    }

    /**
     * Alias to the opengraph method
     *
     * @param string $name
     * @param string $value
     * @param string $prefix
     * @param bool $uniq
     * @return $this
     */
    public function og(string $name, string $value, string $prefix = self::OPENGRAPH_PREFIX, bool $uniq = false): MetadataManager
    {
        return $this->opengraph( $name, $value, $prefix, $uniq );
    }

    /**
     * Generate the HTML code of meta tags
     *
     * @param int $flags Determine the type of meta to generate
     * @return string
     */
    public function toHtml(int $flags = self::ALL):string
    {
        $buffer = '';

        if ( $this->ifMeta( $flags ) ) {
            foreach ( $this->meta as $tag ) {
                $buffer.= '<meta name="' . $tag[ 'name' ] . '" content="' . $tag[ 'value' ] . '">' . PHP_EOL;
            }
        }

        if ( $this->ifTwitter( $flags ) ) {
            foreach ( $this->twitter as $tag ) {
                $buffer.= '<meta name="' . $tag[ 'prefix' ] . $tag[ 'name' ] . '" content="' . $tag[ 'value' ] . '">' . PHP_EOL;
            }
        }

        if ( $this->ifOpengraph( $flags ) ) {
            foreach ( $this->opengraph as $tag ) {
                $buffer.= '<meta name="' . $tag[ 'prefix' ] . $tag[ 'name' ] . '" content="' . $tag[ 'value' ] . '">' . PHP_EOL;
            }
        }

        return $buffer;
    }

    /**
     * Print the generated HTML code
     *
     * @param int $flags  Determine the type of meta to generate
     */
    public function print(int $flags = self::ALL):void
    {
        echo $this->toHtml( $flags );
    }

    /**
     * Return the HTML code of meta tags with default parameter
     *
     * @return string
     */
    public function __toString():string
    {
        return $this->toHtml();
    }

    /**
     * Conditional method to check the $flags
     *
     * @param int $flags
     * @return bool
     */
    protected function ifMeta(int $flags):bool
    {
        return $flags & self::ALL || $flags & self::META;
    }

    /**
     * Conditional method to check the $flags
     *
     * @param int $flags
     * @return bool
     */
    protected function ifTwitter(int $flags):bool
    {
        return $flags & self::ALL || $flags & self::TWITTER;
    }

    /**
     * Conditional method to check the $flags
     *
     * @param int $flags
     * @return bool
     */
    protected function ifOpengraph(int $flags):bool
    {
        return $flags & self::ALL || $flags & self::OPENGRAPH;
    }
}
