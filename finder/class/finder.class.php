<?php

	/**
     * Finder
     * 
     * Busca un "string" dentro de los archivos del directorio y sus correspondiente
     * subdirectorio.  By default, buscar en archivos de extensión: HTML, PHP, CSS, JS 
     * pero puede personsalizarlo 
     * 
     * 
     * @link    https://github.com/LVWRZ/finder
     * @author  Fernando Giorgetta <fernando@giorgetta.es>

     * @example
     * <code>
     *     // inclusión
     *     require_once APP . '/vendors/finder/finder.class.php';
     *     
     *     // instancia
     *     $finder = new Finder();
     *     
     *     // indicar el directorio inicial para la búsqueda
     *     $finder->setFolder('your_home_directory');
     *     
     *     // indicar con un ARRAY, las extensión donde quiero que realice las búsquedas
     *     $finder->setExtension( array('html', 'css', 'php' ) );
     *     
     *     // indicar el texto a buscar
     *     $finder->setFindme('string');
     * <code>
     */


	class Finder {

		private $folder;
		private $extension;
		private $findme;	

		/**
         * __construct
         * 
         * @access  public
         * @param   integer $folder (default: null)
         * @param   integer $extension (default: null)
         * @param   integer $findme (default: null)
         * @return  void
         */


		public function __construct( $folder = null, $extension = null, $findme = null ) {

			if (is_null($folder) === false) {

                $this->setFolder($folder);

            }

            if (is_null($extension) === false) {

                $this->setExtension($extension);

            }

            if (is_null($findme) === false) {

                $this->setFindme($findme);

            }
		}	


		/**
	     * @return mixed
	     */
	    public function getResultado()
	    {
	        $directory = new RecursiveDirectoryIterator( $this->folder );

	        // init
	        $rowFound = array();

			foreach ( new RecursiveIteratorIterator( $directory ) as $fileName => $file) {

			    if ( in_array($file->getExtension(), $this->extension)  ) {
			    
		    		$pagina = file_get_contents($fileName);
					$pos = strpos($pagina, $this->findme);

					// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
					if ($pos === false) {
					} else {
						
						$archivo = fopen($fileName,'r');
						$lineNumber = 1;

						while ($lineData = fgets($archivo)) {
						    
						    if (strpos($lineData, $this->findme)) {
						    	
					    		// echo "Line: [".$lineNumber."] ".$fileName." --> ".$lineData.'<br>' ;
						    	$rowFound[] = array('lineNumber' => $lineNumber, 'lineData' => $lineData, 'fileName' => __DIR__.'/'.$fileName);    
						    	
						    }
						    
						    $lineNumber++;
						}

					}
				}
			}

			return $rowFound;
	    }


	    static function base64url_encode( $data ) {

		  return rtrim( strtr( base64_encode( $data ), '+/', '-_' ), '=' );

		}

		static function base64url_decode( $data ) {

		  return base64_decode( str_pad( strtr( $data, '-_', '+/' ), strlen( $data ) % 4, '=', STR_PAD_RIGHT ) );

		}





		
	    /**
	     * @return mixed
	     */
	    public function getFolder()
	    {
	        return $this->folder;
	    }

	    /**
	     * @param mixed $folder
	     *
	     * @return self
	     */
	    public function setFolder($folder)
	    {
	        $this->folder = $folder;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getExtension()
	    {
	        return $this->extension;
	    }

	    /**
	     * @param mixed $extension
	     *
	     * @return self
	     */
	    public function setExtension($extension)
	    {
	        $this->extension = $extension;

	        return $this;
	    }

	    /**
	     * @return mixed
	     */
	    public function getFindme()
	    {
	        return $this->findme;
	    }

	    /**
	     * @param mixed $findme
	     *
	     * @return self
	     */
	    public function setFindme($findme)
	    {
	        $this->findme = $findme;

	        return $this;
	    }



	    static function sanitizer( $data ) {

		  $data = trim( $data );
		  $data = stripslashes( $data );
		  $data = htmlspecialchars( $data );

		  return $data;
		}
	
	}    	
?>