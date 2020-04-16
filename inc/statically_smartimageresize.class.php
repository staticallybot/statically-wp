<?php

/**
 * Statically_SmartImageResize
 *
 * @since 0.5.0
 */

class Statically_SmartImageResize
{

    /**
     * smart resize for post thumbnail
     * 
     * @since 0.5.0
     */
    public function smartresize_thumbnail($image) {
      $options = Statically::get_options( 'statically' );
      $cdn_url = str_replace( '/sites', '/img', $options['url'] );

      if ( Statically::is_custom_domain() ) {
          $cdn_url = $options['url'] . '/statically/img';
      }
  
      if ( $image[3] ) {
          $img_size = sprintf( '-%dx%d', $image[1], $image[2] );
          $img_url  = str_replace( $img_size, '', $image[0] );
      } else {
          $img_url  = str_replace( get_option( 'home' ), '', $image[0] );
      }

      // resizer start
      $tf = '/';

      // if image auto-webp is ON
      if ( $options['webp'] ) {
          $tf .= 'f=auto';
      }

      $tf .= '%2Cw=' . $image[1] . '%2Ch='. $image[2];

      // if image quality is ON
      if ( $options['quality'] ) {
          $tf .= '%2Cq=' . $options['quality'];
      }

      // if everything are set except webp
      if ( 0 === $options['webp'] && $options['quality'] ) {
          $tf = substr( $tf, strpos( $tf, '%2C' ) + 3 );
          $tf = '/' . $tf;
      }
  
      $image[0] = $cdn_url . $tf . $img_url;
  
      return $image;
  }
}