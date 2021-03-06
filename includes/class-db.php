<?php

abstract class Affiliate_WP_DB {

	public $table_name;

	public $version;

	public $primary_key;

	public function __construct() {}

	public function get_columns() {
		return array();
	}

	public function get_column_defaults() {
		return array();
	}
	
	public function get( $row_id ) {
		global $wpdb;
		return $wpdb->get_row( "SELECT * FROM $this->table_name WHERE $this->primary_key = $row_id;" );
	}

	public function get_by( $column, $row_id ) {
		global $wpdb;
		return $wpdb->get_row( "SELECT * FROM $this->table_name WHERE $column = '$row_id';" );
	}

	public function get_column( $column, $row_id ) {
		global $wpdb;
		return $wpdb->get_var( "SELECT $column FROM $this->table_name WHERE $this->primary_key = $row_id;" );
	}

	public function get_column_by( $column, $column_where, $column_value ) {
		global $wpdb;
		return $wpdb->get_col( "SELECT $column FROM $this->table_name WHERE $column_where = $column_value;" );
	}
	
	public function insert( $data, $type = '' ) {
		global $wpdb;

		// Set default values
		$data = wp_parse_args( $data, $this->get_column_defaults() );

		do_action( 'affwp_pre_insert_' . $type, $data );

		// Initialise column format array
		$column_formats = $this->get_columns();

		// Force fields to lower case
		$data = array_change_key_case( $data );

		// White list columns
		$data = array_intersect_key( $data, $column_formats );

		// Reorder $column_formats to match the order of columns given in $data
		$data_keys = array_keys( $data );
		$column_formats = array_merge( array_flip( $data_keys ), $column_formats );

		$wpdb->insert( $this->table_name, $data, $column_formats );

		wp_cache_flush();

		do_action( 'affwp_post_insert_' . $type, $wpdb->insert_id, $data );

		return $wpdb->insert_id;
	}

	public function update( $row_id, $data = array(), $where = '' ) {
		global $wpdb;        

		// Row ID must be positive integer
		$row_id = absint( $row_id );     
		if( empty( $row_id ) )
			return false;

		if( empty( $where ) ) {
			$where = $this->primary_key;
		}

		// Initialise column format array
		$column_formats = $this->get_columns();

		// Force fields to lower case
		$data = array_change_key_case ( $data );

		// White list columns
		$data = array_intersect_key( $data, $column_formats );

		// Reorder $column_formats to match the order of columns given in $data
		$data_keys = array_keys( $data );
		$column_formats = array_merge( array_flip( $data_keys ), $column_formats );

		if ( false === $wpdb->update( $this->table_name, $data, array( $where => $row_id ), $column_formats ) ) {
			return false;
		}

		wp_cache_flush();

		return true;
	}

	public function delete( $row_id = 0 ) {

		global $wpdb;

		// Row ID must be positive integer
		$row_id = absint( $row_id );     
		if( empty( $row_id ) )
			return false;

		if ( false === $wpdb->query( $wpdb->prepare( "DELETE FROM $this->table_name WHERE $this->primary_key = %d", $row_id ) ) ) {
			return false;
		}

		wp_cache_flush();

		return true;
	}

}