<?php
/* ------------------------------------------------------------------------*
 * Columns
 * ------------------------------------------------------------------------*/

// columns wrapper
function show_columns($atts, $content = null) {
    return '<div class="row">'.do_shortcode($content).'</div>';
}
add_shortcode('columns', 'show_columns');

// single column
function show_single_column($atts, $content = null) {
    return '<div class="col-lg-12 col-md-12 col-sm-12">'.do_shortcode($content).'</div>';
}
add_shortcode('single_column', 'show_single_column');

// two columns
function show_two_column($atts, $content = null) {
    return '<div class="col-lg-6 col-md-6 col-sm-6">'.do_shortcode($content).'</div>';
}
add_shortcode('one_half', 'show_two_column');

// three columns
function show_one_third($atts, $content = null) {
    return '<div class="col-lg-4 col-md-4 col-sm-4">'.do_shortcode($content).'</div>';
}
add_shortcode('one_third', 'show_one_third');


// four columns
function show_one_fourth($atts, $content = null) {
    return '<div class="col-lg-3 col-md-3 col-sm-3">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fourth', 'show_one_fourth');

// six columns
function show_one_sixth($atts, $content = null) {
    return '<div class="col-lg-2 col-md-2 col-sm-2">'.do_shortcode($content).'</div>';
}
add_shortcode('one_sixth', 'show_one_sixth');

// three columns
function show_three_fourth($atts, $content = null) {
    return '<div class="col-lg-9 col-md-9 col-sm-9">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fourth', 'show_three_fourth');


/* ------------------------------------------------------------------------*
 * Messages Shortcode
 * ------------------------------------------------------------------------*/

// Information
function show_info($atts, $content = null) {
    return '<p class="message bg-info text-info">'.do_shortcode($content).'<button type="button" class="close" aria-hidden="true">&times;</button></p>';
}
add_shortcode('info', 'show_info');

// Tip
function show_tip($atts, $content = null) {
    return '<p class="message bg-warning text-warning">'.do_shortcode($content).'<button type="button" class="close" aria-hidden="true">&times;</button></p>';
}
add_shortcode('tip', 'show_tip');

// Error
function show_error($atts, $content = null) {
    return '<p class="message bg-danger text-danger">'.do_shortcode($content).'<button type="button" class="close" aria-hidden="true">&times;</button></p>';
}
add_shortcode('error', 'show_error');

// Success
function show_success($atts, $content = null) {
    return '<p class="message bg-success text-success">'.do_shortcode($content).'<button type="button" class="close" aria-hidden="true">&times;</button></p>';
}
add_shortcode('success', 'show_success');


/* ------------------------------------------------------------------------*
 * Lists
 * ------------------------------------------------------------------------*/
// Arrow list one
if (!function_exists('arrow_list_one')) {
    function arrow_list_one($atts, $content = null)
    {
        return '<div class="list-arrow-bullet">' . do_shortcode($content) . '</div>';
    }
}
add_shortcode('arrow_list_one', 'arrow_list_one');

// Arrow list two
if (!function_exists('arrow_list_two')) {
    function arrow_list_two($atts, $content = null)
    {
        return '<div class="list-empty-circle-bullet">' . do_shortcode($content) . '</div>';
    }
}
add_shortcode('arrow_list_two', 'arrow_list_two');


/* ------------------------------------------------------------------------*
 * Buttons
 * ------------------------------------------------------------------------*/

// Default Button
if (!function_exists('default_button')) {
    function default_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'link' => '#',
            'target' => ''
        ), $atts));
        return '<a class="read-more" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
    }
}
add_shortcode('default_button', 'default_button');

// black Button
if (!function_exists('black_button')) {
    function black_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'link' => '#',
            'target' => ''
        ), $atts));

        return '<a class="read-more black" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
    }
}
add_shortcode('black_button', 'black_button');


// Red button
if (!function_exists('red_button')) {
    function red_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'link' => '#',
            'target' => ''
        ), $atts));

        return '<a class="read-more red" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
    }
}
add_shortcode('red_button', 'red_button');

// Orange button
if (!function_exists('orange_button')) {
    function orange_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'link' => '#',
            'target' => ''
        ), $atts));

        return '<a class="read-more orange" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
    }
}
add_shortcode('orange_button', 'orange_button');

// Yellow button
if (!function_exists('yellow_button')) {
    function yellow_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'link' => '#',
            'target' => ''
        ), $atts));

        return '<a class="read-more yellow" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
    }
}
add_shortcode('yellow_button', 'yellow_button');

// Green button
if (!function_exists('green_button')) {
    function green_button($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'link' => '#',
            'target' => ''
        ), $atts));

        return '<a class="read-more green" href="' . $link . '" target="' . $target . '">' . do_shortcode($content) . '</a>';
    }
}
add_shortcode('green_button', 'green_button');


/* ------------------------------------------------------------------------*
 * Tabs
 * ------------------------------------------------------------------------*/
if (!function_exists('show_tabs')) {
    function show_tabs($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "titles" => '',
        ), $atts));
        $all_title = explode(',', $titles);
        $html = '<ul class="tabs-nav clearfix">';
        foreach ($all_title as $title) {
            $html .= '<li>' . $title . '</li>';
        }
        $html .= '</ul><div class="tabs-container">' . do_shortcode($content) . '</div>';
        return $html;
    }
}
add_shortcode('tabs', 'show_tabs');

if (!function_exists('show_tab_pane')) {
    function show_tab_pane($atts, $content = null)
    {

        return '<div class="tab-content">' . do_shortcode($content) . '</div>';
    }
}
add_shortcode('tab_pane', 'show_tab_pane');


/* ------------------------------------------------------------------------*
 * Accordion Shortcode
 * ------------------------------------------------------------------------*/
if (!function_exists('show_accor_wrap')) {
    function show_accor_wrap($atts, $content = null)
    {
        return '  <dl class="accordion clearfix">' . do_shortcode($content) . '</dl>';
    }
}
add_shortcode('accordion', 'show_accor_wrap');

if (!function_exists('show_accor_block')) {
    function show_accor_block($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => ''
        ), $atts));

        return '<dt>' . $title . '<span></span></dt><dd>' . do_shortcode($content) . '</dd>';
    }
}
add_shortcode('accor_block', 'show_accor_block');


/* ------------------------------------------------------------------------*
 * Toggles Shortcode
 * ------------------------------------------------------------------------*/
if (!function_exists('show_toggle_wrap')) {
    function show_toggle_wrap($atts, $content = null){
        return '<dl class="toggle clearfix">' . do_shortcode($content) . '</dl>';
    }
}
add_shortcode('toggles', 'show_toggle_wrap');

if (!function_exists('show_toggle_block')) {
    function show_toggle_block($atts, $content = null){
        extract(shortcode_atts(array(
            'title' => ''
        ), $atts));

        return '<dt>' . $title . '<span></span></dt><dd>' . do_shortcode( $content ) . '</dd>';
    }
}
add_shortcode('toggle_block', 'show_toggle_block');

?>