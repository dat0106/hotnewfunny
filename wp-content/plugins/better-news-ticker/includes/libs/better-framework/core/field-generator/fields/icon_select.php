<?php

Better_Framework::factory('icon-factory');
$fontawesome  = BF_Icons_Factory::getInstance('fontawesome');

$list_style = 'grid-2-column';
if( isset($options['list_style']) && !empty($options['list_style']) ){
    $list_style = $options['list_style'];
}

// default selected
$current = array(
    'key' => '' ,
    'title' => isset($options['default_text']) && !empty($options['default_text'])? $options['default_text'] : __( 'Chose an Icon', 'better-studio' ) ,
);
if( isset($options['value']) && !empty($options['value'])){
    if( isset($fontawesome->icons[$options['value']]) ){
        $current['key'] =  $options['value'];
        $current['title'] =  $fontawesome->getIconTag($options['value']) . $fontawesome->icons[$options['value']]['label'];
    }
}

// First, no icon for all cats
$select_options = '<li data-value="" data-label="'.(isset($options['default_text']) && !empty($options['default_text'])? $options['default_text'] : __( 'Chose an Icon', 'better-studio' )).'" class="icon-select-option default-option '. (''===$current['key']?'selected':'') . '">
    <p>'. $fontawesome->getIconTag('') .' '. __( 'No Icon' , 'better-studio' ) .'</p>
</li>';

foreach( (array)$fontawesome->icons as $key => $icon){
    $_cats = '';

    if(isset($icon['category']))
        foreach($icon['category'] as $category){
            $_cats .= ' cat-'.$category;
        }

    $select_options .= '<li data-value="'. $key .'" data-label="'. esc_attr($icon['label']) .'" data-categories="'. $_cats .'" class="icon-select-option '. ($key===$current['key']?'selected':'') . $_cats . '">
        <p>'. $fontawesome->getIconTag($key) .' '. $icon['label'] .'</p>
    </li>';
}


$categories = '<ul class="better-icons-category-list bf-clearfix"><li class="icon-category selected" id="cat-all"><a href="#cat-all">'. __('All: ', 'better-studio') .'</a> <span class="text-muted">'. __('(439)', 'better-studio') .'</span></li>';

foreach( (array)$fontawesome->categories as $key => $category){
    $categories .= '<li class="icon-category" id="cat-'.$category['id'].'"><a href="#cat-'.$category['id'].'">'.$category['label'].'</a> <span class="text-muted">('.$category['counts'].')</span></li>';
}
$categories .= '</ul>';

if( ! isset( $options['input_class'] ) )
    $options['input_class'] = '';


$output = '<div class="bf-select-icon"><div class="select-options">';
$output .= '<span class="selected-option">'. $current['title'] .'</span>';
$output .= '<div class="better-select-icon-options">';
$output .= '<div class="better-icons-search"><label >'. __('Search: ', 'better-studio') .'<input type="text" class="better-icons-search-input" placeholder="Search..."/></label></div>';
$output .= $categories;
$output .= '<div class="options-container"><ul class="options-list '. $list_style .' bf-clearfix">'. $select_options .'</ul></div>' ;
$output .= '</div></div>
<input type="hidden" name="'. $options['input_name'] .'" id="'. $options['input_name'] .'" value="'. $current['key'] .'" class="'. $options['input_class'] .'" />
</div>';

echo $output ;