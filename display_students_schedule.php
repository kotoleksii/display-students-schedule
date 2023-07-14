<?php
/*
Plugin Name: ZETK Class Scheduler
Description: Easily access the ZETK class schedule through this plugin. Please ensure that the schedule files are located at the path 'wp-content/uploads/schedule/' with the following naming convention: 'course'_'specialization' (e.g., 1_RPZ).
Version: 1.2.1
Author: Kot Oleksii
Author URI: https://www.instagram.com/kot.oleksiii/
*/

// include css
function include_display_students_schedule_styles()
{
    $css_url = plugin_dir_url(__FILE__) . 'css/display_students_schedule.css';
    wp_enqueue_style('display_students_schedule', $css_url, array(), '1.0.0');
}

add_action('wp_enqueue_scripts', 'include_display_students_schedule_styles');

// main code 
function display_students_schedule_shortcode($atts)
{
    ob_start();

    $course = $_POST['course'] ?? '';
    $specialization = $_POST['specialization'] ?? '';

    if (!empty($course) && !empty($specialization)) {
        $site_url = get_site_url();
        $image_title = $course . '_' . $specialization . '.jpg';

        $server_path = ABSPATH . 'wp-content/uploads/schedule/' . $image_title;
        $image_path = $site_url . '/wp-content/uploads/schedule/' . $image_title;
        $real_path = realpath($server_path);

        $hr_tag = '<hr/>';

        if ($real_path !== false) {
            echo '<img class="display-students-schedule-img" src="' . $image_path . '" alt="Розклад занять ' . $course . ' спеціальності ' . $specialization . '"> ' . $hr_tag;
        } else {
            echo '<h4>Ваш розклад не знайдено, спробуйте пізніше</h4> ' . $hr_tag;
        }
    }

    $course_options = array(
        '1' => 'Курс 1',
        '2' => 'Курс 2',
        '3' => 'Курс 3',
        '4' => 'Курс 4'
    );

    $specialization_options = array(
        'MET' => 'МЕТ',
        'EMA' => 'ЕМА',
        'KTM' => 'KTM',
        'RPZ' => 'РПЗ',
        'EPP' => 'ЕПП',
        'EPS' => 'ЕПС',
        'DZ' => 'ДЗ',
        'EP' => 'ЕП'
    );

    echo '
        <div class="display-students-schedule-form">
            <form action="" method="post">
                <label for="course">Курс:</label>
                <select id="course" name="course">';
    foreach ($course_options as $value => $label) {
        echo '<option value="' . $value . '"' . selected($course, $value, false) . '>' . $label . '</option>';
    }
    echo '
                </select>
                <br/>
                <label for="specialization">Спеціальність:</label>
                <select id="specialization" name="specialization">';
    foreach ($specialization_options as $value => $label) {
        echo '<option value="' . $value . '"' . selected($specialization, $value, false) . '>' . $label . '</option>';
    }
    echo '
                </select>
                <br/>
                <input type="submit" value="Пошук" />
            </form>
        </div>
    ';

    return ob_get_clean();
}

add_shortcode('display_students_schedule', 'display_students_schedule_shortcode');