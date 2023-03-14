
class Lightbox {
	
	
	constructor(){
		
		var self = this;

		self.state 		= false;
		
		self.config = {
			close_icon: 'fas fa-times'
		};
		
		self.reset();
		self.build_ui();
		self.attach_bindings();
		
	}
	
	
	attach_bindings(){
		
		var self = this;
		
		$( document ).ready( function(){
			
			$( document ).keyup( self, function(e){
				
				if( e.keyCode == 27 ){
					e.preventDefault();
					return e.data.close();
				}
				
			});
			
			$( 'body' ).on( 'click', '#lightbox .close', self, function(e){
				e.preventDefault();
				return e.data.close();
			});
			
			$( 'body' ).on( 'click', 'a.lightbox', self, function(e){
				e.preventDefault();
				e.data.parse( $(this) );
				return e.data.open();
			});
			
		});
		
		return self;
		
	}
	
	
	build_ui(){
		
		var self = this;
		
		$( document ).ready( function(){
		
			var content = '';

			content += '<div id="lightbox">';
				content += '<div class="close"><i class="' + self.config['close_icon'] + '"></i></div>';
				content += '<div class="content"></div>';
				content += '<div class="caption"></div>';
			content += '</div>';

			$( 'body' ).append( content );
			
		});
		
		return self;
		
	}
	
	
	close(){
		
		var self = this;
		
		if( self.state ){
			$( 'body' ).css( 'overflow', 'auto' );
			$( '#lightbox' ).fadeOut( 'fast', function(){
				self.state = false;
				self.reset( true );
			});
		}
		
		return false;
		
	}
	
	
	open(){
		
		var self = this;
		
		if( !self.state ){
			
			var content;
			
			if( self.type == 'image' ){
				
				content = '';
				content += '<img src="' + self.source + '">';
				
				$( '#lightbox .content' ).html( content );
				
			} else if( self.type == 'video' ){
				
				content = '';
				content += '<div class="video">';
					content += '<video controls autoplay src="' + self.source + '"></video>';
				content += '</div>';
				
				$( '#lightbox .content' ).html( content );
				
			} else if( self.type == 'youtube' ){
				
				content = '';
				content += '<div class="video">';
					content += '<iframe';
						content += ' width="100%"';
						content += ' height="100%"';
						content += ' src="https://www.youtube.com/embed/' + self.source + '?autoplay=true"';
						content += ' frameborder="0"';
						content += ' allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen';
					content += '></iframe>';
				content += '</div>';
				
				$( '#lightbox .content' ).html( content );
				
			}
			
			if( self.caption ){
				$( '#lightbox .caption' ).html( self.caption );
			}
			
			$( 'body' ).css( 'overflow', 'hidden' );
			
			$( '#lightbox' ).fadeIn( 'fast', function(){
				self.state = true;
			});
			
		}
		
		return false;
		
	}
	
	
	parse( element ){
		
		var self = this;
		
		self.source = element.attr( 'href' );
		
		if( typeof element.data('type') != 'undefined' ){
			self.type = element.data( 'type' );
		}
		
		if( typeof element.data('group') != 'undefined' ){
			self.group = element.data( 'group' );
		}
		
		if( typeof element.attr('title') != 'undefined' ){
			self.caption = element.attr( 'title' );
		}
		
		if( typeof element.attr('alt') != 'undefined' ){
			self.caption = element.attr( 'alt' );
		}
		
		if( typeof element.data('title') != 'undefined' ){
			self.caption = element.data( 'title' );
		}
		
		if( typeof element.data('caption') != 'undefined' ){
			self.caption = element.data( 'caption' );
		}
		
		self.detect_media();
		
		return self;
		
	}
	
	
	detect_media(){
		
		var self = this;
		var test = String( self.source );
		var parts;
		
		if( test.indexOf('youtube.com') >= 0 ){
			
			self.type = 'youtube';
			
			parts = test.split( 'watch?v=' );
			parts = parts[1];
			parts = parts.split( '&' );
			parts = parts[0];
			
			self.source = parts;
			
		}
		
		if( test.indexOf('youtu.be') >= 0 ){
			
			self.type = 'youtube';
			
			parts = test.split( '.be/' );
			parts = parts[1];
			parts = parts.split( '?' );
			parts = parts[0];
			
			self.source = parts;
			
		}
		
		return self;
		
	}
	
	
	reset( content ){
		
		var self = this;
		
		if( typeof content == 'undefined' ){
			content = false;
		}
		
		self.caption	= false;
		self.group		= false;
		self.list		= [];
		self.position	= 0;
		self.source		= false;
		self.type		= 'image';
		
		if( content ){
			$( '#lightbox .content' ).html( '' );
			$( '#lightbox .caption' ).html( '' );
		}
		
		return self;
		
	}
	
	
}


var lightbox = new Lightbox();
