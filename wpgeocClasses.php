<?php
/*********************************************************************
 * Handles countries
 *
 *********************************************************************/
class WPGEOC_PageCountries
{
    protected $totalitems;
    protected $totalpages;
    public $config;

    public function __construct($config = array())
    {
        $this->config = $config;
    }

    public function display()
    {
        include_once(WPGEOC_DIR . 'pages/countries.php');
    }

    public function add()
    {
        $item = $this->getItem();
        $this->config['data'] = $item;
        include_once(WPGEOC_DIR . 'pages/countries.php');
    }

    public function edit()
    {
        $item = $this->getItem();
        $this->config['data'] = $item;
        include_once(WPGEOC_DIR . 'pages/countries.php');
    }

    public function save()
    {
        global $wpdb, $wp_geocaster;

        $data = $this->config['post'];
        $id = $data['id'];
        $name = $data['name'];
        $published = $data['published'];
        if ($id) {
            $sql = "UPDATE " . WPGEOC_TABLE_COUNTRIES . "
             SET
             name='$name',
             published='$published'
             WHERE id = '$id'
             ";
        } else {

            $sql = "INSERT INTO " . WPGEOC_TABLE_COUNTRIES . "
            (name,published)
            VALUES (
            '$name',
            '$published')";
        }

        if (false === $wpdb->query($sql)) {
            die(__('SQL Error! Please try again.'));

        } else {
            $wp_geocaster->message->redirect('countries', __('Country Saved Successfully'), 'success');
        }
    }

    public function getItem($id = null)
    {
        global $wpdb;
        $post = $this->config['post'];
        $post['id'] = isset($post['id'])? $post['id']:0;
        $id = $id ? $id : $post['id'];
        $sql = "SELECT * FROM " . WPGEOC_TABLE_COUNTRIES . " WHERE id='$id'";
        $result = $wpdb->get_row($sql);

        if ($result == null) {
            $result = new stdClass();
            $result->id = '';
            $result->name = '';
            $result->published = '';
        }
        return $result;
    }


    public function geItemLists()
    {
        global $wpdb, $wp_geocaster;
        $perpage = 10;
        $query = "SELECT * FROM " . WPGEOC_TABLE_COUNTRIES;
        $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';

        $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
        if (!empty($orderby) & !empty($order)) {
            $query .= ' ORDER BY ' . $orderby . ' ' . $order;
        }
        $this->totalitems = $wpdb->query($query);

        $paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';


        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }

        $this->totalpages = ceil($this->totalitems / $perpage);


        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query .= ' LIMIT ' . (int)$offset . ',' . (int)$perpage;
        }

        return $wpdb->get_results($query);
    }

    public function getTotalItemsCount()
    {
        return $this->totalitems;
    }

    public function getTotalPages()
    {
        return $this->totalpages;
    }

    public function delete()
    {
        global $wpdb, $wp_geocaster;

        $id = $this->config['post']['id'];

        if (is_array($id)) {
            $id = implode(',', $id);
        }

        $sql = "DELETE FROM  " . WPGEOC_TABLE_COUNTRIES . "
             WHERE id IN ($id)";

        if (false === $wpdb->query($sql)) {
            $wp_geocaster->message->redirect('countries', __('Error! Please try again'), 'error');

        } else {
            $wp_geocaster->message->redirect('countries', __('Record/s Deleted Successfully'), 'success');
        }

    }

    public function publish()
    {
        global $wpdb, $wp_geocaster;
        $id = $this->config['post']['id'];

        if (is_array($id)) {
            $id = implode(',', $id);
        }
        $sql = "UPDATE  " . WPGEOC_TABLE_COUNTRIES . "
            SET published= '1'
             WHERE id IN ($id)";
        if (false === $wpdb->query($sql)) {
            $wp_geocaster->message->redirect('countries', __('Error! Please try again'), 'error');

        } else {
            $wp_geocaster->message->redirect('countries', __('Published Successfully'), 'success');
        }

    }

    public function unpublish()
    {
        global $wpdb, $wp_geocaster;
        $id = $this->config['post']['id'];

        if (is_array($id)) {
            $id = implode(',', $id);
        }
        $sql = "UPDATE  " . WPGEOC_TABLE_COUNTRIES . "
            SET published= '0'
             WHERE id IN ($id)";
        if (false === $wpdb->query($sql)) {
            $wp_geocaster->message->redirect('countries', __('Error! Please try again'), 'error');

        } else {
            $wp_geocaster->message->redirect('countries', __('Unpublished Successfully'), 'success');
        }


    }

    public function getCountryList($publish = null)
    {
        global $wpdb;

        $sql = "SELECT * FROM " . WPGEOC_TABLE_COUNTRIES;
        if (!is_null($publish))
            $sql .= " WHERE published= $publish";

        $sql .= " ORDER BY name ASC";

        $result = $wpdb->get_results($sql);
        return $result;
    }

}


/*********************************************************************
 * Handles states ,cities
 *
 *********************************************************************/
class WPGEOC_PageCities
{
    protected $totalitems;
    protected $totalpages;
    public $config;

    public function __construct($config = array())
    {
        $this->config = $config;
    }

    public function display()
    {
        include_once(WPGEOC_DIR . 'pages/cities.php');
    }

    public function add()
    {

        $country_obj = new WPGEOC_PageCountries();
        $countries = $country_obj->getCountryList(1);
        $item = $this->getItem();
        $this->config['data'] = $item;
        $this->config['countries'] = $countries;
        include_once(WPGEOC_DIR . 'pages/cities.php');
    }

    public function edit()
    {
        $item = $this->getItem();
        $this->config['data'] = $item;
        $country_obj = new WPGEOC_PageCountries();
        $countries = $country_obj->getCountryList(1);
        $this->config['countries'] = $countries;
        include_once(WPGEOC_DIR . 'pages/cities.php');
    }

    public function save()
    {
        global $wpdb, $wp_geocaster;

        $data = $this->config['post'];
        $id = $data['id'];
        $name = $data['name'];
        $state = $data['state'];
        $country_id = $data['country_id'];
        $published = $data['published'];
        $url = $data['url'];
        if ($id) {
            $sql = "UPDATE " . WPGEOC_TABLE_CITIES . "
             SET
             name='$name',
             state='$state',
             country_id='$country_id',
             published='$published',
             url='$url'
             WHERE id = '$id'
             ";
        } else {

            $sql = "INSERT INTO " . WPGEOC_TABLE_CITIES . "
            (name,state,country_id,published,url)
            VALUES (
            '$name',
            '$state',
            '$country_id',
            '$published',
            '$url')";
        }
        if (false === $wpdb->query($sql)) {
            die(__('SQL Error! Please try again.'));

        } else {
            $wp_geocaster->message->redirect('cities', __('City Saved Successfully'), 'success');
        }
    }

    public function getItem($id = null)
    {
        global $wpdb;
        $post = $this->config['post'];
        $post['id'] = isset($post['id'])? $post['id']:0;
        $id = $id ? $id : $post['id'];
        $sql = "SELECT * FROM " . WPGEOC_TABLE_CITIES . " WHERE id='$id'";
        $result = $wpdb->get_row($sql);

        if ($result == null) {
            $result = new stdClass();
            $result->id = '';
            $result->name = '';
            $result->published = '';
            $result->country_id='';
            $result->state='';
            $result->url='';
        }
        return $result;
    }


    public function geItemLists()
    {
        global $wpdb, $wp_geocaster;
        $perpage = 10;
        $query = "SELECT * FROM " . WPGEOC_TABLE_CITIES;
        $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';

        $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
        if (!empty($orderby) & !empty($order)) {
            $query .= ' ORDER BY ' . $orderby . ' ' . $order;
        }
        $this->totalitems = $wpdb->query($query);

        $paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';

        //Page Number
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }

        $this->totalpages = ceil($this->totalitems / $perpage);

        //adjust the query to take pagination into account
        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query .= ' LIMIT ' . (int)$offset . ',' . (int)$perpage;
        }

        return $wpdb->get_results($query);
    }

    public function getTotalItemsCount()
    {
        return $this->totalitems;
    }

    public function getTotalPages()
    {
        return $this->totalpages;
    }

    public function delete()
    {
        global $wpdb, $wp_geocaster;

        $id = $this->config['post']['id'];

        if (is_array($id)) {
            $id = implode(',', $id);
        }

        $sql = "DELETE FROM  " . WPGEOC_TABLE_CITIES . "
             WHERE id IN ($id)";

        if (false === $wpdb->query($sql)) {
            $wp_geocaster->message->redirect('cities', __('Error! Please try again'), 'error');

        } else {
            $wp_geocaster->message->redirect('cities', __('Record/s Deleted Successfully'), 'success');
        }
    }

    public function publish()
    {
        global $wpdb, $wp_geocaster;
        $id = $this->config['post']['id'];

        if (is_array($id)) {
            $id = implode(',', $id);
        }
        $sql = "UPDATE  " . WPGEOC_TABLE_CITIES . "
            SET published= '1'
             WHERE id IN ($id)";

        if (false === $wpdb->query($sql)) {
            $wp_geocaster->message->redirect('cities', __('Error! Please try again'), 'error');

        } else {
            $wp_geocaster->message->redirect('cities', __('Published Successfully'), 'success');
        }

    }

    public function unpublish()
    {
        global $wpdb, $wp_geocaster;
        $id = $this->config['post']['id'];

        if (is_array($id)) {
            $id = implode(',', $id);
        }
        $sql = "UPDATE  " . WPGEOC_TABLE_CITIES . "
            SET published= '0'
             WHERE id IN ($id)";

        if (false === $wpdb->query($sql)) {
            $wp_geocaster->message->redirect('cities', __('Error! Please try again'), 'error');

        } else {
            $wp_geocaster->message->redirect('cities', __('Unpublished Successfully'), 'success');
        }


    }


}

/*********************************************************************
 * Handles frontend section
 *
 ********************************************************************/
class WPGEOC_PageFrontend
{
    public $config;

    public function __construct($config = array())
    {
        $this->config = $config;
    }

    public function display()
    {
        global $wpdb, $wp_geocaster;
        add_action('theme_notices', array($wp_geocaster->message, 'show'));

        $action = isset($this->config['post']['sa_action']) ? $this->config['post']['sa_action']:'';
        $this->config['access'] = is_user_logged_in() ? true : false;

        if (isset($action) && $action == 'save' && $this->config['access']) {
            $this->save();
        }

        $countryobj = new WPGEOC_PageCountries();
        $countries = $countryobj->getCountryList(1);

        $sql = "SELECT cities.*, countries.name as country FROM " . WPGEOC_TABLE_CITIES . " AS cities";
        $sql .= " LEFT JOIN  " . WPGEOC_TABLE_COUNTRIES . " AS countries ON cities.country_id = countries.id  ORDER BY country ASC, cities.name ASC ";

        $result = $wpdb->get_results($sql);

        $list = array();
        $temp = '';
        foreach ($result as $res) {
            if ($temp != $res->country_id) {
                $list[$res->country] = $res->country;
                $list[$res->country] = array();
                $temp = $res->country_id;
            }

            $list[$res->country][] = $res;


        }

        $this->config['items'] = $list;

        $this->config['countries'] = $countries;

        include_once(WPGEOC_DIR . 'pages/frontpage.php');
    }

    public function save()
    {
        global $wpdb, $wp_geocaster;
        $data = $this->config['post'];
        $state = strip_tags((string)$data['sa_state']);
        $city = strip_tags((string)$data['sa_city']);
        $country_id = (int)$data['sa_country'];

        $result = $wpdb->query($wpdb->prepare("INSERT INTO  " . WPGEOC_TABLE_CITIES . "
                (name,state,country_id,published) VALUES ('%s','%s',%d,%d)", $city, $state, $country_id, 1));

        if (!$result) {
            die(__('SQL Error! Please try again.'));

        } else {
            $wp_geocaster->message->front_redirect();
        }
    }
}

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class WPGEOC_Tables extends WP_List_Table
{

    public $model = '';

    /**
     * Constructor that references the parent constructor
     */
    function __construct($config = null)
    {
        global $status, $page;

        $class = 'WPGEOC_Page' . ucfirst($config['page']);
        if (class_exists($class)) {
            $this->model = new $class();
        }

        parent::__construct(array(
            'singular' => 'id', //singular name of the listed records
            'plural' => 'ids', //plural name of the listed records
            'ajax' => false //does this table support ajax?
        ));

    }


    /**
     * Custom column method
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     */
    function column_title($item)
    {

        //Build row actions
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">' . __('Edit', 'wp_geocaster') . '</a>', $_REQUEST['page'], 'edit', $item->id),
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">' . __('Delete', 'wp_geocaster') . '</a>', $_REQUEST['page'], 'delete', $item->id),
        );

        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/
            $item->name,
            /*$2%s*/
            $item->id,
            /*$3%s*/
            $this->row_actions($actions)
        );
    }


    /**
     * REQUIRED
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/
            $this->_args['singular'],
            /*$2%s*/
            $item->id
        );
    }

    function column_published($item)
    {
        $publish = $item->published ? 'enabled.png' : 'disabled.png';
        return '<img src="' . plugins_url() . '/wp-geocaster/images/' . $publish . '" />';
    }


    /**
     * REQUIRED
     *
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **/
    function get_columns()
    {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'wp_geocaster'),
            'published' => __('Published', 'wp_geocaster'),
        );
        return $columns;
    }


    /**
     * Recommended.
     *
     * For more detailed insight into how columns are handled, take a look at
     * WP_List_Table::single_row_columns()
     *
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     */
    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'ordering':
            case 'published':
                return $item->$column_name;
            default:
                return $item->$column_name;
        }
    }

    /**
     * Optional.
     *
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'title' => array('name', false),
            'published' => array('published', false)
        );
        return $sortable_columns;
    }

    /**
     * Optional
     *
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     */
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => __('Delete', 'wp_geocaster'),
            'publish' => __('Publish', 'wp_geocaster'),
            'unpublish' => __('Unpublish', 'wp_geocaster')
        );
        return $actions;
    }


    /**
     * REQUIRED
     *
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     */
    function prepare_items()
    {
        global $wp_geocaster;

        $perpage = 10;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $current_page = $this->get_pagenum();

        $this->items = $this->model->geItemLists();
        $totalitems = $this->model->getTotalItemsCount();
        $totalpages = $this->model->getTotalPages();


        $this->set_pagination_args(array(
            'total_items' => $totalitems,
            'per_page' => $perpage,
            'total_pages' => $totalpages
        ));

    }

}