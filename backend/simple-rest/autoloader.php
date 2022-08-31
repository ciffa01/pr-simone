<?php
/**
 * Questo autoloader segue le specifiche PSR-4 per gli autoloader di classi
 * ( https://www.php-fig.org/psr/psr-4/ ).
 * 
 * Il funzionamento è il seguente. Si prenda un pacchetto in cui le classi
 * sul filesystem sono organizzate in questa maniera:
 *
 *     /path/to/packages/foo-bar/
 *         src/
 *             Baz.php             # Foo\Bar\Baz
 *             Qux/
 *                 Quux.php        # Foo\Bar\Qux\Quux
 *         tests/
 *             BazTest.php         # Foo\Bar\BazTest
 *             Qux/
 *                 QuuxTest.php    # Foo\Bar\Qux\QuuxTest
 * 
 * L'autoloader va quindi configurato in questa maniera:
 * <?php
 * 		// Instanziare l'autoloader
 * 		$loader = new PSR4_autoloader_class;
 * 
 * 		// Registrazione dell'autoloader
 * 		$loader->register();
 * 		
 *		// Registrazione dei percorsi associati ai namespace
 *		$loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');
 *		$loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
 *
 * Fatto ciò l'autoloader caricherà le classi del namespace \Foo\Bar dalla
 * directory /path/to/packages/foo-bar/src o /path/to/packages/foo-bar/tests.
 * Il seguente codice tenterà di caricare la classe \Foo\Bar\Qux\Quux dal
 * file /path/to/packages/foo-bar/src/Qux/Quux.php:
 *
 * <?php
 *		new \Foo\Bar\Qux\Quux;
 *
 * Il seguente codice tenterà invece di caricare la classe
 * \Foo\Bar\Qux\QuuxTest dal file /path/to/packages/foo-bar/src/Qux/QuuxTest.php:
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\QuuxTest class from /path/to/packages/foo-bar/tests/Qux/QuuxTest.php:
 *
 * <?php
 *		 new \Foo\Bar\Qux\QuuxTest;
 */

 /**
  * Classe autoloader
  * Codice della classe Psr4AutoloaderClass preso dal seguente repository:
  * https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md
  */
 class SimpleRestAutoloader {
    /**
     * Array associativo delle coppie prefisso namespace / base directory.
     *
     * @var array
     */
	protected $prefixes = array();

    /**
     * Registra il loader tramite SPL.
	 * Vedi: 
	 *  - http://php.net/manual/en/ref.spl.php
	 *  - http://php.net/manual/en/function.spl-autoload.php
	 * 
     * @return void
     */
	public function register() {
		spl_autoload_register(array($this, 'load_class'));
	}

    /**
     * Adds a base directory for a namespace prefix.
     *
     * @param string $prefix Prefisso del namespace.
     * @param string $base_dir Base directory del namespace.
     * @param bool $prepend If true, prepend the base directory to the stack
     * instead of appending it; this causes it to be searched first rather
     * than last.
     * @return void
     */
	public function add_namespace($prefix, $base_dir, $prepend = false) {
		// normalize namespace prefix
		$prefix = trim($prefix, '\\') . '\\';

		// normalize the base directory with a trailing separator
		$base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

		// initialize the namespace prefix array
		if (isset($this->prefixes[$prefix]) === false) {
			$this->prefixes[$prefix] = array();
		}

		// retain the base directory for the namespace prefix
		if ($prepend) {
			array_unshift($this->prefixes[$prefix], $base_dir);
		} else {
			array_push($this->prefixes[$prefix], $base_dir);
		}
	}

	public function logToDB($className) {
		/*
		$q = gendb_query("
			INSERT INTO log (
				data_operazione, 
				ora_operazione, 
				operazione, 
				utente, 
				ip
			) VALUES (
				'".date("Y-m-d")."', 
				'".date("H:i:s")."', 
				'".addslashes($className)."', 
				'autoloader', 
				'127.0.0.1'
			)
		");
		*/
	}

    /**
     * Loads the class file for a given class name.
     *
     * @param string $class Nome completo della classe.
     * @return mixed Ritorna il file in caso di successo altrimenti false.
     */
	public function load_class($class) {
		$this->logToDB($class);
		// the current namespace prefix
		$prefix = $class;

		// work backwards through the namespace names of the fully-qualified
		// class name to find a mapped file name
		while (false !== $pos = strrpos($prefix, '\\')) {

			// retain the trailing namespace separator in the prefix
			$prefix = substr($class, 0, $pos + 1);

			// the rest is the relative class name
			$relative_class = substr($class, $pos + 1);

			// try to load a mapped file for the prefix and relative class
			$mapped_file = $this->load_mapped_file($prefix, $relative_class);

			if ($mapped_file) {
				return $mapped_file;
			}

			// remove the trailing namespace separator for the next iteration
			// of strrpos()
			$prefix = rtrim($prefix, '\\');
		}

		// never found a mapped file
		return false;
	}

    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @param string $prefix The namespace prefix.
     * @param string $relative_class The relative class name.
     * @return mixed Boolean false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
	protected function load_mapped_file($prefix, $relative_class) {
		// are there any base directories for this namespace prefix?
		
		if (isset($this->prefixes[$prefix]) === false) {
			return false;
		}

		// look through base directories for this namespace prefix
		foreach ($this->prefixes[$prefix] as $base_dir) {

			// replace the namespace prefix with the base directory,
			// replace namespace separators with directory separators
			// in the relative class name, append with .php
			$file = $base_dir
				.str_replace('\\', '/', $relative_class)
				.'.php';

			// if the mapped file exists, require it
			if ($this->require_file($file)) {
			// yes, we're done
				return $file;
			}
		}

		// never found it
		return false;
	}

    /**
     * If a file exists, require it from the file system.
     *
     * @param string $file The file to require.
     * @return bool True if the file exists, false if not.
     */
	protected function require_file($file) {
		if (file_exists($file)) {
			require $file;

			return true;
		}

		return false;
	}
}

class SimpleRestHyperAutoloader extends SimpleRestAutoloader {
	public function add_namespace($prefix, $base_dir, $prepend = false) {
		if (preg_match('/^\.+\//', $base_dir) == 0) {
			parent::add_namespace($prefix, "../".$base_dir, $prepend);
		}

		parent::add_namespace($prefix, $base_dir, $prepend);
	}

	public function add_namespace_PSR4($prefix, $base_dir, $prepend = false) {
		parent::add_namespace($prefix, $base_dir, $prepend);
	}
}