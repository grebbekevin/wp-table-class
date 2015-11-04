<?php
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
 
/**
 * Create a new table class that will extend the WP_List_Table
 */
class wp_table_class extends WP_List_Table
{
	
	private $columns = array();
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items($sql)
    {
        $columns = $this->columns;
        $hidden = $this->get_hidden_columns();
        $sortable = $this->set_sortable_columns();
 
        $data = $this->table_data($sql);
        usort( $data, array( &$this, 'sort_data' ) );
		
        $perPage = 20;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
 
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
 
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
 
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }
 
    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function set_columns($columns = array())
    {
        $this->columns = $columns;
     }
 
    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }
 
    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function set_sortable_columns($sortable = array())
    {
        return $sortable;
    }
 
    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data($sql)
    {
        global $wpdb;
		
		$data = $wpdb->get_results($sql);
 
        return  json_decode(json_encode($data), true);
    }
 
    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        if(array_key_exists($column_name, $this->columns)) {
			return $item[ $column_name ];
        }
		return print_r( $item, true ) ;
    }
 
    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'ID';
        $order = 'asc';
 
        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
 
        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
 
 
        $result = strnatcmp( $a[$orderby], $b[$orderby] );
 
        if($order === 'asc')
        {
            return $result;
        }
 
        return -$result;
    }
}
