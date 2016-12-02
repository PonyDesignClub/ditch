# Ditch

Ditch is an opinionated plugin to throw out and change certain standard WordPress functionality. The things that you find yourself adding into every custom theme.

Primarily for [PDC](https://www.ponydesignclub.nl) developed themes.

## Things it throws out

### 'wp_head' hook
* WordPress generator ([wp_generator](https://developer.wordpress.org/reference/functions/wp_generator/))
* Shortlink ([wp_shortlink_wp_head](https://developer.wordpress.org/reference/functions/wp_shortlink_wp_head/))
* Really Simple Discovery ([rsd_link](https://developer.wordpress.org/reference/functions/rsd_link/))
* Windows Live Writer ([wlwmanifest_link](https://developer.wordpress.org/reference/functions/wlwmanifest_link/))
* Emoji detection ([print_emoji_detection_script](https://developer.wordpress.org/reference/functions/print_emoji_detection_script/))
* Emoji styles ([print_emoji_styles](https://developer.wordpress.org/reference/functions/print_emoji_styles/))
* Relational links ([adjacent_posts_rel_link_wp_head](https://developer.wordpress.org/reference/functions/adjacent_posts_rel_link_wp_head/))
* General feeds ([feed_links](https://developer.wordpress.org/reference/functions/feed_links/))
* Extra feeds (like category) ([feed_links_extra](https://developer.wordpress.org/reference/functions/feed_links_extra/))
* REST API link tag ([rest_output_link_wp_head](https://developer.wordpress.org/reference/functions/rest_output_link_wp_head/))
* REST API link header ([rest_output_link_header](https://developer.wordpress.org/reference/functions/rest_output_link_header/))
* oEmbed discovery links ([wp_oembed_add_discovery_links](https://developer.wordpress.org/reference/functions/wp_oembed_add_discovery_links/))
* oEmbed JavaScript enqueue ([wp_oembed_add_host_js](https://developer.wordpress.org/reference/functions/wp_oembed_add_host_js/))
* oEmbed REST API route ([wp_oembed_register_route](https://developer.wordpress.org/reference/functions/wp_oembed_register_route/))
* oEmbed HTML filters ([wp_filter_oembed_result](https://developer.wordpress.org/reference/functions/wp_filter_oembed_result/))
* Resource hints ([wp_resource_hints](https://developer.wordpress.org/reference/functions/wp_resource_hints/))

### XML-RPC
Completely disable XML-RPC.

### Menu
* Remove the `Tools` page for non-admins
* Remove the `Appearance > Themes` page for Editor role (which was introduced when adding the `edit_theme_options` capability)
* Remove `New content` in admin bar

## Things it changes

### REST API
Disabling the REST API for not logged in users. A complete disable is not possible due to the WordPress backend being tightly hooked into it. More about that [here](https://core.trac.wordpress.org/ticket/38446).

### Capabilities
Adding `edit_theme_options` capabilities to the Editor role.
