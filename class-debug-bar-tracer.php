<?php
/**
 * 
 */


/**
 * Adds a new panel to the Debug Bar to display traces
 */

class Debug_Bar_Tracer extends Debug_Bar_Panel {

	/**
	 * @var array $traces holds the traces
	 */
	static $traces = array();
	
	/**
	 * init()
	 */
	public function init() {
		$this->title( __( 'Tracer', 'debug-bar-tracer' ) );
		add_action( 'wp_print_styles', array( $this, 'print_styles' ) );
		add_action( 'admin_print_styles', array( $this, 'print_styles' ) );
	}

	/**
	 * setup the page for rendering
	 */
	function prerender() {
		$this->set_visible(
			count( self::$traces )
		);
	}

	/**
	 * print the styles for the page
	 */
	public function print_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.dev' : '';
		wp_enqueue_style( 'rw-debug-bar-tracer', plugins_url( "css/debug-bar-tracer$suffix.css", __FILE__ ), array(), '20140401' );
	}

	/**
	 * Renders the page
	 */
	public function render() {
		echo "<div id='tracer-output'>";
			echo '<h2><span>'.__('Tracer Count', 'debug-bar-tracer').'</span>' . number_format( count( self::$traces ) ) . "</h2>\n";
			echo "<div class='debug-traces'>";
			echo $this->rw_debug_bar_tracer_parse( self::$traces );
			echo "</div>";
		echo "</div>";
	}


	/**
	 * Parses the object for the output window
	 * @var array $trace_array The array of active traces to loop
	 */
	private function rw_debug_bar_tracer_parse( $trace_array ) {

		$tempOutput = '';
		//create the js
		?>
			<script>
			jQuery(document).ready(function($){
				$('a.single-trace-toggle-data').click(function(e){
					//e.preventDefault();
					$(this).parent().next('div.single-trace-data').slideToggle();
				})
			});
			</script>
		<?php
		//loop the array items
		foreach( $trace_array as $trace) {
			$key = ( isset( $trace['key'] ) ) ? 'User Defined :: '.$trace['key'] : '';

			$tempOutput .= '<div class="single-trace">';
				$tempOutput .= '<div class="single-trace-location"><strong>'.__('Location:','debug-bar-tracer').'</strong> ' .$trace['location'].' - <a href="#" class="single-trace-toggle-data">Toggle</a></div> ';
				$tempOutput .= '<div class="single-trace-data">' . $key . $this->rw_debug_tracer_parse_object( $trace['data'] ).'</div>';

				
			$tempOutput .= '</div>';	
		}

		return $tempOutput;

	}


	/**
	 * Loop the complex items
	 * @var object | array $object The item we are planning on displaying
	 */
	private function rw_debug_tracer_parse_object( $object ) {
		$tempOutput = '';

		if('object' == gettype( $object ) ) {

			$tempArray = get_object_vars( $object );
		}else{
			$tempArray = $object;	
		}

		$tempOutput .= '<pre>'.print_r($tempArray, 1).'</pre>';

		return '' . $tempOutput . '';

	}
}