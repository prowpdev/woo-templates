
<?php
// Hook to register custom page templates
add_filter('theme_page_templates', 'woo_register_custom_templates');

// Hook to load the selected custom template
add_filter('template_include', 'woo_load_custom_template');

/**
 * Register custom page templates found in the plugin directory.
 *
 * @param array $templates Existing templates.
 * @return array Modified templates.
 */
function woo_register_custom_templates($templates) {
    $plugin_template_dir = WOO_TEMPLATE_PLUGIN_DIR . 'theme-page-templates/';
    
    // Check if the directory exists
    if (is_dir($plugin_template_dir)) {
        // Get all the PHP files in the directory
        $files = scandir($plugin_template_dir);
        
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Add the template to the list with a custom name
                $templates[$file] = ucfirst(str_replace('-', ' ', pathinfo($file, PATHINFO_FILENAME)));
            }
        }
    }

    return $templates;
}

/**
 * Load the custom template if selected.
 *
 * @param string $template Default template path.
 * @return string Modified template path.
 */
function woo_load_custom_template($template) {
    global $post;

    // Check if we are in the context of a valid post
    if (isset($post) && is_page()) {
        // Get the selected template for the page
        $selected_template = get_page_template_slug($post->ID);
        
        if ($selected_template) {
            $plugin_template_file = WOO_TEMPLATE_PLUGIN_DIR . 'theme-page-templates/' . $selected_template;

            // Check if the selected template exists in the plugin directory
            if (file_exists($plugin_template_file)) {
                return $plugin_template_file;
            }
        }
    }

    return $template; // Return the default template if no custom template is used
}
