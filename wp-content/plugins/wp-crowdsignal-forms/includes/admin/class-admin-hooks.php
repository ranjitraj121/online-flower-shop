<?php
/**
 * Contains the Admin_Hooks class
 *
 * @package WP_CROWDSIGNAL_FORMS\Admin
 */

namespace WP_CROWDSIGNAL_FORMS\Admin;

use WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Admin;
use WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Admin_Notices;
use WP_CROWDSIGNAL_FORMS\Models\Poll;
use WP_CROWDSIGNAL_FORMS\WP_CROWDSIGNAL_FORMS;
use WP_CROWDSIGNAL_FORMS\Auth\WP_CROWDSIGNAL_FORMS_Api_Authenticator;
use WP_CROWDSIGNAL_FORMS\Synchronization\Post_Sync_Entity;
use WP_CROWDSIGNAL_FORMS\Synchronization\Comment_Sync_Entity;
use WP_CROWDSIGNAL_FORMS\Synchronization\Poll_Block_Synchronizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin_Hooks
 */
class Admin_Hooks {
	/**
	 * The poll ids meta key.
	 */
	const WP_CROWDSIGNAL_FORMS_POLL_IDS = '_WP_CROWDSIGNAL_FORMS_poll_ids';
	/**
	 * Is the class hooked.
	 *
	 * @var bool Is the class hooked.
	 */
	private $is_hooked = false;

	/**
	 * The admin page.
	 *
	 * @var WP_CROWDSIGNAL_FORMS_Admin
	 */
	private $admin;

	/**
	 * Perform any hooks.
	 *
	 * @since 0.9.0
	 *
	 * @return $this
	 */
	public function hook() {
		if ( $this->is_hooked ) {
			return $this;
		}
		$this->is_hooked = true;
		// Do any hooks required.
		if ( is_admin() && apply_filters( 'WP_CROWDSIGNAL_FORMS_show_admin', true ) ) {
			$this->admin = new WP_CROWDSIGNAL_FORMS_Admin();

			// admin page.
			add_action( 'admin_init', array( $this->admin, 'admin_init' ) );
			add_action( 'admin_menu', array( $this->admin, 'admin_menu' ), 12 );
			add_action( 'admin_enqueue_scripts', array( $this->admin, 'admin_enqueue_scripts' ) );

			// admin notices.
			add_action( 'WP_CROWDSIGNAL_FORMS_init_admin_notices', 'WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Admin_Notices::init_core_notices' );
			add_action( 'admin_notices', 'WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Admin_Notices::display_notices' );
			add_action( 'wp_loaded', 'WP_CROWDSIGNAL_FORMS\Admin\WP_CROWDSIGNAL_FORMS_Admin_Notices::dismiss_notices' );
		}

		add_action( 'save_post', array( $this, 'save_polls_to_api' ), 10, 3 );
		/**
		 * Should we synchronize poll blocks in comments too?
		 *
		 * @since 1.0.0
		 *
		 * @param bool $should_sync Synchronize the poll blocks in comments.
		 * @return bool
		 */
		$should_sync_comment_polls = (bool) apply_filters( 'WP_CROWDSIGNAL_FORMS_should_sync_comment_polls', true );
		if ( $should_sync_comment_polls ) {
			add_action( 'comment_post', array( $this, 'save_polls_to_api_from_new_comment' ), 10, 3 );
			add_action( 'edit_comment', array( $this, 'save_polls_to_api_from_updated_comment' ), 10, 2 );
		}

		return $this;
	}

	/**
	 * Save polls in new comments.
	 *
	 * @param  int        $comment_id       The comment id.
	 * @param int|string $comment_approved Comment approved status.
	 * @param array      $commentdata      The comment data.
	 *
	 * @return void|bool
	 *
	 * @throws \Exception In case of bad request. This is temporary.
	 *
	 * @since 1.0.0
	 */
	public function save_polls_to_api_from_new_comment( $comment_id, $comment_approved, $commentdata ) {
		$saver        = new Comment_Sync_Entity( $comment_id, $comment_approved, $commentdata );
		$synchronizer = new Poll_Block_Synchronizer( $saver );
		return $synchronizer->synchronize();
	}

	/**
	 * Save polls in updated comments.
	 *
	 * @param int   $comment_id  The comment id.
	 * @param array $commentdata The comment data.
	 *
	 * @return void|bool
	 *
	 * @throws \Exception In case of bad request. This is temporary.
	 *
	 * @since 1.0.0
	 */
	public function save_polls_to_api_from_updated_comment( $comment_id, $commentdata ) {
		$saver        = new Comment_Sync_Entity( $comment_id, null, $commentdata );
		$synchronizer = new Poll_Block_Synchronizer( $saver );
		return $synchronizer->synchronize();
	}

	/**
	 * Will save any pending polls.
	 *
	 * @param int      $post_ID The id.
	 * @param \WP_Post $post The post.
	 * @param bool     $is_update Is this an update.
	 *
	 * @since 0.9.0
	 * @return void|bool
	 *
	 * @throws \Exception In case of bad request. This is temporary.
	 */
	public function save_polls_to_api( $post_ID, $post, $is_update = false ) {
		$saver        = new Post_Sync_Entity( $post_ID, $post, $is_update );
		$synchronizer = new Poll_Block_Synchronizer( $saver );
		return $synchronizer->synchronize();
	}

	/**
	 * Archive polls with these ids.
	 *
	 * @param array $poll_ids_to_archive Ids to archive.
	 */
	private function archive_polls_with_ids( $poll_ids_to_archive ) {
		if ( empty( $poll_ids_to_archive ) ) {
			return;
		}
		$gateway = WP_CROWDSIGNAL_FORMS::instance()->get_api_gateway();
		foreach ( $poll_ids_to_archive as $id_to_archive ) {
			$gateway->archive_poll( $id_to_archive );
		}
	}
}
