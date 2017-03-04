# SOLR - Search Driver

> Warning: The SOLR search driver is in experimental stage yet!

## Installation

Add following part into the `components` section of your configuration file.

See also: [Custom Configurations](../admin/advanced-configuration.md)

```php
'search' => [
    'class' => 'humhub\modules\enterprise\modules\solr\engine\SolrSearch',
    'host' => 'solr-host-name-here',
    'port' => 12345,
    'path' => 'solr-path',
    'username' => 'optional-user-name',
    'password' => 'optional-password',
],
```

Rebuild your search index. ([Search](../admin/search.md))