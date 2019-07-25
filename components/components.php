<?php

// TODO move svg template
$svg = '';
$svg .= '<svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-external components-external-link__icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">';
$svg .= '<path d="M9 3h8v8l-2-1V6.92l-5.6 5.59-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7h7z"></path>';
$svg .= '</svg>';

$input_field_description = sprintf( '%1s <a href="https://wordpress.org/support/article/embeds/#okay-so-what-sites-can-i-embed-from" target="_blank">%2s %3s</a>', esc_html__( 'You can use all of these', 'upf' ), esc_html__( 'web sites', 'upf' ), $svg );

$args = array(
	'post_format'             => 'audio',
	'meta_box_title'          => esc_html__( 'Featured Media', 'upf' ), // TODO move to helper function
	'input_field_type'        => 'text', // TODO move to post format template
	'input_field_label'       => esc_html__( 'Enter URL pointing to audio file or audio streaming provider', 'upf' ), // TODO move to post format template
	'input_field_description' => $input_field_description, // TODO move to post format template
);

// <a class="components-external-link" href="https://codex.wordpress.org/Posts_Add_New_Screen" target="_blank" rel="external noreferrer noopener">
//                                                                                                                 Read about permalinks<span class="screen-reader-text">(opens in a new tab)</span>
//         <svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-external components-external-link__icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
//             <path d="M9 3h8v8l-2-1V6.92l-5.6 5.59-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7h7z"></path>
//         </svg>
//     </a>

new UberPostFormatFramework( $args );

// TODO templates
// audio - text
// video - text
// link - text, dropdown for target
// quote - textarea for quote, text for author
// gallery - gallery uploader