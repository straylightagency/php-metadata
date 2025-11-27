<?php
namespace Straylightagency\Metadata\Laravel;

use Illuminate\Support\Facades\Facade;
use Straylightagency\Metadata\MetadataManager;

/**
 * Facade.
 * Provide quick access methods to the MetadataManager class
 *
 * @method static MetadataManager setPrefixUrl(string $prefix_url)
 * @method static MetadataManager setTags(array $tags)
 * @method static MetadataManager title(string $title, int $flags = MetadataManager::ALL)
 * @method static MetadataManager twitterTitle(string $title)
 * @method static MetadataManager ogTitle(string $title)
 * @method static MetadataManager description(string $description, int $flags = MetadataManager::ALL)
 * @method static MetadataManager twitterDescription(string $description)
 * @method static MetadataManager ogDescription(string $description)
 * @method static MetadataManager image(string $url, ?string $secure_url = null, ?string $type = null, ?string $width = null, ?string $height = null, ?string $alt = null, int $flags = MetadataManager::TWITTER | MetadataManager::OPENGRAPH)
 * @method static MetadataManager twitterImage(string $url, ?string $alt = null)
 * @method static MetadataManager ogImage(string $url, ?string $secure_url = null, ?string $type = null, ?string $width = null, ?string $height = null, ?string $alt = null)
 * @method static MetadataManager ogVideo(string $url, ?string $secure_url = null, ?string $type = null, ?string $width = null, ?string $height = null)
 * @method static MetadataManager ogAudio(string $url, ?string $secure_url = null, ?string $type = null)
 * @method static MetadataManager url(?string $url = null, int $flags = MetadataManager::TWITTER | MetadataManager::OPENGRAPH)
 * @method static MetadataManager twitterUrl(?string $url = null)
 * @method static MetadataManager ogUrl(?string $url = null)
 * @method static MetadataManager author(string $author)
 * @method static MetadataManager ogType(string $type = 'website', array $options = [])
 * @method static MetadataManager twitterCard(string $card_type = 'summary')
 * @method static MetadataManager twitterSite(string $twitter_site)
 * @method static MetadataManager twitterCreator(string $twitter_creator)
 * @method static MetadataManager fbAppId(string $app_id)
 * @method static MetadataManager fbAdmins(string $admins)
 * @method static MetadataManager ogSiteName(string $site_name)
 * @method static MetadataManager ogLocale(string $locale, ...$alternates)
 * @method static MetadataManager ogLocaleAlternate(...$locales)
 * @method static MetadataManager googleSiteVerification(string $value)
 * @method static MetadataManager googleBot(...$values)
 * @method static MetadataManager googleBotNews(...$values)
 * @method static MetadataManager robots(...$values)
 * @method static MetadataManager disablePinterestRichPin(bool $value = true)
 * @method static MetadataManager rating(string $value)
 * @method static MetadataManager meta(string $name, $value, bool $uniq = false)
 * @method static MetadataManager twitter(string $name, $value, string $prefix = MetadataManager::TWITTER_PREFIX, bool $uniq = false)
 * @method static MetadataManager opengraph(string $name, $value, string $prefix = MetadataManager::OPENGRAPH_PREFIX, bool $uniq = false)
 * @method static MetadataManager og(string $name, $value, string $prefix = MetadataManager::OPENGRAPH_PREFIX, bool $uniq = false)
 * @method static MetadataManager toHtml(int $flags = MetadataManager::ALL)
 * @method static MetadataManager print(int $flags = MetadataManager::ALL)
 * @method static MetadataManager __toString()
 *
 * @package Straylightagency\Metadata
 * @author Anthony Pauwels <hello@anthonypauwels.be>
 */
class Metadata extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return MetadataManager::class;
    }
}