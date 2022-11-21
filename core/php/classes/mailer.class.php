<?


	require_once BASE_DIR.'/core/external/phpmailer/PHPMailerAutoload.php';


	class Mailer {
		
		
		private $attachments;
		private $bcc;
		private $cc;
		private $config;
		private $debug;
		private $from;
		private $mailer;
		private $message;
		private $plaintext;
		private $reply_to;
		private $subject;
		private $template;
		private $to;
		private $variables;
		
		
		public function __construct(){
			
			$this->config = array(
				'smtp' 			=> false,
				'host'			=> false,
				'encryption' 	=> 'tls',
				'port'			=> 587,
				'username'		=> false,
				'password'		=> false,
			);
			
			$this->clear();
			
		}
		
		
		public function attachment( $path = false, $filename = false, $clear = false ){
			
			if( $clear ){
				$this->attachments = array();
			}
			
			if( $path ){
			
				if( !$filename ){
					$parts 		= explode( '/', $path );
					$filename 	= end( $parts );
				}

				if( file_exists($path) ){
					$this->attachments[] = array(
						'path' 		=> $path,
						'filename' 	=> $filename,
					);
				}
				
			}
			
			return $this;
			
		}
		
		
		public function bcc( $email = false, $name = false, $clear = false ){
			
			if( $clear ){
				$this->to = array();
			}
			
			if( $email ){
				$this->bcc[] = array(
					'email' => $email,
					'name' 	=> $name
				);
			}
			
			return $this;
		
		}
		
		
		public function cc( $email = false, $name = false, $clear = false ){
			
			if( $clear ){
				$this->to = array();
			}
			
			if( $email ){
				$this->cc[] = array(
					'email' => $email,
					'name' 	=> $name
				);
			}
			
			return $this;
		
		}
		
		
		public function clear(){
			
			$this->attachments 	= array();
			$this->bcc			= array();
			$this->cc			= array();
			$this->from			= false;
			$this->mailer		= false;
			$this->message		= '';
			$this->plaintext	= false;
			$this->reply_to		= false;
			$this->subject		= '';
			$this->to			= array();
			$this->variables	= array();
			
			return $this;
			
		}
		
		
		public function config( $key, $value ){
			
			if( !array_key_exists($key, $this->config) ){
				return $this;
			}
			
			$this->config[$key] = $value;
			
			return $this;
			
		}
		
		
		public function debug( $bool ){
			$this->debug = $bool;
			return $this;
		}
		
		
		public function from( $email, $name = false ){
			
			$this->from = array(
				'email' => $email,
				'name' 	=> $name
			);
			
			return $this;
			
		}
		
		
		private function mailer(){
			
			$this->mailer = new PHPMailer;
			
			if( $this->config['smtp'] ){
				$this->mailer->isSMTP();
				$this->mailer->CharSet 		= 'UTF-8';
				$this->mailer->Host         = $this->config['host'];
				$this->mailer->SMTPAuth     = true;
				$this->mailer->SMTPSecure   = $this->config['encryption'];
				$this->mailer->Port         = $this->config['port'];
				$this->mailer->Username     = $this->config['username'];
				$this->mailer->Password     = $this->config['password'];
			}
			
			return $this;
			
		}
		
		
		public function message( $message ){
			$this->message = $message;
			return $this;
		}
		
		
		public function plaintext( $message ){
			$this->plaintext = $message;
			return $this;
		}
		
		
		private function parse(){
			
			if( !$this->plaintext ){
				$this->plaintext 	= $this->message;
				$this->plaintext 	= str_replace( "\n", '', $this->plaintext );
				$this->plaintext 	= str_replace( '</div>', "\n", $this->plaintext );
				$this->plaintext 	= str_replace( '</p>', "\n"."\n", $this->plaintext );
				$this->plaintext 	= str_replace( '<br>', "\n", $this->plaintext );
				$this->plaintext 	= str_replace( '</br>', "\n", $this->plaintext );
				$this->plaintext 	= str_replace( '<br/>', "\n", $this->plaintext );
				$this->plaintext 	= str_replace( '<br />', "\n", $this->plaintext );
				$this->plaintext 	= strip_tags( $this->plaintext );
			}
			
			if( is_array($this->variables) ){
				foreach( $this->variables as $k => $v ){
					$this->message 		= str_replace( $k, $v, $this->message );
					$this->plaintext 	= str_replace( $k, $v, $this->plaintext );
					$this->subject 		= str_replace( $k, $v, $this->subject );
				}
			}
			
			preg_match_all( "/\{(.*?)\}/", $this->message, $output );
			foreach( $output[0] as $instance ){
				$this->message = str_replace( $instance, '', $this->message );
			}
			
			preg_match_all( "/\{(.*?)\}/", $this->plaintext, $output );
			foreach( $output[0] as $instance ){
				$this->plaintext = str_replace( $instance, '', $this->plaintext );
			}
			
			preg_match_all( "/\{(.*?)\}/", $this->subject, $output );
			foreach( $output[0] as $instance ){
				$this->subject = str_replace( $instance, '', $this->subject );
			}
			
			return $this;
			
		}
		
		
		public function reply_to( $email, $name = false ){
			
			$this->reply_to = array(
				'email' => $email,
				'name' 	=> $name
			);
			
			return $this;
			
		}
		
		
		public function send(){
			
			$this->parse();
			$this->mailer();
			
			if( $this->debug ){
				$this->mailer->SMTPDebug = 3;
			}
			
			$this->mailer->isHTML( true );
			$this->mailer->Subject 	= $this->subject;
			$this->mailer->Body		= $this->message;
			$this->mailer->AltBody	= $this->plaintext;
			
			if( count($this->attachments) > 0 ){
				foreach( $this->attachments as $v ){
					$this->mailer->addAttachment( $v['path'], $v['filename'] );
				}
			}
			
			if( count($this->bcc) > 0 ){
				foreach( $this->bcc as $v ){
					$this->mailer->addBCC( $v['email'], $v['name'] );
				}
			}
			
			if( count($this->cc) > 0 ){
				foreach( $this->cc as $v ){
					$this->mailer->addCC( $v['email'], $v['name'] );
				}
			}
			
			if( count($this->from) > 0 ){
				$this->mailer->setFrom( $this->from['email'], $this->from['name'] );
			}
			
			if( $this->reply_to ){
				$this->mailer->addReplyTo( $this->reply_to['email'], $this->reply_to['name'] );
			}
			
			if( count($this->to) > 0 ){
				foreach( $this->to as $v ){
					$this->mailer->addAddress( $v['email'], $v['name'] );
				}
			}
			
			$status	= $this->mailer->send();
			$error 	= $this->mailer->ErrorInfo;
			
			$output = array(
				'result' 		=> true,
				'from'			=> $this->from,
				'to'			=> $this->to,
				'cc'			=> $this->cc,
				'bcc'			=> $this->bcc,
				'reply_to'		=> $this->reply_to,
				'subject'		=> $this->subject,
				'message'		=> $this->message,
				'plaintext'		=> $this->plaintext,
				'attachments'	=> $this->attachments,
			);
			
			if( !$status ){
				$output = array(
					'result' 	=> false,
					'error'		=> $error,
				);
			}
			
			return $output;
			
		}
		
		
		public function subject( $subject ){
			$this->subject = $subject;
			return $this;
		}
		
		
		public function to( $email = false, $name = false, $clear = false ){
			
			if( $clear ){
				$this->to = array();
			}
			
			if( $email ){
				$this->to[] = array(
					'email' => $email,
					'name' 	=> $name
				);
			}
			
			return $this;
		
		}
		
		
		public function variable( $key, $value ){
			
			if( substr($key, 0, 1) != '{' ){ $key = '{'.$key; }
			if( substr($key, -1) != '}' ){ $key .= '}'; }
			
			$this->variables[$key] = $value;
			
			return $this;
			
		}
		
		
		
	}

