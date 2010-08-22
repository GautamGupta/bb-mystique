<?php

/* bb Mystique */

function mystique_subscribe_rss() {
  return '<a class="button rss-subscribe" href="' . get_bloginfo( 'rss2_url' ) . '" title="' . __( 'RSS Feeds','bb-mystique' ) . '">' . __( 'RSS Feeds','bb-mystique' ) . '</a>';
}

function mystique_go_to_top() {
  return sprintf( '<a id="goTop" class="button js-link">' .__( 'Top','bb-mystique' ) . '</a>' );
}

function mystique_credit() {
  return sprintf(__( '%1$s theme by %2$s | Powered by %3$s', 'bb-mystique' ), '<abbr title="' .THEME_NAME. ' ' .THEME_VERSION. '">bb Mystique</abbr>','<a href="http://digitalnature.ro">digitalnature</a>', '<a href="http://wordpress.org/">WordPress</a>' );
}

function mystique_copyright() {
	return sprintf( '<span class="copyright"><span class="text">%1$s</span> <span class="the-year">%2$s</span> <a class="blog-title" href="%3$s" title="%4$s">%4$s</a></span>',
			__( 'Copyright &copy;', 'bb-mystique' ),
			date( 'Y' ),
			bb_get_uri(),
			bb_get_option( 'name' )
		);
}


function mystique_bb_link() {
  return '<a class="wp-link" href="http://WordPress.org/" title="WordPress" rel="generator">WordPress</a>';
}

// blog title
function mystique_blog_title() {
  return '<span class="blog-title">' . get_bloginfo( 'name' ) . '</span>';
}

// validate xhtml
function mystique_validate_xhtml() {
  return '<a class="button valid-xhtml" href="http://validator.w3.org/check?uri=referer" title="Valid XHTML">XHTML 1.1</a>';
}

// validate css
function mystique_validate_css() {
  return '<a class="button valid-css" href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" title="Valid CSS">CSS 3.0</a>';
}



//    Google Toolbar 3.0.x/4.0.x Pagerank Checksum Algorithm
//    Author's webpage:
//    http://pagerank.gamesaga.net/
function mystique_pagerank( $atts) {
  function CheckHash( $Hashnum) {
    $CheckByte = 0;
    $Flag = 0;
    $HashStr = sprintf( '%u', $Hashnum) ;
    $length = strlen( $HashStr);
    for ( $i = $length - 1;  $i >= 0;  $i --) {
      $Re = $HashStr{$i};
      if (1 === ( $Flag % 2) ) {
        $Re += $Re;
        $Re = (int)( $Re / 10) + ( $Re % 10);
      }
      $CheckByte += $Re;
      $Flag ++;
    }

    $CheckByte %= 10;
    if (0 !== $CheckByte) {
      $CheckByte = 10 - $CheckByte;
      if (1 === ( $Flag % 2) ) {
       if (1 === ( $CheckByte % 2) ) {
        $CheckByte += 9;
       }
       $CheckByte >>= 1;
      }
     }
    return '7' . $CheckByte. $HashStr;
  }

  function HashURL( $String) {
    function StrToNum( $Str, $Check, $Magic) {
      $Int32Unit = 4294967296;  // 2^32
      $length = strlen( $Str);
      for ( $i = 0; $i < $length; $i++) {
        $Check *= $Magic;
        //If the float is beyond the boundaries of integer (usually +/- 2.15e+9 = 2^31),
        //  the result of converting to integer is undefined
        //  refer to http://www.php.net/manual/en/language.types.integer.php
        if ( $Check >= $Int32Unit) {
          $Check = ( $Check - $Int32Unit * (int) ( $Check / $Int32Unit) );
          //if the check less than -2^31
          $Check = ( $Check < -2147483648) ? ( $Check + $Int32Unit) : $Check;
        }
        $Check += ord( $Str{$i});
      }
      return $Check;
    }
    $Check1 = StrToNum( $String, 0x1505, 0x21);
    $Check2 = StrToNum( $String, 0, 0x1003F);

    $Check1 >>= 2;
    $Check1 = (( $Check1 >> 4) & 0x3FFFFC0 ) | ( $Check1 & 0x3F);
    $Check1 = (( $Check1 >> 4) & 0x3FFC00 ) | ( $Check1 & 0x3FF);
    $Check1 = (( $Check1 >> 4) & 0x3C000 ) | ( $Check1 & 0x3FFF);

    $T1 = (((( $Check1 & 0x3C0) << 4) | ( $Check1 & 0x3C) ) <<2 ) | ( $Check2 & 0xF0F );
    $T2 = (((( $Check1 & 0xFFFFC000) << 4) | ( $Check1 & 0x3C00) ) << 0xA) | ( $Check2 & 0xF0F0000 );

    return ( $T1 | $T2);
  }

  extract(shortcode_atts(array( 'url' => get_bloginfo( 'url' ) ), $atts) );
  $pagerank = 0;
  if (false === ( $pagerank = get_transient( 'pr_'+md5( $url) )) ):
    $query="http://toolbarqueries.google.com/search?client=navclient-auto&ch=".CheckHash(HashURL( $url) ) . "&features=Rank&q=info:". $url."&num=100&filter=0";
    $request = new WP_Http;
    $result = $request->request( $query);
    $pos = strpos( $result['body'], "Rank_");
    if( $pos === false); else $pagerank = substr( $result['body'], $pos + 9);
    set_transient( 'pr_'+md5( $url), $pagerank, 60*60*24); // 24 hours
  endif;

  $output = '<div class="pagerank button" title="Google PageRank &trade;">';
  $output.= sprintf(__("PR %s","mystique"), $pagerank);
  $output.= '<div class="pagerank-frame">';
  $output.= '<div class="pagerank-bar" style="width:' .(((int)$pagerank/10)*100) . '%"></div>';
  $output.= '</div></div>';
  return $output;

}


add_shortcode( 'rss', 'mystique_subscribe_rss' );
add_shortcode( 'top', 'mystique_go_to_top' );
add_shortcode( 'credit', 'mystique_credit' );
add_shortcode( 'copyright', 'mystique_copyright' );
add_shortcode( 'bb-link', 'mystique_bb_link' );
add_shortcode( 'login-link', 'mystique_login_link' );
add_shortcode( 'blog-title', 'mystique_blog_title' );
add_shortcode( 'xhtml', 'mystique_validate_xhtml' );
add_shortcode( 'css', 'mystique_validate_css' );
add_shortcode( 'page-rank', 'mystique_pagerank' );
?>
