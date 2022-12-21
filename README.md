# Bellevue College "Douglas Fir" Theme

This is Bellevue College's "Douglas Fir" theme for college departments. It is a successor to the "Mayflower G4" theme, with functionality not related to department websites removed.

## Naming Conventions

This theme adopts 'evergreens of Washington' as the naming convention for in-house themes. The theme is named after the Douglas Fir, a tree native to the Pacific Northwest.

When a new major version of this theme needs to be released (in this case, major is defined as needing to be run in parallel with the previous version), the new theme should be created in a new repo, and named after another tree from the Pacific Northwest. For inspiration, see [this list of trees native to Washington](https://www.wfpa.org/sustainable-forestry/tree-species/).

## Build Processes

This theme uses NPM and Sass to build SCSS files to CSS. Gulp is no longer used.
1. Install NPM dependencies: `npm install`
2. Build CSS: `npm run build`
  * Build with Production settings (**default**): `npm run build:prod`
  * Build with Development settings: `npm run build:dev`
3. Watch for changes: `npm start`

### Other Dependencies

This theme depends on [Bellevue College Globals](https://github.com/BellevueCollege/globals).

You can tell the theme where to find the Globals files in the Theme Options in the Customer, in the Administrator Only section. You can also set these options in `wp-config.php` (see Theme Options in `wp-config.php` below).

This theme is also designed to work with [Mayflower Blocks](https://github.com/BellevueCollege/mayflower-blocks), a collection of Gutenberg blocks for WordPress.

## Theme Options in the Customizer

Display settings for this theme can be found in the WordPress admin under "Appearance > Customize > Bellevue College Theme Options".

## Theme Options in `wp-config.php`

The following option defaults can be set in `wp-config.php`. These will still be overridden by the Customizer settings.

```php
define( 'BC_GLOBALS_PATH', '/g/4/' );
define( 'BC_GLOBALS_APPEND_PATH', true );
define( 'BC_GLOBALS_URL', 'https://www.bellevuecollege.edu/g/4/' );
define( 'BC_GLOBALS_VERSION', '1.0.0' );
```

## Theme Structure

Critical files and folders:
* `css/` - CSS files other than the primary theme stylesheet.
  * `block-editor.css` - Do not edit directly- this is compiled from `scss/block-editor.scss`.
* `img/` - Images used in the theme.
* `inc/` - PHP files that extend various parts of the theme.
  * `course-descriptions.php` - Adds a shortcode for displaying course descriptions.
  * `functions/` - Theme setup and other functionality that would normally be in `functions.php`.
    * `globals.php` - Class to allow for easy access to Bellevue College Globals.
    * `options-customizer.php` - Theme options in the Customizer.
    * `plugin-hooks.php` - Hooks for plugins. Customizes Gravity Forms, TablePress, and others.
    * `theme-setup.php` - Theme setup and other functionality that would normally be in `functions.php`.
  	* `wordpress-hooks.php` - Hooks for WordPress. Customizes the WordPress admin, login, and others.
  * `nav-page/` - Display a page's children as on the page itself
  * `seo/` - Add custom fields for SEO
  * `slider/` - Bundled 'plugin'. Includes CPT and interface. Disabled by default, but can be enabled in the Theme Options in the Customizer.
  * `staff/` - Bundled 'plugin'. Includes CPT and interface. Disabled by default, but can be enabled in the Theme Options in the Customizer.
  * `wp-bootstrap-navwalker-4.0.2` - Bootstrap 4 navwalker (external library) used to display menus in Bootstrap 4 format.
* `js/` - JavaScript files.
* `list-category-posts/` - Customizations for the List Category Posts plugin.
* `parts/` - Template parts used in the theme. Most changes to how pages, posts, etc display would be made here.
* `sass/` - SCSS files for `style.css` and `block-editor.css`.
* template files at root are mostly the same, since they use template parts for most of the content.

