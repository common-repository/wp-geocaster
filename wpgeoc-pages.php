<?php
/**
 * Load the pages
 */
class WPGEOC_Pages
{
    private $path;

    /**
     * Construct
     * Define the path.
     */
    public function __construct()
    {
        $this->path = WPGEOC_DIR . '/pages/';
    }

    /**
     * Render the page
     *
     * @param null $config
     */
    public function load($config = null)
    {
        $page = $config['page'];
        $config['path'] = $this->path;
        $task = $config['action'] == '-1' ? 'display' : $config['action'];

        require_once(WPGEOC_DIR . '/wpgeocClasses.php');

        $class = 'WPGEOC_Page' . ucfirst($page);

        if (class_exists($class)) {
            $instance = new $class($config);
            $instance->$task();
        }
    }
}