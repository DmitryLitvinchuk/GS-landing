<?php
/**
 * Plugin Name: 	Spectra
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/spectra
 * Author URI: 		http://rascals.eu
 * File:			shortcodes.php
 * =========================================================================================================================================
 *
 * @package spectra-plugin
 * @since 1.0.0
 */


/* Global shortcode ID */
global $spectra_sid;

$spectra_sid = 0;

/* ----------------------------------------------------------------------
    COLUMNS GRID

    Example Usage: 
    [1_2] 
       ...Content Here
    [/1_2]
    [1_2_last] 
       ...Content Here
    [/1_2_last]

/* ---------------------------------------------------------------------- */

/* Row */
function spectra_row( $atts, $content = null ) {
   return '<div class="row">' . do_shortcode($content) . '</div>';
}
add_shortcode('row', 'spectra_row');

/* Two */
function spectra_1_2( $atts, $content = null ) {
   return '<div class="col-1-2">' . do_shortcode($content) . '</div>';
}
add_shortcode('1_2', 'spectra_1_2');

function spectra_1_2_last( $atts, $content = null ) {
   return '<div class="col-1-2 last">' . do_shortcode($content) . '</div>';
}
add_shortcode('1_2_last', 'spectra_1_2_last');

/* Three */
function spectra_1_3( $atts, $content = null ) {
   return '<div class="col-1-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('1_3', 'spectra_1_3');

function spectra_1_3_last( $atts, $content = null ) {
   return '<div class="col-1-3 last">' . do_shortcode($content) . '</div>';
}
add_shortcode('1_3_last', 'spectra_1_3_last');

/* Four */
function spectra_1_4( $atts, $content = null ) {
   return '<div class="col-1-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('1_4', 'spectra_1_4');

function spectra_1_4_last( $atts, $content = null ) {
   return '<div class="col-1-4 last">' . do_shortcode($content) . '</div>';
}
add_shortcode('1_4_last', 'spectra_1_4_last');

/* Two Third */
function spectra_2_3( $atts, $content = null ) {
   return '<div class="col-2-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('2_3', 'spectra_2_3');

function spectra_2_3_last( $atts, $content = null ) {
   return '<div class="col-2-3 last">' . do_shortcode($content) . '</div>';
}
add_shortcode('2_3_last', 'spectra_2_3_last');

/* Three Fourth */
function spectra_3_4( $atts, $content = null ) {
   return '<div class="col-3-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('3_4', 'spectra_3_4');

function spectra_3_4_last( $atts, $content = null ) {
   return '<div class="col-3-4 last">' . do_shortcode($content) . '</div>';
}
add_shortcode('3_4_last', 'spectra_3_4_last');


/* ----------------------------------------------------------------------
    DIVIDER

    Example Usage:
    [divider]
/* ---------------------------------------------------------------------- */
function spectra_divider( $atts, $content = null ) {
   return '<hr class="divider">';
}
add_shortcode( 'divider', 'spectra_divider' );


/* ----------------------------------------------------------------------
    TWEETS LIST

    Example Usage:
    [tweets_list time="30" limit="2" username="" replies="true" api_key="" api_secret=""]
/* ---------------------------------------------------------------------- */
function spectra_tweets_list( $atts, $content = null ) {
   extract(shortcode_atts(array(
        'time'       => 30,
        'limit'      => '1',
        'username'   => '',
        'replies'    => 'no',
        'api_key'    => '',
        'api_secret' => ''
    ), $atts));

    $opts = array(
        'time'       => $time,
        'limit'      => $limit,
        'username'   => $username,
        'replies'    => $replies,
        'api_key'    => $api_key,
        'api_secret' => $api_secret
    );
    
    $output = '';
    if ( function_exists( 'spectra_twitter_feed' ) ) {

        $tweets = spectra_twitter_feed( $opts );

        if ( is_array( $tweets ) ) {
            $output .= '<ul class="tweets">';
            foreach ( $tweets as $key => $tweet ) {
                $output .= '<li>' . $tweet[ 'text' ] . '<span class="date">' . $tweet[ 'date' ] . '</span></li>';  
                if ( $key == $limit ) {
                    break;
                }
            }

            $output .= '</ul>';
            return $output;

        } else {
            // Errors
            return $tweets;
        }
        
    }

    return;

}
add_shortcode( 'tweets_list', 'spectra_tweets_list' );


/* ----------------------------------------------------------------------
    TWEETS SLIDER

    Example Usage:
    [tweets_list time="30" limit="2" username="" replies="true" api_key="" api_secret=""]
/* ---------------------------------------------------------------------- */
function spectra_tweets_slider( $atts, $content = null ) {

    global $spectra_sid;
    $spectra_sid++;

    extract(shortcode_atts(array(
        'time'                => 30,
        'limit'               => '1',
        'username'            => '',
        'replies'             => 'no',
        'api_key'             => '',
        'api_secret'          => ''
    ), $atts));

    $opts = array(
        'time'                => $time,
        'limit'               => $limit,
        'username'            => $username,
        'replies'             => $replies,
        'api_key'             => $api_key,
        'api_secret'          => $api_secret
    );
    
    $output = '';
    if ( function_exists( 'spectra_twitter_feed' ) ) {

        $tweets = spectra_twitter_feed( $opts );

        if ( is_array( $tweets ) ) {

            $output .= '<div id="twitter-slider-id' . esc_attr( $spectra_sid ) . '" class="slider carousel-slider text-slider tweets-slider" data-effect="fade" data-pagination="true" data-nav="false" data-autoplay="false">';
            foreach ( $tweets as $key => $tweet ) {
                $output .= '<div class="slide"><div class="tweet">' . $tweet[ 'text' ] . '<span class="date">' . $tweet[ 'date' ] . '</span></div></div>';  
                 if ( $key == $limit ) {
                    break;
                }
            }

            $output .= '</div>';
            return $output;

        } else {
            // Errors
            return $tweets;
        }
        
    }

    return;

}
add_shortcode( 'tweets_slider', 'spectra_tweets_slider' );


/* ----------------------------------------------------------------------
    INTRO TICKER

    Example Usage:
    [intro_ticker] 
        [tick] ...Text here... [/tick]
        [tick] ...Text here... [/tick]
        [tick] ...Text here... [/tick]
        [tick] ...Text here... [/tick]
    [/intro_ticker]
/* ---------------------------------------------------------------------- */
function spectra_intro_ticker( $atts, $content = null ) {
   return '<div id="ticker-wrap"><ul id="ticker">' . do_shortcode( $content ) . '</ul></div>';
}

add_shortcode( 'intro_ticker', 'spectra_intro_ticker' );

function spectra_tick( $atts, $content = null ) {
   return '<li>' . do_shortcode( $content ) . '</li>';
}

add_shortcode('tick', 'spectra_tick');


/* ----------------------------------------------------------------------
    HEADINGS

    Example Usage:
    [heading_xl align="center"] ... Text here... [/heading_xl]
    [heading_l align="center"] ... Text here... [/heading_l]
    [heading_m align="center"] ... Text here... [/heading_m]
    [subheading align="center"] .. Text here... [subheading]
    [subheading_top align="center"] .. Text here... [subheading_top]
    
    Attributes:
    align - center, left, right. Default: center. 

/* ---------------------------------------------------------------------- */
function spectra_heading_xl( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'align'   => 'center'
    ), $atts));
   return '<h2 class="heading-xl text-' . esc_attr( $align ) . '">' . do_shortcode( $content ) . '</h2>';
}

add_shortcode( 'heading_xl', 'spectra_heading_xl' );

function spectra_heading_l( $atts, $content = null ) {
  extract(shortcode_atts(array(
        'align'   => 'center'
    ), $atts));
   return '<h2 class="heading-l text-' . esc_attr( $align ) . '">' . do_shortcode( $content ) . '</h2>';
}

add_shortcode( 'heading_l', 'spectra_heading_l' );

function spectra_heading_m( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'align'   => 'center'
    ), $atts));
   return '<h2 class="heading-m text-' . esc_attr( $align ) . '">' . do_shortcode( $content ) . '</h2>';
}

add_shortcode( 'heading_m', 'spectra_heading_m' );

function spectra_subheading( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'align'   => 'center'
    ), $atts));
   return '<span class="sub-heading text-' . esc_attr( $align ) . '">' . do_shortcode( $content ) . '</span>';
}

add_shortcode( 'subheading', 'spectra_subheading' );

function spectra_subheading_top( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'align'   => 'center'
    ), $atts));
    return '<span class="sub-heading top text-' . esc_attr( $align ) . '">' . do_shortcode( $content ) . '</span>';
}

add_shortcode( 'subheading_top', 'spectra_subheading_top' );


/* ----------------------------------------------------------------------
    PROCESS STEPS

    Example Usage:
    [process_steps image_1="" link_1="none" link_target_1="_self" image_2="" link_2="none" link_target_2="_self" image_3="" link_3="none" link_target_3="_self" image_4="" link_4="none" link_target_4="_self"]
    
    Attributes:
    image_1 - Image URL. Default: empty.
    link_1 - Image link URL. none, link. Default: none. (none disable link)
    link_target_1 - Image link target. _self, _blank. Default: _self.
    image_2 - Image URL. Default: empty.
    link_2 - Image link URL. none, link. Default: none. (none disable link)
    link_target_2 - Image link target. _self, _blank. Default: _self.
    image_3 - Image URL. Default: empty.
    link_3 - Image link URL. none, link. Default: none. (none disable link)
    link_target_3 - Image link target. _self, _blank. Default: _self.
    image_4 - Image URL. Default: empty.
    link_4 - Image link URL. none, link. Default: none. (none disable link)
    link_target_4 - Image link target. _self, _blank. Default: _self.

/* ---------------------------------------------------------------------- */
function spectra_process_steps( $atts, $content = null ) {

    global $spectra_sid;
    $spectra_sid++;

    extract(shortcode_atts(array(
        'image_1'         => '',
        'link_1'          => 'none',
        'link_target_1'   => '_self',
        'image_2'         => '',
        'link_2'          => 'none',
        'link_target_2'   => '_self',
        'image_3'         => '',
        'link_3'          => 'none',
        'link_target_3'   => '_self',
        'image_4'         => '',
        'link_4'          => 'none',
        'link_target_4'   => '_self'
    ), $atts));

    $output = '';

    $output .= '<div class="steps">';


    // 1
    if ( is_numeric( $image_1 ) ) {
        $image_1 = wp_get_attachment_url( $image_1 ); 
    }
    if ( $image_1 != '' ) {
        $output .= '<div class="step">';
        $output .= '<div class="step-number">01</div>';
        if ( $link_1 == 'none' ) {
            $link_1 = '';
        } else {
            $link_1 = 'href="' . esc_url( $link_1 ) . '"';
        }
        $output .= '<a ' . $link_1 . ' target="' . esc_attr( $link_target_1 ) . '"><img alt="' . esc_attr( __( 'Step Image', SPECTRA_PLUGIN ) ) . '" src="' . esc_url( $image_1 ) . '"/></a>';
        $output .= '</div>';
    }

    // 2
    if ( is_numeric( $image_2 ) ) {
        $image_2 = wp_get_attachment_url( $image_2 ); 
    }
    if ( $image_2 != '' ) {
        $output .= '<div class="step">';
        $output .= '<div class="step-number">02</div>';
        if ( $link_2 == 'none' ) {
            $link_2 = '';
        } else {
            $link_2 = 'href="' . esc_url( $link_2 ) . '"';
        }
        $output .= '<a ' . $link_2 . ' target="' . esc_attr( $link_target_2 ) . '"><img alt="' . esc_attr( __( 'Step Image', SPECTRA_PLUGIN ) ) . '" src="' . esc_url( $image_2 ) . '"/></a>';
        $output .= '</div>';
    }

    // 3
    if ( is_numeric( $image_3 ) ) {
        $image_3 = wp_get_attachment_url( $image_3 ); 
    }
    if ( $image_3 != '' ) {
        $output .= '<div class="step">';
        $output .= '<div class="step-number">03</div>';
        if ( $link_3 == 'none' ) {
            $link_3 = '';
        } else {
            $link_3 = 'href="' . esc_url( $link_3 ) . '"';
        }
        $output .= '<a ' . $link_3 . ' target="' . esc_attr( $link_target_3 ) . '"><img alt="' . esc_attr( __( 'Step Image', SPECTRA_PLUGIN ) ) . '" src="' . esc_url( $image_3 ) . '"/></a>';
        $output .= '</div>';
    }

    // 4
    if ( is_numeric( $image_4 ) ) {
        $image_4 = wp_get_attachment_url( $image_4 ); 
    }
    if ( $image_4 != '' ) {
        $output .= '<div class="step">';
        $output .= '<div class="step-number">04</div>';
        if ( $link_4 == 'none' ) {
            $link_4 = '';
        } else {
            $link_4 = 'href="' . esc_url( $link_4 ) . '"';
        }
        $output .= '<a ' . $link_4 . ' target="' . esc_attr( $link_target_4 ) . '"><img alt="' . esc_attr( __( 'Step Image', SPECTRA_PLUGIN ) ) . '" src="' . esc_url( $image_4 ) . '"/></a>';
        $output .= '</div>';
    }
   
    $output .= '</div>';
    return $output;
}
add_shortcode( 'process_steps', 'spectra_process_steps' );


/* ----------------------------------------------------------------------
    TRACKLIST GRID

    Example Usage:
    [tracklist_grid id="1" in_row="4" list_button="0"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer). 
    in_row - 1,2,3,4,5. Default: 3 (string).
    track_meta - 1,0. Default: 1 (string).
    list_button - 1,0. Default: 0 (string).
    list_button_action - sp-play-list, sp-add-list. Default: sp-play-list (string).
    track_action - sp-play-track, sp-add-track. Default: sp-play-track (string).

/* ---------------------------------------------------------------------- */
function spectra_tracklist_grid( $atts, $content = null ) {

    global $spectra_sid;

    extract(shortcode_atts(array(
        'id'                 => 0,
        'in_row'             => '3',
        'track_meta'         => '0',
        'list_button'        => '0',
        'list_button_action' => 'sp-play-list',
        'track_action'       => 'sp-play-track',
        'class'              => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }
    $spectra_sid++;
    $tracklist_grid = scamp_player_get_list( $id );

    if ( $track_meta == '0' ) {
        $track_meta = 'hidden';
    } else {
        $track_meta = '';
    }

    $output .= '<div id="tracklist-grid-' . esc_attr( $spectra_sid ) . '" class="tracklist-grid ' . esc_attr( $class ) . '">' ."\n";

    foreach ( $tracklist_grid as $track ) {
        if ( function_exists( 'spectra_get_image_id' ) &&  spectra_get_image_id( $track['cover'], 'full' ) ) {
            $track['cover'] = spectra_get_image_id( $track['cover'], 'full' );
        } else {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
            <div class="tracks-grid-' . esc_attr( $in_row ) . '-col">
                    <a class="track ' .  esc_attr( $track_action ) . ' tracks-grid-item tooltip" href="' .  esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '" title="' . esc_attr( $track['title'] ) . ' <em> - ' . esc_attr( $track['artists'] ) . '</em>">
                        <img class="track-cover" src="' . esc_attr( $track['cover'] ) . '" alt="' . esc_attr( __( 'Cover Image', SPECTRA_PLUGIN ) ) . '">
                        <span class="track-meta ' . esc_attr( $track_meta ) . '">
                            <span class="track-title">' . $track['title'] . '</span>
                            <span class="track-artists">' . $track['artists'] . '</span>
                        </span>
                    </a>';
        $output .= '</div>';
    }

    $output .= '</div>' ."\n";

    if ( $list_button == '1' ) {
        $output .= '<a class="list-btn btn small ' . esc_attr( $list_button_action ) . '" data-id="tracklist-grid-' . esc_attr( $spectra_sid ) . '" ><i class="icon icon-play2"></i>' . __( 'PLAY LIST', SPECTRA_PLUGIN ) . '</a>';
    }

   return $output;
}
add_shortcode( 'tracklist_grid', 'spectra_tracklist_grid' );


/* ----------------------------------------------------------------------
    TRACKS CAROUSEL

    Example Usage:
    [tracks_carousel title="Recent Tracks" id="1" limit="6" visible_items="4" button_link="#"]

/* ---------------------------------------------------------------------- */
function spectra_tracks_carousel( $atts, $content = null ) {

    global $spectra_sid;

    extract(shortcode_atts(array(
        'title'              => '',
        'id'                 => 0,
        'visible_items'      => '3',
        'list_button'        => '0',
        'list_button_action' => 'sp-play-list',
        'track_action'       => 'sp-play-track',
        'button_link'        => '',
        'class'              => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }
    $spectra_sid++;
    $tracks_carousel = scamp_player_get_list( $id );

    $output .= '<div class="tracks-carousel-wrap">';
    if ( $title !== '' ) {
        $output .= '<h4 class="heading-m text-center tracks-carousel-heading">' . $title . '</h4>';
    }
    $output .= '<div id="tracks-carousel-id' . esc_attr( $spectra_sid ) . '" class="slider carousel-slider carousel-tracks-slider" data-effect="fade" data-pagination="true" data-nav="false" data-autoplay="false" data-items="' . $visible_items . '">';
    foreach ( $tracks_carousel as $track ) {
        if ( function_exists( 'spectra_get_image_id' ) &&  spectra_get_image_id( $track['cover'], 'full' ) ) {
            $track['cover'] = spectra_get_image_id( $track['cover'], 'full' );
        } else {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
            <div class="slide">
                    <a class="track thumb-desc ' .  esc_attr( $track_action ) . '" href="' .  esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                        <img class="track-cover" src="' . esc_attr( $track['cover'] ) . '" alt="' . esc_attr( __( 'Cover Image', SPECTRA_PLUGIN ) ) . '">
                        <div><div><i class="track-title">' . $track['title'] . '</i>  <span>' . $track['artists'] . '</span></div></div>
                    </a>';
        $output .= '</div>';
    }

    $output .= '</div>'; // carousel;

    if ( $button_link != '' ) {
        $output .= '<div class="text-center"><a class="btn medium more-posts" href="' . esc_url( $button_link ) . '">' . __( 'View More Releases', SPECTRA_PLUGIN ) . '</a></div>';
    }

    $output .= '</div>'; // wrap;

    

   return $output;
}
add_shortcode( 'tracks_carousel', 'spectra_tracks_carousel' );


/* ----------------------------------------------------------------------
    TRACKLIST

    Example Usage:
    [tracklist id="1" style="normal" list_button="0"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer). 
    style - normal, compact. Default: normal (string).
    list_button - 1,0. Default: 1 (string).
    list_button_action - sp-play-list, sp-add-list. Default: sp-play-list (string).
    track_action - sp-play-track, sp-add-track. Default: sp-play-track (string).

/* ---------------------------------------------------------------------- */
function spectra_tracklist( $atts, $content = null ) {

    global $spectra_sid;

    extract(shortcode_atts(array(
         'id'                 => 0,
         'style'              => 'normal',
         'list_button'        => '0',
         'list_button_action' => 'sp-play-list',
         'track_action'       => 'sp-play-track',
         'class'              => ''
    ), $atts));

    $output = '';

    if ( $style == 'compact' ) {
        $class .= $class . '  compact';
    }

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }
    $spectra_sid++;
    $tracklist = scamp_player_get_list( $id );

    $output .= '<ol id="tracklist-' . esc_attr( $spectra_sid ) . '" class="tracklist ' . esc_attr( $class ) . '">' ."\n";

    foreach ( $tracklist as $track ) {
        if ( function_exists( 'spectra_get_image_id' ) &&  spectra_get_image_id( $track['cover'], 'full' ) ) {
            $track['cover'] = spectra_get_image_id( $track['cover'], array( 90, 90 ) );
        } else {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
            <li>
                <div class="track-details">
                    
                    <a class="track ' .  esc_attr( $track_action ) . '" href="' . esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                        <img class="track-cover" src="' . esc_url( $track['cover'] ) . '" alt="' . esc_attr( __( 'Cover Image', SPECTRA_PLUGIN ) ) . '">
                        <span class="track-meta">
                            <span class="track-title">' . $track['title'] . '</span>
                            <span class="track-artists">' . $track['artists'] . '</span>
                        </span>
                    </a>';
        if ( $style == 'normal' ) {
            $output .= '<div class="track-buttons">' . $track['links'] . '</div>';
        }
        $output .= '</div></li>';
    }

    $output .= '</ol>' ."\n";

    if ( $list_button == '1' ) {
        $output .= '<a class="list-btn btn small ' . esc_attr( $list_button_action ) . '" data-id="tracklist-' . esc_attr( $spectra_sid ) . '" ><i class="icon icon-play2"></i>' . __( 'PLAY LIST', SPECTRA_PLUGIN ) . '</a>';
    }

   return $output;
}
add_shortcode( 'tracklist', 'spectra_tracklist' );


/* ----------------------------------------------------------------------
    SINGLE TRACK

    Example Usage:
    [track id="1" style="normal"]
    
    Attributes:
    id - Tracklist post id. Default: 0 (integer). 
    style - normal, compact. Default: normal (string) 
    track_action - sp-play-track, sp-add-track. Default: sp-play-track (string).
    class - Special classes. Default: null (string). 

/* ---------------------------------------------------------------------- */
function spectra_track( $atts, $content = null ) {

    global $spectra_sid;

    extract(shortcode_atts(array(
        'id'           => 0,
        'style'        => 'normal',
        'track_action' => 'sp-play-track',
        'class'        => ''
    ), $atts));

    $output = '';

    if ( $id == 0 || ! function_exists( 'scamp_player_get_list' ) || ! scamp_player_get_list( $id ) ) {
        return false;
    }
    $spectra_sid++;
    $track = scamp_player_get_list( $id );

    if ( $style == 'compact' ) {
        $class .= $class . '  compact';
    }

    foreach ( $track as $i => $track ) {
        if ( function_exists( 'spectra_get_image_id' ) &&  spectra_get_image_id( $track['cover'], 'full' ) ) {
            $track['cover'] = spectra_get_image_id( $track['cover'], array( 100, 100 ) );
        } else {
            $track['cover'] = get_template_directory_uri() . '/images/no-track-image.png';
        }
        $output .= '
            <div class="single-track ' . esc_attr( $class ) . '">
                <a href="' .  esc_url( $track['url'] ) . '" class="track ' .  esc_attr( $track_action ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '">
                    <img class="track-cover" src="' . esc_url( $track['cover'] ) . '" alt="' . esc_attr( __( 'Cover Image', SPECTRA_PLUGIN ) ) . '">
                    <span class="track-dot"></span>
                    <span class="track-meta">
                        <span class="track-title">' . $track['title'] . '</span>
                        <span class="track-artists">' . $track['artists'] . '</span>
                    </span>
                </a>';
        if ( $style == 'normal' ) {
            $output .= '<div class="track-buttons">' . $track['links'] . '</div>';
        }
        $output .= '</div>';
        if ( $i == 0 ) {
            break;
            return false;
        }
    }

   return $output;
}
add_shortcode( 'track', 'spectra_track' );


/* ----------------------------------------------------------------------
    SLIDER

    Example Usage:
    [slider id="1"]
    
    Attributes:
    id - Slider post id. Default: 0 (integer).

/* ---------------------------------------------------------------------- */
function spectra_slider( $atts, $content = null ) {

    global $spectra_sid;

    extract(shortcode_atts(array(
        'id'   => 0
    ), $atts));

    $output = '';

    if ( $id == 0 ) {
        return false;
    }
    $spectra_sid++;

    // Slider Settings

    // Slider navigation
    $slider_nav = get_post_meta( $id, '_slider_nav', true );
    if ( $slider_nav && $slider_nav === 'on' ) {
        $slider_nav = 'true';
    } else {
        $slider_nav = 'false';
    }

    // Slider pagination
    $slider_pagination = get_post_meta( $id, '_slider_pagination', true );
    if ( $slider_pagination && $slider_pagination === 'on' ) {
        $slider_pagination = 'true';
    } else {
        $slider_pagination = 'false';
    }

    // Slider speed
    $slider_speed = get_post_meta( $id, '_slider_speed', true );

    // Slider pause time
    $slider_pause_time = get_post_meta( $id, '_slider_pause_time', true );
    if ( ! $slider_pause_time && $slider_pause_time === '0' ) {
        $slider_pause_time = 'false';
    }
    
    $output .= '<div id="content-slider-id-' . esc_attr( $spectra_sid ) . '" class="content-slider carousel-slider clearfix" data-slider-nav="' . esc_attr( $slider_nav ) . '" data-slider-pagination="' . esc_attr( $slider_pagination ) . '" data-slider-speed="' . esc_attr( $slider_speed ) . '" data-slider-pause-time="' . esc_attr( $slider_pause_time ) . '">';

    /* Images ids */
    $images_ids = get_post_meta( $id, '_custom_slider', true );

    if ( ! $images_ids || $images_ids == '' ) {
         '<p class="message error">' . __( 'Slider error: Slider has no pictures or doesn\'t exists.', SPECTRA_PLUGIN ) . '</p>';
    }

    $count = 0;
    $ids = explode( '|', $images_ids );
    $defaults = array(
        'title'    => '',
        'subtitle' => '',
        'crop'     => 'c'
    );

    /* Start Loop */
    foreach ( $ids as $image_id ) {

        // Vars 
        $title = '';
        $subtitle = '';

        // Get image data
        $image_att = wp_get_attachment_image_src( $image_id );

        if ( ! $image_att[0] ) {
            continue;
        }
        
        /* Count */
        $count++;

        /* Get image meta */
        $image = get_post_meta( $id, '_custom_slider_' . $image_id, true );

        /* Add default values */
        if ( isset( $image ) && is_array( $image ) ) {
            $image = array_merge( $defaults, $image );
        } else { 
            $image = $defaults;
        }

        /* Add image src to array */
        $image['src'] = wp_get_attachment_url( $image_id );

        $output .= '<div class="slide">';

        if ( $image['title'] !== '' || $image['subtitle'] !== '' ) {
            $output .= '<div class="content-captions">';
                if ( $image['title'] !== '' ) {
                    $output .= '<span class="caption-title">' . $image['title'] . '</span>';
                }
                if ( $image['subtitle'] !== '' ) {
                    $output .= '<span class="caption-subtitle">' . $image['subtitle'] . '</span>';
                }
            $output .= '</div>';
        }
        $output .= '<div class="image"><img src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( __( 'Slider Image', SPECTRA_PLUGIN ) ) . '"></div>';

        $output .= '</div>';

    } // End foreach

    $output .= '</div>';

    return $output;
}
add_shortcode( 'slider', 'spectra_slider' );


/* ----------------------------------------------------------------------
    SOUNDCLOUD

    Example Usage:
    [vc_soundcloud id="1" height="200" params="auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&visual=true"]
    
    Attributes:
    url - track url
    height - player height
    width - player width
    params - soundcloud iframe params

/* ---------------------------------------------------------------------- */
function spectra_soundcloud($atts, $content=null) {
    
    extract(shortcode_atts(array(
        'url'    => '',
        'height' => '166',
        'width'  => '100%',
        'params' => '',
        'iframe' => 'false'
    ), $atts));
    
    if ($params != '') {
        str_replace("&", "&amp;", $params);
        $url = $url . '&amp;show_artwork=true&amp;' . $params;
    }
    if (empty($url)) return '<p>Soundcloud error: <strong>Invalid Track</strong></p>';
    
    if ($iframe == 'true') 
    $output = '<iframe width="100%" height="' . esc_attr( $height ) . '" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . esc_url( $url ) . '"></iframe>';
    return $output;
}
add_shortcode('soundcloud', 'spectra_soundcloud');


/* ----------------------------------------------------------------------
    DETAILS LIST

    Example Usage:
    [details_list]
        [detail label="Color" value="Orange"]
        [detail label="Color" value="Blue"]
        [detail label="Color" value="White"]
    [/details_list]
  

/* ---------------------------------------------------------------------- */

// List
function spectra_details_list( $atts, $content = null ) {
    
    return '<ul class="details-list">' . do_shortcode($content) . '</ul>';

}
add_shortcode( 'details_list', 'spectra_details_list' );

// Detail
function spectra_detail( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'label' => 'Color',
        'value' => 'White'
    ), $atts));

    return '<li><span>' . $label . '</span>' . $value . '</li>';

}
add_shortcode( 'detail', 'spectra_detail' );


/* ----------------------------------------------------------------------
    BUTTON

    Example Usage:
    [button link="#" text_color="#fff" bg_color="#666" title="Example Button Text" size="small" icon="" icon_size="14"]

/* ---------------------------------------------------------------------- */

// List
function spectra_buttons( $atts, $content = null ) {
    
    return '<div class="buttons">' . do_shortcode($content) . '</div>';

}
add_shortcode( 'buttons', 'spectra_buttons' );
function spectra_button( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'size'       => 'small',
        'title'      => 'Example Button Text',
        'link'       => '#',
        'target'     => '',
        'icon'       => '',
        'icon_size'  => '14',
        'text_color' => '#fff',
        'bg_color'   => '#666'
    ), $atts));

    if ( $target == '0' ) {
        $target = 'target="_blank"';
    }
    if ( $icon != '' ) {
        $icon = '<span style="font-size:' . $icon_size . 'px" class="icon icon-' . $icon . '"></span>';
    }

    return '<a class="btn ' . $size . '" href="' . $link . '" style="background-color:' . $bg_color . ';color:' . $text_color . '" ' . $target . '>' . $icon . $title . '</a>';

}
add_shortcode( 'button', 'spectra_button' );


/* ----------------------------------------------------------------------
    STATS

    Example Usage: 
    [stats timer="10000" stats="1876|gigs,1200|happy peoples,1266|releases,2356|coffees per year,1076|red buls per year,2009|year of creation,1887|glitch tracks,3238|vinyls,2432|dubstep tracks,1432|UK funky tracks,1234|Dub tracks,1238|countries"]

/* ---------------------------------------------------------------------- */

function spectra_stats( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'timer'         => '10000',
        'stats'          => ''
    ), $atts));

    $output = '';

    if ( $stats != '' ){

        $stats = explode( ',', $stats );
        if ( is_array( $stats) && count( $stats ) >= 6 ) {
            $output .= '<ul class="stats" data-timer="' . esc_attr( $timer ) . '">';
            foreach ( $stats as $stat ) {
                $output .= '<li>'; 
                $stat_a = explode( '|', $stat );
                if ( is_array( $stat_a) ) {
                    $output .= '<span class="stat-value">' . $stat_a[0] . '</span><span class="stat-name">' . $stat_a[1] . '</span>';
                }

                $output .= '</li>';
            }
            $output .= '</ul>';
        }
    }

    return $output;

}
add_shortcode( 'stats', 'spectra_stats' );



/* ----------------------------------------------------------------------
    PRICE TABLE

    Example Usage:

/* ---------------------------------------------------------------------- */

function spectra_pricing_column( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'title'         => '',
        'price'         => '0',
        'currency'      => '$',
        'period'        => '',
        'link'          => '#',
        'target'        => '_self',
        'button_text'   => 'Buy Now',
        'important'     => '',
        'list'          => '2x option 1,Free option 2,Unlimited option 3,Unlimited option 4,1x option 5'
    ), $atts));

    $output = '';
    $html_list = '';
    
    $output .= "<div class='price-table'>";
        
    if ( $important == "yes" ){
        $output .= "<div class='price-table-inner important-price'>";
    } else {
        $output .= "<div class='price-table-inner'>";
    }

    if ( $list != '' ){

        $list = explode( ',', $list );
        if ( is_array( $list) ) {
                $html_list .= '<ul>';
                foreach ( $list as $li ) {
                    $html_list .= '<li>' . $li . '</li>';
                }
                $html_list .= '</ul>';

        }
    }


    $output .= "<ul>";
    $output .= "<li class='prices'>";
    $output .= "<div class='price-wrapper'>";
    $output .= "<sup class='value'>" . $currency . "</sup>";
    $output .= "<span class='price'>" . $price . "</span>";
    $output .= "<sub class='mark'>" . $period . "</sub>";
    $output .= "</div>";
    $output .= "</li>"; // end prices
    $output .= "<li class='table-title'>" . $title . "</li>";
    
    $output .= '<li class="price-content-list">' . $html_list . '</li>'; 
    
    $output .= "<li class='price-button-wrapper'>";
    $output .= "<a class='btn medium' href='$link' target='$target'>" . $button_text . "</a>";
    $output .= "</li>"; // end button
    
    $output .= "</ul>";
    $output .= "</div>"; // end price-table-inner
    $output .="</div>"; // end price-table
    
    return $output;

}
add_shortcode( 'pricing_column', 'spectra_pricing_column' );


/* ----------------------------------------------------------------------
    ICON COLUMN

    Example Usage:
    [icon_column icon="" icon_place="icon_left"]..Text Here...[/icon_column]

/* ---------------------------------------------------------------------- */

function spectra_icon_column( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'title'      => '',
        'icon'       => '',
        'icon_place'  => 'icon_left'
    ), $atts));

    $output = '';

    if ( $icon != '' ) {
        $icon = '<span class="icon icon-' . esc_attr( $icon ) . '"></span>';
    }
     if ( $title != '' ) {
        $title = '<span class="icon_column_title">' . $title . '</span>';
    }

    $output .= '
        <div class="icon_column ' . esc_attr( $icon_place ) . '">
            ' . $icon . '
            <div class="text-holder">' . $title . do_shortcode( $content ) . '</div>
        </div>
    ';
    return $output;

}
add_shortcode( 'icon_column', 'spectra_icon_column' );


/* ----------------------------------------------------------------------
    EVENT COUNTDOWN

    Example Usage:
    [event_countdown event_id="0"]

/* ---------------------------------------------------------------------- */

function spectra_event_countdown( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'event_id'         => '0',
        'custom_event_id' => '0'
    ), $atts));
    
    $custom_event_id = (int)$custom_event_id;
    $event_id = (int)$event_id;
    global $post;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

    // Event type taxonomy
    $tax = array(
        array(
           'taxonomy' => 'spectra_event_type',
           'field' => 'slug',
           'terms' => 'future-events'
          )
    );

    $args = array(
        'post_type'        => 'spectra_events',
        'showposts'        => 1,
        'tax_query'        => $tax,
        'orderby'          => 'meta_value',
        'meta_key'         => '_event_date_start',
        'order'            => 'ASC',
        'suppress_filters' => 0 // WPML FIX
    );
     if ( $event_id ==! 0 ) {
        $event_id_a = array();
        $event_id_a[0] = $event_id;
        $args['post__in'] = $event_id_a;
    } else if ( $custom_event_id ==! 0 ) {
        $custom_event_id_a = array();
        $custom_event_id_a[0] = $custom_event_id;
        $args['post__in'] = $custom_event_id_a;
    }

    $events = get_posts( $args );
    $events_count = count( $events );

    if ( $events_count !== 0 ) {
        $event_id = $events[0]->ID;
    }

    $panel_options = get_option( 'spectra_panel_opts' );

    if ( $event_id == 0 ) {
        // $event_id = $future_event_id;
        return false;
    }
    $output = '';

    // Get event date and time
    $event_date = strtotime( get_post_meta( $event_id, '_event_date_start', true ) );
    $event_time = strtotime( get_post_meta( $event_id, '_event_time_start', true ) );

    // Date format
    $date_format = 'd/m/Y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    } else {
        $date_format = get_option('date_format');
    }

    // Location
    $event_location = get_post_meta( $event_id, '_event_address', true );

    $output .= '
        <div id="upcoming-event" class="event-countdown">
        <div class="container clearfix">
        <header class="content-header">
        <h6 class="upcoming-event anim-css" data-delay="0">' . date_i18n( $date_format, $event_date ) . '</h6>
        <h2 class="content-title anim-css" data-delay="100">' . get_the_title( $event_id ) . '</h2>
        <span class="sub-heading anim-css" data-delay="200">' . $event_location . '</span>
        </header>
        <div class="countdown" data-event-date="' . date_i18n( 'Y/m/d', $event_date ) . ' ' . date_i18n( 'H:i', $event_time ) . ':00">
        <div class="days anim-css" data-delay="0" data-label="' . esc_attr( __( 'Days', SPECTRA_PLUGIN ) ) . '">000</div>
        <div class="hours anim-css" data-delay="100" data-label="' . esc_attr( __( 'Hours', SPECTRA_PLUGIN ) ) . '">00</div>
        <div class="minutes anim-css" data-delay="200" data-label="' . esc_attr( __( 'Minutes', SPECTRA_PLUGIN ) ) . '">00</div>
        <div class="seconds anim-css" data-delay="300" data-label="' . esc_attr( __( 'Seconds', SPECTRA_PLUGIN ) ) . '">00</div>
        </div>
        </div>
        </div>
    ';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'event_countdown', 'spectra_event_countdown' );


/* ----------------------------------------------------------------------
    PORTFOLIO

    Example Usage:
    [portfolio filter="yes" limit="40" order="menu_order" categories_in=""]

/* ---------------------------------------------------------------------- */

function spectra_portfolio( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'filter'        => '0',
        'limit'         => '40',
        'order'         => 'menu_order',
        'categories_in' => ''
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'spectra_panel_opts' );

    // Date format
    $date_format = 'd/m/Y';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    } else {
        $date_format = get_option( 'date_format' );
    }

    $term_args = null;

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    if ( isset( $post ) ) { 
        $backup = $post;
    }

    // Filter
    if ( $filter === '1' ) {
        $output .= '
        <div id="portfolio-main-filter" class="filter">
        <ul class="filter-list item-filter active-filter clearfix">
        <li class="filter-label"><span class="label">' . esc_attr( __( 'Filter', SPECTRA_PLUGIN ) ) . '</span></li>
        <li><a data-categories="*">' . esc_attr( __( 'All', SPECTRA_PLUGIN ) ) . '</a></li>';
        
        $term_args = array( 'hide_empty' => '1', 'orderby' => 'name', 'order' => 'ASC' );
        $terms = get_terms( 'spectra_portfolio_cats', $term_args );
        if ( $terms ) {
            foreach ( $terms as $term ) {
                $output .= '<li><a data-categories="' . esc_attr( $term->slug ) . '">' . $term->name . '</a></li>';
            }
        }
        $output .= '</ul></div>';
    }

    // Grid
    $output .= '<div id="portfolio-items" class="fullwidth items clearfix">';

    // Loop Args.
    $term_args = null;
    $args = array(
                'post_type' => 'spectra_portfolio',
                'orderby'   => $order, // menu_order, date, title
                'order'     => 'ASC',
                'showposts' => $limit
            );


     /* Categories */
    if ( $categories_in != '' ) {
        $categories_in = explode( ',', $categories_in );
        $c = array();
        foreach ( $categories_in as $cat ) {
            array_push( $c, $cat );
        }
        if ( is_array( $c ) && ! empty( $c ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'spectra_portfolio_cats',
                    'field' => 'id',
                    'terms' => $c
                )
            );
        }
    }

    $portfolio_query = new WP_Query();
    $portfolio_query->query( $args );

    // begin Loop
    if ( $portfolio_query->have_posts() ) { 
        while ( $portfolio_query->have_posts() ) {
            $portfolio_query->the_post();

            // Thumb type 
            $thumb_type = get_post_meta( $portfolio_query->post->ID, '_thumb_type', true );

            // Tracks
            $tracks_id = get_post_meta( $portfolio_query->post->ID, '_tracks_id', true );
            $hidden_tracklist = '';
            if ( ! $tracks_id && $thumb_type === 'audio' ) {
                continue;
            }

            // Lightbox image 
            $lightbox_image = get_post_meta( $portfolio_query->post->ID, '_lightbox_image', true );

            // Thumb Iframe 
            $thumb_iframe = get_post_meta( $portfolio_query->post->ID, '_thumb_iframe', true );

            // Video Link
            $video_link = get_post_meta( $portfolio_query->post->ID, '_video_link', true );

            // Lightbox group 
            $lightbox_group = get_post_meta( $portfolio_query->post->ID, '_lightbox_group', true );

            // Badge 
            $badge = get_post_meta( $portfolio_query->post->ID, '_badge', true );

            // Custom link 
            $custom_link = get_post_meta( $portfolio_query->post->ID, '_link_url', true );

            // Link target attribute 
            $target = get_post_meta( $portfolio_query->post->ID, '_target', true );
            $target = isset( $target ) && $target == 'on' ? $target = '_blank' : $target = '';

            // Thumb subtitle
            $thumb_subtitle = get_post_meta( $portfolio_query->post->ID, '_thumb_subtitle', true );

            // Bulid genres 
            $post_terms = get_the_terms( get_the_ID(), 'spectra_portfolio_cats' );
            $filter_slugs = '';
            $filter_names = '';
            $term_count = 0;
            if ( $post_terms ) {
                $terms_count = count( $post_terms );
                foreach ( $post_terms as $term ) {
                    $term_count++;
                    if ( $term_count < $terms_count ) {
                        $filter_slugs .= $term->slug . ' ';
                        $filter_names .= $term->name . ' / ';
                    } else {
                        $filter_slugs .= $term->slug;
                        $filter_names .= $term->name;
                    }
                }
            }

            // Generate thumbnail link
            $thumb_link = 'href="' . esc_url( get_permalink() ) .'"';

            // Generate thumbnail class
            $thumb_class = 'thumb project-thumb frame-box';

            // Data attributes
            $thumb_attr = '';

            // Lightbox group
            if ( $lightbox_group !== '' ) {
                $thumb_attr = $thumb_attr . 'data-group="' . esc_attr( $lightbox_group ) . '"';
            }

            switch ( $thumb_type ) {

                // Image
                case 'image' :
                    $thumb_link = '';
                break;

                // Lightbox image
                case 'lightbox_image' :
                    $thumb_link = 'href="' . esc_url( $lightbox_image ) . '"';
                    $thumb_class = $thumb_class . ' imagebox';
                break;

                // Lightbox video
                case 'lightbox_video':
                    if ( isset( $video_link ) && $video_link !== '' ) {
                      
                        $thumb_link = 'href="' . esc_url( $video_link ) . '"';
                        $thumb_class = $thumb_class . ' videobox';
                        
                    }

                break;

                // Lightbox soundcloud
                case 'lightbox_soundcloud':
                    if ( isset( $thumb_iframe ) && $thumb_iframe !== '' ) {
                        $attr = array();
                        $attr = explode( '|', $thumb_iframe );
                        if ( isset( $attr ) && is_array( $attr) ) {

                            if ( $attr[1] == '100%' ) {
                                $attr[1] = 'auto';
                            }
                            $thumb_link = 'href="' . esc_url( str_replace('&','&amp;',$attr[0]) ) . '"';
                            $thumb_class = $thumb_class . ' mediabox';
                            $thumb_attr = $thumb_attr . ' data-width="' . esc_attr( $attr[1] ) . '" data-height="' . esc_attr( $attr[2] ) . '"';
                        }
                    }

                break;

                // Custom link
                case 'custom_link' :
                    $thumb_link = 'href="' . esc_url( $custom_link ) . '"';
                    if ( $target !== '' ) {
                        $thumb_attr = $thumb_attr . ' target="' . esc_attr( $target ) . '"';
                    }
                break;

                // Project link
                case 'project_link' :
                   $thumb_link = 'href="' . esc_url( get_permalink() ) . '"';
                break;

                // Audio
                case 'audio' :
                    
                    if ( function_exists( 'scamp_player_get_list' ) && scamp_player_get_list( $tracks_id ) ) {
                        $tracklist = scamp_player_get_list( $tracks_id );

                        // Single track
                        if ( count( $tracklist ) === 1 ){
                            $thumb_class = $thumb_class . ' sp-play-track';
                            $thumb_link = 'href="' . $tracklist[0]['url'] . '"';
                            if ( function_exists( 'spectra_get_image_id' ) &&  spectra_get_image_id( $tracklist[0]['cover'], 'full' ) ) {
                                $tracklist[0]['cover'] = spectra_get_image_id( $tracklist[0]['cover'], array( 90, 90 ) );
                            }
                            $thumb_attr = $thumb_attr . ' data-cover="' . esc_url( $tracklist[0]['cover'] ) . '" data-artist="' . esc_attr( $tracklist[0]['artists'] ) . '" data-artist_url="' . esc_url( $tracklist[0]['artists_url'] ) . '" data-artist_target="' . esc_attr( $tracklist[0]['artists_target'] ) . '" data-release_url="' . esc_url( $tracklist[0]['release_url'] ) . '" data-release_target="' . esc_attr( $tracklist[0]['release_target'] ) . '" data-shop_url="' . esc_url( $tracklist[0]['cart_url'] ) . '" data-shop_target="' . esc_attr( $tracklist[0]['cart_target'] ) . '" data-free_download="' . esc_attr( $tracklist[0]['free_download'] ) . '"';

                        // Tracks
                        } else {
                            $thumb_class = $thumb_class . ' sp-play-list';
                            $thumb_link = 'href="' . esc_url( get_permalink() ) . '"';
                            $thumb_attr = $thumb_attr . ' data-id="tracklist' . esc_attr( $post->ID ) . '"';

                            // Generate hidden list
                            $hidden_tracklist = '<ul id="tracklist' . esc_attr( $post->ID ) . '" class="hidden">'."\n";
                            foreach ( $tracklist as $track ) {
                                if ( function_exists( 'spectra_get_image_id' ) &&  spectra_get_image_id( $track['cover'], 'full' ) ) {
                                    $track['cover'] = spectra_get_image_id( $track['cover'], array( 90, 90 ) );
                                }
                                $hidden_tracklist .= '<li><a href="' . esc_url( $track['url'] ) . '" data-cover="' . esc_url( $track['cover'] ) . '" data-artist="' . esc_attr( $track['artists'] ) . '" data-artist_url="' . esc_url( $track['artists_url'] ) . '" data-artist_target="' . esc_attr( $track['artists_target'] ) . '" data-release_url="' . esc_url( $track['release_url'] ) . '" data-release_target="' . esc_attr( $track['release_target'] ) . '" data-shop_url="' . esc_url( $track['cart_url'] ) . '" data-shop_target="' . esc_attr( $track['cart_target'] ) . '" data-free_download="' . esc_attr( $track['free_download'] ) . '" class="sp-play-track">' . $track['title'] . '</a></li>' ."\n";
                            }
                            $hidden_tracklist .= '</ul>'."\n";
                        }

                    } else {
                        $thumb_link = 'href="' . esc_url( get_permalink() ) . '"';
                    }
                    
                break;
            }


            if ( has_post_thumbnail() ) {
                $output .= '<div class="item" data-categories="' . $filter_slugs . '">';
                $output .= '<a ' . $thumb_link . ' class="' . $thumb_class . '" ' . $thumb_attr . '>';
                $output .= '<div class="inner">';
                $output .= '<h6>' . get_the_title(); 
                        if ( $thumb_subtitle && $thumb_subtitle !== '' ) {
                            $output .= '<span>' . esc_attr( $thumb_subtitle ) . '</span>';
                        }
                $output .= '</h6></div>';
                $output .= '<img src="' . esc_url( wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) ) . '" alt="' . esc_attr( __( 'Porfolio thumbnail', SPECTRA_PLUGIN ) ) . '">';
                if ( $badge && $badge != 'none' ) {
                    switch ( $badge ) {

                        // New
                        case 'new' :
                            $output .= '<span class="badge new">' .  __( 'NEW', SPECTRA_PLUGIN ) . '</span>';
                        break;
                        // Free
                        case 'free' :
                            $output .= '<span class="badge free">' .  __( 'FREE', SPECTRA_PLUGIN ) . '</span>';
                        break;
                        // Custom
                        case 'custom' :
                            $badge_color = get_post_meta( $portfolio_query->post->ID, '_badge_color', true );
                            $badge_text = get_post_meta( $portfolio_query->post->ID, '_badge_text', true );
                            $output .= '<span class="badge" style="background-color:' . $badge_color . '">' . esc_attr( $badge_text ) . '</span>';
                        break;
                    } 

                }

                $output .= '</a>';
                $output .= $hidden_tracklist;
                $output .= '</div>'; // end .item
            }

        } // end loop
    } // end have_posts

    // End grid
    $output .= '</div>';
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'portfolio', 'spectra_portfolio' );



/* ----------------------------------------------------------------------
    GOOGLE MAPS

    Example Usage:
    [google_maps address="Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia" height="400" depth="15" zoom_control="true" scrollwhell="false"]

/* ---------------------------------------------------------------------- */
function spectra_google_maps($atts, $content = null) {
    global $r_option, $spectra_sid;
    
    extract(shortcode_atts(array(
        'height' => '400',
        'address' => 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia',
        'depth' => '15',
        'zoom_control' => 'true',
        'scrollwheel' => 'false'
    ), $atts));

    $output = '<div class="gmap-wrap">';
    $output .= '<div id="gmap_' . esc_attr( $spectra_sid ) . '" class="gmap" style="height:' . esc_attr( $height ) . 'px" data-address="' . esc_attr( $address ) . '" data-zoom="' . esc_attr( $depth ) . '" data-zoom_control="' . esc_attr( $zoom_control ) . '" data-scrollwhell="' . esc_attr( $scrollwheel ) . '">';
    $output .= '<p>' .  __( 'Please enable your JavaScript in your browser, to view our location.', SPECTRA_PLUGIN ) . '</p>';
    $output .= '</div>';
    $output .= '</div>';

    $spectra_sid++;
    
    return $output;
}
add_shortcode('google_maps', 'spectra_google_maps');


/* ----------------------------------------------------------------------
    EVENTS

    Example Usage:
    [events event_type="future-events" layout="mixed" limit="40" events_heading="1" featured_events="3"]

/* ---------------------------------------------------------------------- */

function spectra_events( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'event_type' => 'future-events',
        'limit'  => '40',
        'layout'  => 'mixed',
        'events_heading' => '0',
        'featured_events' => '3'
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'spectra_panel_opts' );

    $featured_events = (int)$featured_events;

    // Date format
    $date_format = 'd/m';
    if ( isset( $panel_options ) && isset( $panel_options[ 'event_date' ] ) ) {
        $date_format = $panel_options[ 'event_date' ];

    }

    // Date format
    $date_format = 'd/m';
    if ( isset( $panel_options ) && isset( $panel_options[ 'event_date' ] ) ) {
        $date_format = $panel_options[ 'event_date' ];
        if ( isset( $panel_options ) && isset( $panel_options[ 'event_time' ] ) && $panel_options[ 'event_time' ] != '' ) {
            $event_time = $panel_options[ 'event_time' ];
            $date_format = $date_format . ' ' . $event_time;
        }
   }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // Variables
    $events_count = 0;
    $count = 1;

    // post backup
    if ( isset( $post ) ) { 
        $backup = $post;
    }
    
    /* Set order */
    $order = $event_type == 'future-events' ? $order = 'ASC' : $order = 'DSC';

    // Event type taxonomy
    $tax = array(
        array(
           'taxonomy' => 'spectra_event_type',
           'field' => 'slug',
           'terms' => $event_type
          )
    );

    // Loop Args.
    $args = array(
        'post_type'        => 'spectra_events',
        'showposts'        => $limit,
        'tax_query'        => $tax,
        'orderby'          => 'meta_value',
        'meta_key'         => '_event_date_start',
        'order'            => $order,
        'suppress_filters' => 0 // WPML FIX
    );
    $events_query = new WP_Query();
    $events_query->query( $args );

    $events_count = get_posts( $args );
    $events_count = count( $events_count );

    if ( $layout === 'mixed' && $events_count <= $featured_events ) {
        $layout = 'list';
    }


    // Begin Loop
    if ( $events_query->have_posts() ) {
        if ( $layout === 'list' || $layout === 'mixed' ) {
            $output .= '<ul id="events-list-anim">';
        } else {
            $output .= '<div class="masonry-events">';
        }
        while ( $events_query->have_posts() ) {
            $events_query->the_post();
            
            // Custom link 
            $ticket_link = get_post_meta( $events_query->post->ID, '_ticket_url', true );

            // Link target attribute 
            $target = get_post_meta( $events_query->post->ID, '_ticket_target', true );
            $target = isset( $target ) && $target == 'on' ? $target = '_blank' : $target = '';

            /* Event Date */
            $event_time_start = get_post_meta( $events_query->post->ID, '_event_time_start', true );
            $event_date_start = get_post_meta( $events_query->post->ID, '_event_date_start', true );
            $event_date_start = $event_date_start . ' ' . $event_time_start;
            $event_date_start = strtotime( $event_date_start );
            $event_date_end = strtotime( get_post_meta( $events_query->post->ID, '_event_date_end', true ) );

            $event_date_end = strtotime( get_post_meta( $events_query->post->ID, '_event_date_end', true ) );

            /* Location */
            $event_location = get_post_meta( $events_query->post->ID, '_event_address', true );

             // Get Event Image
            $event_image = get_post_meta( $events_query->post->ID, '_event_image', true );
            $event_image_crop = get_post_meta( $events_query->post->ID, '_event_image_crop', true );
            $event_ID = $events_query->post->ID;
            if ( $event_image ) {
                $custom_css = 'style="background-image: url(' . wp_get_attachment_url( $event_image ) . ');"';
            } else {
                $custom_css = '';
            }
            
            // Layout
            if ( $layout === 'list' || $layout === 'mixed' ) {
                $output .= '<li id="event_' . esc_attr( get_the_id() ) . '" ' . $custom_css . '>';
                $output .= '<div class="inner">';
                $output .= '<span class="event-date">' . date_i18n( $date_format, $event_date_start ) . '</span>';
                $output .= '<h2><a href="' . esc_url( get_permalink() ) . '"> ' . get_the_title() . '</a></h2>';
                $output .= '<span class="event-location">' . $event_location . '</span>';
                $output .= '</div>';
                $output .= '</li>';
            } else {
                $output .= '<a href="' . esc_url( get_permalink() ) . '" class="event-brick">';
                $output .= '<span class="event-date">' . date_i18n( $date_format, $event_date_start ) . '</span>';
                $output .= '<span class="event-title">' . get_the_title() . '</span>';
                $output .= '<span class="event-location">' . $event_location . '</span>';
                $output .= '</a>';
            }

            // Only for mixed layout
            if ( $layout === 'mixed' && $count === $featured_events ) {
                $layout = 'bricks';
                $output .= '</ul>';
                if ( $events_count > $featured_events ) {
                    if ( $events_heading === '1' ) {
                        $output .= '<div class="events-separator">';
                        $output .= '<h6 class="heading-xl">' . __( 'More events', SPECTRA_PLUGIN ) . '</h6>';
                        $output .= '</div>';
                    }
                    $output .= '<div class="masonry-events">';
                }
            }
           $count++;

        } // end loop

        if ( $layout === 'list' ) {
            $output .= '</ul>';
        } else {
            $output .= '</div>';
        }
    
    } // end have_posts

    // End grid
    $output .= '<div class="clear"></div>';

    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'events', 'spectra_events' );


/* ----------------------------------------------------------------------
    EVENTS TABLE

    Example Usage:
    [events_table event_type="future-events" limit="40"]

/* ---------------------------------------------------------------------- */

function spectra_events_table( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'event_type' => 'future-events',
        'limit'  => '40'
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'spectra_panel_opts' );

    // Date format
    $date_format = 'd/m';
    if ( isset( $panel_options ) && isset( $panel_options[ 'event_date' ] ) ) {
        $date_format = $panel_options[ 'event_date' ];
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // post backup
    if ( isset( $post ) ) { 
        $backup = $post;
    }
    
    /* Set order */
    $order = $event_type == 'future-events' ? $order = 'ASC' : $order = 'DSC';

    // Event type taxonomy
    $tax = array(
        array(
           'taxonomy' => 'spectra_event_type',
           'field' => 'slug',
           'terms' => $event_type
          )
    );

    // Loop Args.
    $args = array(
        'post_type'        => 'spectra_events',
        'showposts'        => $limit,
        'tax_query'        => $tax,
        'orderby'          => 'meta_value',
        'meta_key'         => '_event_date_start',
        'order'            => $order,
        'suppress_filters' => 0 // WPML FIX
    );
    $events_query = new WP_Query();
    $events_query->query( $args );


    // Begin Loop
    if ( $events_query->have_posts() ) {
        
        $output .= '<table class="layout display responsive-table">
                    <thead>
                        <tr>
                            <th>' . __( 'Date', SPECTRA_PLUGIN ) . '</th>
                            <th colspan="2">' . __( 'Event', SPECTRA_PLUGIN ) . '</th>
                        </tr>
                    </thead>
                    <tbody>';

        while ( $events_query->have_posts() ) {
            $events_query->the_post();
            
            // Custom link 
            $ticket_link = get_post_meta( $events_query->post->ID, '_ticket_url', true );

            // Link target attribute 
            $target = get_post_meta( $events_query->post->ID, '_ticket_target', true );
            $target = isset( $target ) && $target == 'on' ? $target = 'target="_blank"' : $target = '';

            /* Event Date */
            $event_date_start = strtotime( get_post_meta( $events_query->post->ID, '_event_date_start', true ) );
            $event_date_end = strtotime( get_post_meta( $events_query->post->ID, '_event_date_end', true ) );

            /* Location */
            $event_location = get_post_meta( $events_query->post->ID, '_event_address', true );

            /* Ticket Link */
            if ( $ticket_link !== '' && $event_type === 'future-events' ) {
                $ticket_link = '<td class="actions"><a href="' . esc_url( $ticket_link ) . '" class="buy-tickets" ' . esc_attr( $target ) . '>' . __( 'Buy Tickets', SPECTRA_PLUGIN ) . '</a></td>';
            } else if ( $event_type === 'past-events' ) {
                $ticket_link = '';
            } else {
                $ticket_link = '<td class="actions"></td>';
            }

            $output .= '<tr>
                            <td class="table-date">' . date_i18n( $date_format, $event_date_start ) . '</td>
                            <td class="table-name">
                               <a href="' . esc_url( get_permalink() ) . '"> ' . get_the_title() . '</a>
                               <span class="event-location">' . $event_location . '</span>
                            </td>
                                ' . $ticket_link . '
                        </tr>';

        } // end loop

        $output .= '</tbody></table>';
    
    } // end have_posts


    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'events_table', 'spectra_events_table' );


/* ----------------------------------------------------------------------
    RECENT POSTS

    Example Usage:
    [recent_posts limit="4" title="" button_link=""]

/* ---------------------------------------------------------------------- */

function spectra_recent_posts( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'  => '4',
        'title' => '',
        'button_link' => '',
        'show_posts_thumbs' => ''
    ), $atts));
    
    global $wp_query, $post;

    $output = '';
    $panel_options = get_option( 'spectra_panel_opts' );

    // Date format
    $date_format = 'd/m';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // post backup
    if ( isset( $post ) ) { 
        $backup = $post;
    }
    
    // Loop Args.
    $args = array(
        'showposts'        => $limit
    );
    $recent_posts = new WP_Query();
    $recent_posts->query( $args );


    // Begin Loop
    if ( $recent_posts->have_posts() ) {
        
        $output .= '<div class="recent-posts-wrap">';
        if ( $title !== '' ) {
            $output .= '<h4 class="heading-m text-center recent-posts-heading">' . $title . '</h4>';
        }
        while ( $recent_posts->have_posts() ) {
            $recent_posts->the_post();
            $image_bg = '';
            $image_class = '';
            if ( has_post_thumbnail() && $show_posts_thumbs == '0' ) {
                $image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                if ( function_exists( 'mr_image_resize' ) ) {
                    $image_bg = mr_image_resize( $image_url, 420, 420, true, 'c', false );
                } else {
                    $image_bg = $image_url;
                }
                $image_bg = 'style="background-image:url(' . $image_bg . ')"';
                $image_class = 'front-post-thumb';
            }
            $output .= '
            <div class="recent-post">
                <div class="recent-post-content">
                    <div class="flip-container">
                        <div class="flipper">
                            <div class="front ' . $image_class . '" ' . $image_bg . '>
                                <div class="cell"><span class="date">' . get_the_time( $date_format ) . '</span><span class="post-title">' . get_the_title() . '</span></div>
                            </div>
                            <div class="back">
                                <div class="cell"><a href="' . esc_url( get_permalink() ) . '" class="readmore">' . __( 'Read more', SPECTRA_PLUGIN ) . '</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

        } // end loop
        if ( $button_link != '' ) {
            $output .= '<div class="text-center"><a class="btn medium more-posts" href="' . esc_url( $button_link ) . '">' . __( 'View More Posts', SPECTRA_PLUGIN ) . '</a></div>';
        }
        $output .= '</div>';
    
    } // end have_posts


    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'recent_posts', 'spectra_recent_posts' );


/* ----------------------------------------------------------------------
    POSTS CAROUSEL

    Example Usage:
    [posts_carousel limit="4" title="" button_link=""]

/* ---------------------------------------------------------------------- */

function spectra_posts_carousel( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'  => '4',
        'title' => '',
        'visible_items' => '3',
        'button_link' => '',
        'posts_in' => '',
        'categories_in' => '',
        'show_posts_date' => ''
    ), $atts));
    
    global $wp_query, $post, $spectra_sid;
    $spectra_sid++;

    $output = '';
    $panel_options = get_option( 'spectra_panel_opts' );

    // Date format
    $date_format = 'd/m';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // post backup
    if ( isset( $post ) ) { 
        $backup = $post;
    }
    
    // Loop Args.
    $args = array(
        'showposts' => $limit
    );

    /* Posts in */
    if ( $posts_in != '' ) {
        $args['post__in'] = explode( ',', $posts_in );
    }

    /* Categories */
    if ( $categories_in != '' ) {
        $categories_in = explode( ',', $categories_in );
        $c = array();
        foreach ( $categories_in as $cat ) {

            $cat_id = get_cat_ID( $cat );
            if ( $cat_id ) {
                array_push( $c, $cat_id );
            }
        }
        if ( is_array( $c ) && ! empty( $c ) ) {
            $args['cat'] = implode( ',', $c );
        }
    }

    $posts_carousel = new WP_Query();
    $posts_carousel->query( $args );

    // Begin Loop
    if ( $posts_carousel->have_posts() ) {
        
        $output .= '<div class="posts-carousel-wrap" >';
        if ( $title !== '' ) {
            $output .= '<h4 class="heading-m text-center posts-carousel-heading">' . $title . '</h4>';
        }
        $output .= '<div id="posts-carousel-id' . esc_attr( $spectra_sid ) . '" class="slider carousel-slider carousel-posts-slider" data-effect="fade" data-pagination="true" data-nav="false" data-autoplay="false" data-items="' . $visible_items . '">';
        while ( $posts_carousel->have_posts() ) {
            $posts_carousel->the_post();
            $image = '';
            $image_class = '';
            if ( has_post_thumbnail() ) {
                $image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                if ( function_exists( 'mr_image_resize' ) ) {
                    $image = mr_image_resize( $image_url, 420, 420, true, 'c', false );
                } else {
                    $image = $image_url;
                }
                $image = '<img src="' . esc_url( $image ) . '" alt="' . __( 'View Post Thumb', SPECTRA_PLUGIN ) . '">';
                $image_class = 'pc-post-thumb';
            } else {
                $image = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=" alt="' . __( 'View Post Thumb', SPECTRA_PLUGIN ) . '">';
            }
            $output .= '<div class="slide">';
            $output .= '<article class="carousel-post-content ' . esc_attr( $image_class ) . '">';
            $output .= '<a class="thumb thumb-desc" href="' . esc_url( get_permalink() ) . '">';
            $output .= $image;
            $output .= '<div><div>' . get_the_title() .'<span>';
            if ( $show_posts_date != '' ) {
                $output .= get_the_time( $date_format );
            }
            $output .= '</span></div></div>';
            $output .= '</a>';  
            $output .= '</article>';
            $output .= '</div>'; //slide;

        } // end loop
        $output .= '</div>'; //carousel;
        if ( $button_link != '' ) {
            $output .= '<div class="text-center"><a class="btn medium more-posts" href="' . esc_url( $button_link ) . '">' . __( 'View More Posts', SPECTRA_PLUGIN ) . '</a></div>';
        }
        $output .= '</div>'; //wrap;
    
    } // end have_posts


    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'posts_carousel', 'spectra_posts_carousel' );


/* ----------------------------------------------------------------------
    POSTS GRID

    Example Usage:
    [posts_grid limit="4" title="" button_link="" posts_in="" categories_in=""]

/* ---------------------------------------------------------------------- */

function spectra_posts_grid( $atts, $content = null ) {
    
    extract(shortcode_atts(array(
        'limit'  => '20',
        'title' => '',
        'button_link' => '',
        'posts_in' => '',
        'categories_in' => ''
    ), $atts));
    
    global $wp_query, $post, $spectra_sid;
    $spectra_sid++;

    /* Variables */
    $width = 400;
    $height = 224;

    $output = '';

    // Get panel options
    $panel_options = get_option( 'spectra_panel_opts' );

    // Disqus
    if ( ( isset( $panel_options[ 'disqus_comments' ] ) && $panel_options[ 'disqus_comments' ] == 'on' ) && ( isset( $panel_options[ 'disqus_shortname' ] ) && $panel_options[ 'disqus_shortname' ] != '' ) ) {
        $disqus = true;

    } else {
        $disqus = false;
    }

    // Date format
    $date_format = 'd/m';
    if ( isset( $panel_options ) && isset( $panel_options[ 'custom_date' ] ) ) {
        $date_format = $panel_options[ 'custom_date' ];
    }

    // Pagination Limit
    $limit = $limit && $limit == '' ? $limit = 6 : $limit = $limit;

    // Post backup
    if ( isset( $post ) ) { 
        $backup = $post;
    }
    
    // Loop Args.
    $args = array(
        'showposts' => $limit
    );

    /* Posts in */
    if ( $posts_in != '' ) {
        $args['post__in'] = explode( ',', $posts_in );
    }

    /* Categories */
    if ( $categories_in != '' ) {
        $categories_in = explode( ',', $categories_in );
        $c = array();
        foreach ( $categories_in as $cat ) {

            $cat_id = get_cat_ID( $cat );
            if ( $cat_id ) {
                array_push( $c, $cat_id );
            }
        }
        if ( is_array( $c ) && ! empty( $c ) ) {
            $args['cat'] = implode( ',', $c );
        }
    }

    $posts_grid = new WP_Query();
    $posts_grid->query( $args );

    // Begin Loop
    if ( $posts_grid->have_posts() ) {
        
        $output .= '<div class="posts-grid-wrap" >';
        if ( $title !== '' ) {
            $output .= '<h4 class="heading-m text-center posts-grid-heading">' . $title . '</h4>';
        }
        $output .= '<div class="blog-grid-items vc-blog-grid-items masonry">';
        while ( $posts_grid->have_posts() ) {
            $posts_grid->the_post();

            // Categories
            $category = get_the_category();
            $cat_tip = array();
            if ( count( $category ) > 1 ) {
                $cat = $category[0]->cat_name . '...';
                foreach ( $category as $c ) {
                    $cat_tip[] = $c->cat_name;
                }
            } else {
                $cat = $category[0]->cat_name;
                $cat_tip[] = $category[0]->cat_name;
            }
            $cat_tip = implode( ', ', $cat_tip );

            // Image URL
            $image_url = '';

            // Media
            $media = '';
            switch ( get_post_format() ) {
                case 'audio':
                    $post_format = get_post_meta( $posts_grid->post->ID, '_post_format', true );
                    if ( $post_format == 'pf_audio_sc' ) {
                        $sc_iframe = get_post_meta( $posts_grid->post->ID, '_sc_iframe', true );
                        if ( $sc_iframe && $sc_iframe !== '' && strpos( $sc_iframe, 'iframe' ) !== false ) {
                            $iframe_player = preg_replace('/height="\d+"/i', 'height="250"', $sc_iframe);
                            $iframe_player = str_replace( '&', '&amp;', $iframe_player );
                            $media .= $iframe_player;
                        }
                    } elseif ( $post_format == 'pf_audio' ) {

                        $pf_tracks_id = get_post_meta( $posts_grid->post->ID, '_pf_tracks_id', true );
                        if ( function_exists( 'spectra_tracklist' ) ) {
                            $media .= spectra_tracklist( $atts = array( 'id' => $pf_tracks_id, 'track_action' => 'sp-play-track', 'style' => 'compact' ) );
                        }

                    } elseif ( $post_format == 'pf_audio_single' ) {
                        $pf_tracks_id = get_post_meta( $posts_grid->post->ID, '_pf_tracks_id', true );
                        if ( function_exists( 'spectra_tracklist' ) ) {
                            $media .= spectra_track( $atts = array( 'id' => $pf_tracks_id, 'track_action' => 'sp-play-track', 'style' => 'compact' ) );
                        }

                    }

                    break;

                case 'video':
                    $video_yt_id = get_post_meta( $posts_grid->post->ID, '_video_yt_id', true );
                    $video_vimeo_id = get_post_meta( $posts_grid->post->ID, '_video_vimeo_id', true );
                    if ( $video_yt_id && $video_yt_id !== '' ) {
                        $media .= '<div class="video"><iframe src="https://www.youtube.com/embed/' . $video_yt_id . '" width="' . $width . '" height="' . $height . '" allowfullscreen></iframe></div>';
                    } else if ( $video_vimeo_id && $video_vimeo_id !== '' ) {
                        $media .= '<div class="video"><iframe src="https://player.vimeo.com/video/' . $video_vimeo_id . '" width="' . $width . '" height="' . $height . '" allowfullscreen></iframe></div>';
                    }

                    break;

                case 'gallery':

                    $gallery_slider_id = get_post_meta( $posts_grid->post->ID, '_gallery_slider_id', true );

                    if ( $gallery_slider_id && $gallery_slider_id !== 'none' ) {
                        if ( function_exists( 'spectra_slider' ) ) {
                            $media .= spectra_slider( array( 'id' => $gallery_slider_id ) );
                        }
                    }
                    break;

                case 'image':
                    if ( has_post_thumbnail() ) {
                        $image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                        if ( function_exists( 'mr_image_resize' ) ) {
                            $media .= '<img src=" '. mr_image_resize( $image_url, $width, $height, true, 'c', false ) . '" alt="' . esc_attr( __( 'Post Image', SPECTRA_PLUGIN ) ) . '">';
                        } else {
                            $media .= '<img src=" '. $image_url . '" alt="' . esc_attr( __( 'Post Image', SPECTRA_PLUGIN ) ) . '">';
                        }
                    }
                    break;
                
                default:
                    break;
            }

            $output .= '<article class="col-1-3 masonry-item" >';
            $output .= '<div class="entry-grid-media">' . $media . '</div>';
            $output .= '<div class="entry-grid-content">';
            $output .= '<h2 class="entry-grid-title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h2>';
            $output .= '<div class="entry-grid-meta">';
            $output .= '<span class="entry-grid-date">' . get_the_time( $date_format ) . '</span><span class="entry-grid-cat"><abbr title="<em>' . esc_html( $cat_tip ) .'</em>" class="tooltip">' . $cat . '</abbr></span>';
            $num_comments = get_comments_number();
            if ( comments_open() || $num_comments ) {
                $output .= '<span class="entry-grid-comments"><a href="' . esc_url( get_permalink() ) . '#comments" data-offset="-65">';
                if ( $disqus ) { 
                    $output .=  __( 'Comments', SPECTRA_PLUGIN );
                } else {
                    if ( $num_comments == 0 ) $output .= __( 'No comment', SPECTRA_PLUGIN );
                    else if ( $num_comments > 1 ) $output .= $num_comments . ' ' . __( 'Comments', SPECTRA_PLUGIN );
                    else $output .= $num_comments . ' ' . __( 'Comment', SPECTRA_PLUGIN );
                }
                $output .= '</a></span>';
            }
            $output .= '</div>'; // grid meta

            if ( has_excerpt() ) {
                $output .= '<div class="entry-grid-excerpt">';
                $output .= get_the_excerpt();
                $output .= '</div>';
                $output .= '<a href="' . esc_url( get_permalink() ) . '" class="btn small">' . __( 'Read more', SPECTRA_PLUGIN ) . '</a>';
            } else {
                $output .= get_the_content( __( 'Continue reading ', SPECTRA_PLUGIN ) . '<span class="meta-nav">&rarr;</span>' );

            }
            $output .= '</div>';
            $output .= '</article>';

        } // end loop
        $output .= '</div>'; //grid;
        if ( $button_link != '' ) {
            $output .= '<div class="text-center"><a class="btn medium more-posts" href="' . esc_url( $button_link ) . '">' . __( 'View More Posts', SPECTRA_PLUGIN ) . '</a></div>';
        }
        $output .= '</div>'; //wrap;
    
    } // end have_posts


    if ( isset( $post ) ) {
        $post = $backup;
    }
    return $output;

}
add_shortcode( 'posts_grid', 'spectra_posts_grid' );