<?php
global $wpdb;

/* WP Geocasater table name */
define('WPGEOC_TABLE_COUNTRIES', $wpdb->prefix . 'wpgeoc_countries');
define('WPGEOC_TABLE_CITIES', $wpdb->prefix . 'wpgeoc_cities');

/**
 * Database Installer
 *
 * Create tables in not exist.
 */
class WPGECO_Install
{
    /**
     * Initialize  he installer
     */
    public function init()
    {
        $this->install();
    }

    /**
     * Create tables
     * @static
     *
     */
    static function install()
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $query = "CREATE TABLE IF NOT EXISTS " . WPGEOC_TABLE_COUNTRIES . " (
		  `id` int(11)  NOT NULL AUTO_INCREMENT,
		  `name` varchar(50) DEFAULT NULL,
		  `published` tinyint(1) DEFAULT '0',
		   PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";
        dbDelta($query);

        $query = "CREATE TABLE IF NOT EXISTS " . WPGEOC_TABLE_CITIES . " (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) DEFAULT NULL,
		  `state` varchar(255) DEFAULT NULL,
                  `url` varchar(255) DEFAULT NULL,
		  `published` tinyint(1) DEFAULT NULL,
		  `country_id` varchar(8) DEFAULT NULL,
		  PRIMARY KEY (`id`)		
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

        $query .= "
                INSERT INTO `" . WPGEOC_TABLE_COUNTRIES . "` (`id`, `name`, `published`) VALUES
                (1, 'Andorra', 0),
                (2, 'United Arab Emirates', 0),
                (3, 'Afghanistan', 0),
                (4, 'Antigua and Barbuda', 0),
                (5, 'Anguilla', 0),
                (6, 'Albania', 0),
                (7, 'Armenia', 0),
                (8, 'Netherlands Antilles', 0),
                (9, 'Angola', 0),
                (10, 'Antarctica', 0),
                (11, 'Argentina', 0),
                (12, 'American Samoa', 0),
                (13, 'Austria', 0),
                (14, 'Australia', 0),
                (15, 'Aruba', 0),
                (16, 'Azerbaijan', 0),
                (17, 'Bosnia and Herzegovina', 0),
                (18, 'Barbados', 0),
                (19, 'Bangladesh', 0),
                (20, 'Belgium', 0),
                (21, 'Burkina Faso', 0),
                (22, 'Bulgaria', 0),
                (23, 'Bahrain', 0),
                (24, 'Burundi', 0),
                (25, 'Benin', 0),
                (26, 'Bermuda', 0),
                (27, 'Brunei Darussalam', 0),
                (28, 'Bolivia', 0),
                (29, 'Brazil', 0),
                (30, 'Bahama', 0),
                (31, 'Bhutan', 0),
                (32, 'Burma (no longer exists)', 0),
                (33, 'Bouvet Island', 0),
                (34, 'Botswana', 0),
                (35, 'Belarus', 0),
                (36, 'Belize', 0),
                (37, 'Canada', 0),
                (38, 'Cocos (Keeling) Islands', 0),
                (39, 'Central African Republic', 0),
                (40, 'Congo', 0),
                (41, 'Switzerland', 0),
                (42, 'C?te D''ivoire (Ivory Coast)', 0),
                (43, 'Cook Iislands', 0),
                (44, 'Chile', 0),
                (45, 'Cameroon', 0),
                (46, 'China', 0),
                (47, 'Colombia', 0),
                (48, 'Costa Rica', 0),
                (49, 'Czechoslovakia (no longer exists)', 0),
                (50, 'Cuba', 0),
                (51, 'Cape Verde', 0),
                (52, 'Christmas Island', 0),
                (53, 'Cyprus', 0),
                (54, 'Czech Republic', 0),
                (55, 'German Democratic Republic (no longer exists)', 0),
                (56, 'Germany', 0),
                (57, 'Djibouti', 0),
                (58, 'Denmark', 0),
                (59, 'Dominica', 0),
                (60, 'Dominican Republic', 0),
                (61, 'Algeria', 0),
                (62, 'Ecuador', 0),
                (63, 'Estonia', 0),
                (64, 'Egypt', 0),
                (65, 'Western Sahara', 0),
                (66, 'Eritrea', 0),
                (67, 'Spain', 0),
                (68, 'Ethiopia', 0),
                (69, 'Finland', 0),
                (70, 'Fiji', 0),
                (71, 'Falkland Islands (Malvinas)', 0),
                (72, 'Micronesia', 0),
                (73, 'Faroe Islands', 0),
                (74, 'France', 0),
                (75, 'France, Metropolitan', 0),
                (76, 'Gabon', 0),
                (77, 'United Kingdom (Great Britain)', 0),
                (78, 'Grenada', 0),
                (79, 'Georgia', 0),
                (80, 'French Guiana', 0),
                (81, 'Ghana', 0),
                (82, 'Gibraltar', 0),
                (83, 'Greenland', 0),
                (84, 'Gambia', 0),
                (85, 'Guinea', 0),
                (86, 'Guadeloupe', 0),
                (87, 'Equatorial Guinea', 0),
                (88, 'Greece', 0),
                (89, 'South Georgia and the South Sandwich Islands', 0),
                (90, 'Guatemala', 0),
                (91, 'Guam', 0),
                (92, 'Guinea-Bissau', 0),
                (93, 'Guyana', 0),
                (94, 'Hong Kong', 0),
                (95, 'Heard McDonald Islands', 0),
                (96, 'Honduras', 0),
                (97, 'Croatia', 0),
                (98, 'Haiti', 0),
                (99, 'Hungary', 0),
                (100, 'Indonesia', 0),
                (101, 'Ireland', 0),
                (102, 'Israel', 0),
                (103, 'India', 0),
                (104, 'British Indian Ocean Territory', 0),
                (105, 'Iraq', 0),
                (106, 'Islamic Republic of Iran', 0),
                (107, 'Iceland', 0),
                (108, 'Italy', 0),
                (109, 'Jamaica', 0),
                (110, 'Jordan', 0),
                (111, 'Japan', 0),
                (112, 'Kenya', 0),
                (113, 'Kyrgyzstan', 0),
                (114, 'Cambodia', 0),
                (115, 'Kiribati', 0),
                (116, 'Comoros', 0),
                (117, 'St. Kitts and Nevis', 0),
                (118, 'Korea, Democratic People''s Republic of', 0),
                (119, 'Korea, Republic of', 0),
                (120, 'Kuwait', 0),
                (121, 'Cayman Islands', 0),
                (122, 'Kazakhstan', 0),
                (123, 'Lao People''s Democratic Republic', 0),
                (124, 'Lebanon', 0),
                (125, 'Saint Lucia', 0),
                (126, 'Liechtenstein', 0),
                (127, 'Sri Lanka', 0),
                (128, 'Liberia', 0),
                (129, 'Lesotho', 0),
                (130, 'Lithuania', 0),
                (131, 'Luxembourg', 0),
                (132, 'Latvia', 0),
                (133, 'Libyan Arab Jamahiriya', 0),
                (134, 'Morocco', 0),
                (135, 'Monaco', 0),
                (136, 'Moldova, Republic of', 0),
                (137, 'Madagascar', 0),
                (138, 'Marshall Islands', 0),
                (139, 'Mali', 0),
                (140, 'Mongolia', 0),
                (141, 'Myanmar', 0),
                (142, 'Macau', 0),
                (143, 'Northern Mariana Islands', 0),
                (144, 'Martinique', 0),
                (145, 'Mauritania', 0),
                (146, 'Monserrat', 0),
                (147, 'Malta', 0),
                (148, 'Mauritius', 0),
                (149, 'Maldives', 0),
                (150, 'Malawi', 0),
                (151, 'Mexico', 0),
                (152, 'Malaysia', 0),
                (153, 'Mozambique', 0),
                (154, 'Namibia', 0),
                (155, 'New Caledonia', 0),
                (156, 'Niger', 0),
                (157, 'Norfolk Island', 0),
                (158, 'Nigeria', 0),
                (159, 'Nicaragua', 0),
                (160, 'Netherlands', 0),
                (161, 'Norway', 0),
                (162, 'Nepal', 0),
                (163, 'Nauru', 0),
                (164, 'Neutral Zone (no longer exists)', 0),
                (165, 'Niue', 0),
                (166, 'New Zealand', 0),
                (167, 'Oman', 0),
                (168, 'Panama', 0),
                (169, 'Peru', 0),
                (170, 'French Polynesia', 0),
                (171, 'Papua New Guinea', 0),
                (172, 'Philippines', 0),
                (173, 'Pakistan', 0),
                (174, 'Poland', 0),
                (175, 'St. Pierre Miquelon', 0),
                (176, 'Pitcairn', 0),
                (177, 'Puerto Rico', 0),
                (178, 'Portugal', 0),
                (179, 'Palau', 0),
                (180, 'Paraguay', 0),
                (181, 'Qatar', 0),
                (182, 'R?union', 0),
                (183, 'Romania', 0),
                (184, 'Russian Federation', 0),
                (185, 'Rwanda', 0),
                (186, 'Saudi Arabia', 0),
                (187, 'Solomon Islands', 0),
                (188, 'Seychelles', 0),
                (189, 'Sudan', 0),
                (190, 'Sweden', 0),
                (191, 'Singapore', 0),
                (192, 'St. Helena', 0),
                (193, 'Slovenia', 0),
                (194, 'Svalbard Jan Mayen Islands', 0),
                (195, 'Slovakia', 0),
                (196, 'Sierra Leone', 0),
                (197, 'San Marino', 0),
                (198, 'Senegal', 0),
                (199, 'Somalia', 0),
                (200, 'Suriname', 0),
                (201, 'Sao Tome Principe', 0),
                (202, 'Union of Soviet Socialist Republics (no longer exi', 0),
                (203, 'El Salvador', 0),
                (204, 'Syrian Arab Republic', 0),
                (205, 'Swaziland', 0),
                (206, 'Turks Caicos Islands', 0),
                (207, 'Chad', 0),
                (208, 'French Southern Territories', 0),
                (209, 'Togo', 0),
                (210, 'Thailand', 0),
                (211, 'Tajikistan', 0),
                (212, 'Tokelau', 0),
                (213, 'Turkmenistan', 0),
                (214, 'Tunisia', 0),
                (215, 'Tonga', 0),
                (216, 'East Timor', 0),
                (217, 'Turkey', 0),
                (218, 'Trinidad Tobago', 0),
                (219, 'Tuvalu', 0),
                (220, 'Taiwan, Province of China', 0),
                (221, 'Tanzania, United Republic of', 0),
                (222, 'Ukraine', 0),
                (223, 'Uganda', 0),
                (224, 'United States Minor Outlying Islands', 0),
                (225, 'United States of America', 1),
                (226, 'Uruguay', 0),
                (227, 'Uzbekistan', 0),
                (228, 'Vatican City State (Holy See)', 0),
                (229, 'St. Vincent the Grenadines', 0),
                (230, 'Venezuela', 0),
                (231, 'British Virgin Islands', 0),
                (232, 'United States Virgin Islands', 0),
                (233, 'Viet Nam', 0),
                (234, 'Vanuatu', 0),
                (235, 'Wallis Futuna Islands', 0),
                (236, 'Samoa', 0),
                (237, 'Democratic Yemen (no longer exists)', 0),
                (238, 'Yemen', 0),
                (239, 'Mayotte', 0),
                (240, 'Yugoslavia', 0),
                (241, 'South Africa', 0),
                (242, 'Zambia', 0),
                (243, 'Zaire', 0),
                (244, 'Zimbabwe', 0);
                     ";
        dbDelta($query);

        update_option('wpgeoc_db_version', "1.0");


    }


}

/**
 * Handles Messaging for backend operations
 *
 */
class WPGEOC_Message
{

    /**
     * Display Message
     */
    public function show()
    {
        if (isset($_SESSION['sa_message'])) {
            if (!is_null($_SESSION['sa_message'])) {
                $msgClass = $_SESSION['sa_message']['type'] == "success" ? 'sasuccess' : 'saerror';
                echo '<div class="sa_message ' . $msgClass . '">' . $_SESSION['sa_message']['message'] . '</div>';
                $_SESSION['sa_message'] = null;
            }
        }
    }

    /**
     * Redirect the page, setting the message to session
     *
     * @param $redirect redirect url
     * @param $msg message to display
     * @param $type message type ( 'success' /' error');
     */
    public function redirect($redirect, $msg, $type)
    {
        $_SESSION['sa_message'] = array(
            'message' => $msg,
            'type' => $type
        );

        if ($redirect) {
            if (is_admin())
                wp_redirect(admin_url('admin.php?page=wpgeoc-' . $redirect));
            else
                wp_redirect($redirect);
        } else {
            wp_redirect(get_permalink());
        }
    }

    /**
     * Front page redirect
     *
     * redirect the page after user inserts new city
     */
    public function front_redirect()
    {
        wp_redirect(get_permalink());
    }
}