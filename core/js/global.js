function add_to_admin_bar( button_text, link ){
	
	var output = '';
	
	output += '<a href="' + link + '" target="_blank" class="button">';
		output += button_text;
	output += '</a>';
	
	$( '#admin_bar .admin-bar-items' ).append( output );
	
	return;
	
}


var browser_url_iterator = 0;


function change_browser_url( url, title ){
	
	if( typeof title == 'undefined' ){
		title = document.title;
	}
	
	browser_url_iterator++;
	
	document.title = title;
	
	window.history.pushState( 'ews_page_' + browser_url_iterator, title, url );
	
	return;
	
}


function html_entities( str ){
    return String( str )
		.replace( /&/g, '&amp;' )
		.replace( /</g, '&lt;' )
		.replace( />/g, '&gt;' )
		.replace( /"/g, '&quot;' );
}


function number_format( number, decimals, dec_point, thousands_sep ){
	
	if( typeof dec_point === 'undefined' ){
		dec_point = '.';
	}
	
	if( typeof thousands_sep === 'undefined' ){
		thousands_sep = ',';
	}
	
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs( decimals ),
        sep = ( typeof thousands_sep === 'undefined' ) ? ',' : thousands_sep,
        dec = ( typeof dec_point === 'undefined' ) ? '.' : dec_point,
        s = '',
        toFixedFix = function( n, prec ){
            var k = Math.pow( 10, prec );
            return '' + Math.round(n * k) / k;
        };
    
    s = ( prec ? toFixedFix(n, prec) : '' + Math.round(n) ).split( '.' );
	
    if( s[0].length > 3 ){
        s[0] = s[0].replace( /\B(?=(?:\d{3})+(?!\d))/g, sep );
    }
	
    if( (s[1] || '').length < prec ){
        s[1] = s[1] || '';
        s[1] += new Array( prec - s[1].length + 1 ).join( '0' );
    }
	
    return s.join( dec );
	
}


function pluralize( value, singular, plural, format, precision ){
	
	if( typeof plural === 'undefined' ){
		plural = singular + 's';
	}
	
	if( typeof format === 'undefined' ){
		format = true;
	}
	
	if( typeof precision === 'undefined' ){
		precision = 0;
	}
	
	var descriptor 	= plural;
	var amount 		= value;
	
	if( (value == 1) || (value == -1) ){
		descriptor = singular;
	}
	
	if( format ){
		amount = number_format( amount, precision );
	}
	
	return amount + ' ' + descriptor;
	
}


function strip_tags( string ){
	string = string.replace( /(<([^>]+)>)/gi, '' );
	return string;
}