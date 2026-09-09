<?php

/*--- CPT - Produkty ---*/

add_action('init', function () {
	register_post_type('works', [
		'label'         => 'Realizacje',
		'labels'        => [
			'name'               => 'Realizacje',
			'singular_name'      => 'Realizacja',
			'menu_name'          => 'Realizacje',
			'all_items'          => 'Wszystkie realizacje',
			'add_new'            => 'Dodaj nową',
			'add_new_item'       => 'Dodaj nową realizację',
			'edit_item'          => 'Edytuj realizację',
			'new_item'           => 'Nowa realizacja',
			'view_item'          => 'Zobacz realizację',
			'view_items'         => 'Zobacz realizacje',
			'search_items'       => 'Szukaj realizacji',
			'not_found'          => 'Nie znaleziono realizacji',
			'not_found_in_trash' => 'Brak realizacji w koszu',
			'parent_item_colon'  => 'Realizacja nadrzędna:',
		],
		'public'        => true,
		'hierarchical'  => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-cart',
		'menu_position' => 20,
		'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
		'show_in_rest'  => true,
		'rewrite'       => ['slug' => 'realizacje', 'with_front' => false],
	]);
});

/*--- Kolejność realizacji ---*/

add_action('admin_menu', function () {
	add_submenu_page('edit.php?post_type=works', 'Kolejność realizacji', 'Kolejność', 'edit_others_posts', 'works-order', function () {
		$items = get_posts([
			'post_type' => 'works',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => ['menu_order' => 'ASC', 'date' => 'DESC', 'ID' => 'DESC'],
		]);
		?>
		<div class="wrap">
			<h1>Kolejność realizacji</h1>
			<p>Przeciągnij opublikowane realizacje za uchwyt, a następnie zapisz kolejność. Blok Works wyświetli je w takim samym porządku.</p>
			<?php if (isset($_GET['saved'])) : ?>
				<div class="notice notice-success is-dismissible"><p>Kolejność została zapisana.</p></div>
			<?php endif; ?>
			<form id="works-order-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
				<input type="hidden" name="action" value="save_works_order">
				<input type="hidden" name="works_order" value="<?php echo esc_attr(wp_json_encode(wp_list_pluck($items, 'ID'))); ?>">
				<?php wp_nonce_field('save_works_order'); ?>
				<ul id="works-order-list">
					<?php foreach ($items as $item) : ?>
						<li class="card" style="display: flex; align-items: center; gap: 8px; max-width: 400px; min-width: 0; margin-top: 6px; padding: 8px 12px;" data-id="<?php echo esc_attr($item->ID); ?>">
							<span class="works-order-handle dashicons dashicons-menu" aria-hidden="true" style="cursor: grab;"></span>
							<strong><?php echo esc_html($item->post_title ?: '(bez tytułu)'); ?></strong>
						</li>
					<?php endforeach; ?>
				</ul>
				<p id="works-order-status" role="status" aria-live="polite"></p>
				<?php if ($items) { submit_button('Zapisz kolejność'); } ?>
			</form>
		</div>
		<?php
	});
});

add_action('admin_enqueue_scripts', function () {
	if (get_current_screen()?->id !== 'works_page_works-order') {
		return;
	}

	wp_enqueue_script('jquery-ui-sortable');
	wp_add_inline_script('jquery-ui-sortable', <<<'JS'
jQuery(function ($) {
  const list = $('#works-order-list');
  const changed = () => {
    $('#works-order-status').text('Kolejność zmieniona. Kliknij „Zapisz kolejność”.');
  };

  list.sortable({
    items: '> li',
    handle: '.works-order-handle',
    axis: 'y',
    update: changed,
  });

  $('#works-order-form').on('submit', function () {
    const ids = list.children('li').map(function () {
      return Number(this.dataset.id);
    }).get();
    $(this).find('[name="works_order"]').val(JSON.stringify(ids));
  });
});
JS
	);
});

add_action('admin_post_save_works_order', function () {
	if (! current_user_can('edit_others_posts')) {
		wp_die('Nie masz uprawnień do zmiany kolejności realizacji.', '', ['response' => 403]);
	}

	check_admin_referer('save_works_order');
	$raw = $_POST['works_order'] ?? '';
	$ids = is_string($raw) ? json_decode(wp_unslash($raw), true) : null;
	if (! is_array($ids) || ! array_is_list($ids) || count($ids) !== count(array_unique($ids, SORT_REGULAR))) {
		wp_die('Nieprawidłowa lista realizacji.', '', ['response' => 400]);
	}

	foreach ($ids as $id) {
		if (! is_int($id) || get_post_type($id) !== 'works' || get_post_status($id) !== 'publish' || ! current_user_can('edit_post', $id)) {
			wp_die('Lista realizacji zmieniła się lub nie masz uprawnień do jej edycji. Odśwież listę i spróbuj ponownie.', '', ['response' => 400]);
		}
	}

	foreach ($ids as $position => $id) {
		$result = wp_update_post(['ID' => $id, 'menu_order' => $position + 1], true);
		if (is_wp_error($result)) {
			wp_die('Nie udało się zapisać całej kolejności. Odśwież listę i spróbuj ponownie.', '', ['response' => 500]);
		}
	}

	wp_safe_redirect(admin_url('edit.php?post_type=works&page=works-order&saved=1'));
	exit;
});

add_action('pre_get_posts', function ($query) {
	if (! $query->is_main_query()) {
		return;
	}

	if (is_admin()) {
		if ($query->get('post_type') !== 'works' || $query->get('orderby')) {
			return;
		}
	} elseif (! $query->is_post_type_archive('works')) {
		return;
	}

	$query->set('orderby', ['menu_order' => 'ASC', 'date' => 'DESC', 'ID' => 'DESC']);
});

add_action('init', function () {
	register_taxonomy('offer_category', ['works'], [
		'label'        => 'Kategorie realizacji',
		'labels'       => [
			'name'              => 'Kategorie realizacji',
			'singular_name'     => 'Kategoria realizacji',
			'search_items'      => 'Szukaj kategorii',
			'all_items'         => 'Wszystkie kategorie',
			'parent_item'       => 'Kategoria nadrzędna',
			'parent_item_colon' => 'Kategoria nadrzędna:',
			'edit_item'         => 'Edytuj kategorię',
			'update_item'       => 'Aktualizuj kategorię',
			'add_new_item'      => 'Dodaj nową kategorię',
			'new_item_name'     => 'Nazwa nowej kategorii',
			'menu_name'         => 'Kategorie',
		],
		'hierarchical' => true,
		'public'       => true,
		'show_in_rest' => true,
		'rewrite'      => ['slug' => 'kategoria-oferty', 'with_front' => false],
	]);
});
