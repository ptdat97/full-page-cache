What is this plugin?

Full Page Cache is a simple file-based full-page caching plugin for Botble CMS. It stores rendered HTML pages as static files (similar in spirit to WP Rocket’s HTML caching), so repeated requests are served instantly without hitting Laravel controllers or the database. Designed for ease-of-use: install, activate and get immediate performance gains.

Key features

Full page HTML caching (file-based) — extremely lightweight and simple.

Automatic cache invalidation when content changes (posts, pages, products).

Excludes dynamic pages by default (cart, checkout, customer account, admin).

Admin button to clear cache manually.

Artisan command to clear cache from the CLI.

Minimal footprint — no extra dependencies required.

Friendly to users (no complicated configuration required) and easy to extend by developers.

How it works (brief)

Middleware intercepts each GET request.

If a cached HTML file exists for the exact URL, the plugin returns it directly.

If not, the request is passed to Laravel; the generated HTML is saved to a cache file for future requests.

When content is created/updated/deleted, the plugin invalidates the cached files related to that content (and the homepage), so visitors always see fresh content.

Installation

Copy the plugin folder to platform/plugins/full-page-cache.

Run (if your setup uses composer autoload):

composer dump-autoload
php artisan optimize:clear


Activate the plugin in Admin → Plugins.

The cache files are stored under storage/fullpage-cache/ (or public/cache/fullpage/ depending on plugin config).

Usage

Clear via Admin UI: go to Full Page Cache in the admin menu and click Clear Cache.

Clear via CLI:

php artisan cache:clear-pages


The plugin automatically avoids caching for /cart, /checkout, /customer/*, and /admin/*.

Admin success message (English):

All cache has been cleared!

Configuration & Extensibility

You can easily add configuration options (TTL, custom exclude patterns, storage path) by creating a config/fullpagecache.php file and reading it from the middleware/service provider.

Developers can hook into the invalidation logic to target more specific URLs (categories, tags, product lists) instead of clearing broadly.

Contributing (please do!)

This plugin is intended to be community-driven. Contributions welcome — small fixes, feature ideas, documentation, translations, tests. Suggested steps:

Fork the repository.

Create a feature branch (feature/your-idea).

Make changes, keep them small and well-documented.

Add or update tests where appropriate.

Submit a pull request with a clear description of the change and why it helps.

Ideas for contributions

Add TTL (time-to-live) support and background pruning.

Add a UI page for settings: exclude patterns, storage path, enable/disable auto-invalidations.

Support multiple cache stores (file, Redis, S3).

Provide per-URL invalidation from model observers (narrower invalidation).

Localization (VN/EN) for admin messages.

License

We recommend an open-source license to encourage contributions, for example MIT License.
