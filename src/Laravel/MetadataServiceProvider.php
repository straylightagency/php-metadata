<?php
namespace Straylightagency\Metadata\Laravel;

use Straylightagency\Metadata\MetadataManager;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * ServiceProvider.
 * Register the Metadata helper class as a singleton into Laravel
 *
 * @package Straylightagency\Metadata
 * @author Anthony Pauwels <anthony@straylightagency.be>
 */
class MetadataServiceProvider extends BaseServiceProvider
{
    /**
     * Register the Metadata
     */
    public function register(): void
    {
        $this->app->singleton('metadata', fn () => new MetadataManager );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides():array
    {
        return [ MetadataManager::class ];
    }
}
