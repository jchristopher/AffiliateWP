<?php
/**
 * Affiiates Admin
 *
 * @package     AffiliateWP
 * @subpackage  Admin/Affiliates
 * @copyright   Copyright (c) 2014, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function affwp_reports_admin() {

?>
	<div class="wrap">
		<h2><?php _e( 'Reports', 'affiliate-wp' ); ?></h2>
		<?php do_action( 'affwp_reports_page_top' ); ?>

		<table id="affwp_total_earnings" class="affwp_table">

			<thead>

				<tr>

					<th><?php _e( 'Total Paid Earnings', 'affiliate-wp' ); ?></th>
					<th><?php _e( 'Total Paid Earnings This Month', 'affiliate-wp' ); ?></th>
					<th><?php _e( 'Total Paid Earnings Today', 'affiliate-wp' ); ?></th>

				</tr>

			</thead>

			<tbody>

				<tr>
					<td><?php echo affiliate_wp()->referrals->paid_earnings(); ?></td>
					<td><?php echo affiliate_wp()->referrals->paid_earnings( 'month' ); ?></td>
					<td><?php echo affiliate_wp()->referrals->paid_earnings( 'today' ); ?></td>
				</tr>

			</tbody>

		</table>

		<table id="affwp_unpaid_counts" class="affwp_table">

			<thead>

				<tr>

					<th><?php _e( 'Total Unpaid Referrals', 'affiliate-wp' ); ?></th>
					<th><?php _e( 'Total Unpaid Referrals This Month', 'affiliate-wp' ); ?></th>
					<th><?php _e( 'Total Unpaid Referrals Today', 'affiliate-wp' ); ?></th>

				</tr>

			</thead>

			<tbody>

				<tr>
					<td><?php echo affiliate_wp()->referrals->unpaid_count(); ?></td>
					<td><?php echo affiliate_wp()->referrals->unpaid_count( 'month' ); ?></td>
					<td><?php echo affiliate_wp()->referrals->unpaid_count( 'today' ); ?></td>
				</tr>

			</tbody>

		</table>

		<table id="affwp_unpaid_earnings" class="affwp_table">

			<thead>

				<tr>

					<th><?php _e( 'Total Unpaid Earnings', 'affiliate-wp' ); ?></th>
					<th><?php _e( 'Total Unpaid Earnings This Month', 'affiliate-wp' ); ?></th>
					<th><?php _e( 'Total Unpaid Earnings Today', 'affiliate-wp' ); ?></th>

				</tr>

			</thead>

			<tbody>

				<tr>
					<td><?php echo affiliate_wp()->referrals->unpaid_earnings(); ?></td>
					<td><?php echo affiliate_wp()->referrals->unpaid_earnings( 'month' ); ?></td>
					<td><?php echo affiliate_wp()->referrals->unpaid_earnings( 'today' ); ?></td>
				</tr>

			</tbody>

		</table>

		<?php

		$graph = new Affiliate_WP_Referrals_Graph;
		$graph->set( 'x_mode', 'time' );
		$graph->display();

		do_action( 'affwp_reports_page_bottom' );
		?>
	</div>
<?php


}