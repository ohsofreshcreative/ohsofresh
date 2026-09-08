<?php

namespace App\Walkers;

use Walker_Nav_Menu;

class DropdownWalker extends Walker_Nav_Menu
{
	/**
	 * Oznacza jako mega menu każdy element główny posiadający co najmniej trzy poziomy.
	 */
	public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
	{
		if ($element && $depth === 0) {
			$id_field = $this->db_fields['id'];
			$children = $children_elements[$element->{$id_field}] ?? [];

			foreach ($children as $child) {
				if (!empty($children_elements[$child->{$id_field}])) {
					$element->classes[] = 'mega-menu';
					break;
				}
			}
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}

	/**
	 * Rozpoczyna listę podmenu.
	 */
	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		if ($depth === 0) {
			$output .= '<ul'
				. ' x-show="open"'
				. ' x-transition:enter="transition ease-out duration-200"'
				. ' x-transition:enter-start="opacity-0 -translate-y-2"'
				. ' x-transition:enter-end="opacity-100 translate-y-0"'
				. ' x-transition:leave="transition ease-in duration-150"'
				. ' x-transition:leave-start="opacity-100 translate-y-0"'
				. ' x-transition:leave-end="opacity-0 -translate-y-2"'
				. ' class="desktop-submenu submenu-level-1"'
				. ' style="display: none;">';
			return;
		}

		$output .= '<ul class="desktop-submenu submenu-level-' . ($depth + 1) . '">';
	}

	/**
	 * Rozpoczyna element menu.
	 */
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$classes = array_filter((array) $item->classes);
		$has_children = in_array('menu-item-has-children', $classes, true);
		$is_mega_menu = in_array('mega-menu', $classes, true);

		if ($depth === 0 && $has_children) {
			$classes[] = 'desktop-menu-parent';
			$output .= '<li'
				. ' x-data="{ open: false }"'
				. ' @mouseenter="open = true"'
				. ' @mouseleave="open = false"'
				. ' @focusin="open = true"'
				. ' @focusout="if (!$el.contains($event.relatedTarget)) open = false"'
				. ' @keydown.escape.stop="open = false"'
				. ' class="' . esc_attr(implode(' ', array_unique($classes))) . '">';
		} else {
			$output .= '<li class="' . esc_attr(implode(' ', $classes)) . '">';
		}

		$link_classes = $depth === 0
			? 'desktop-menu-link inline-flex items-center gap-1 text-sm font-medium'
			: 'desktop-submenu-link';

		$attributes = [
			'href' => !empty($item->url) ? $item->url : '',
			'target' => !empty($item->target) ? $item->target : '',
			'rel' => !empty($item->xfn) ? $item->xfn : '',
			'title' => !empty($item->attr_title) ? $item->attr_title : '',
			'class' => $link_classes,
		];

		if ($depth === 0 && $has_children) {
			$attributes['aria-haspopup'] = 'true';
			$attributes[':aria-expanded'] = 'open.toString()';
		}

		if (in_array('current-menu-item', $classes, true)) {
			$attributes['aria-current'] = 'page';
		}

		$output .= '<a' . $this->attributes($attributes) . '>';
		$output .= esc_html($item->title);

		if ($depth === 0 && $has_children) {
			$output .= '<svg class="size-4 transition-transform" :class="{ \'rotate-180\': open }" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">'
				. '<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>'
				. '</svg>';
		}

		$output .= '</a>';

		if ($depth === 0 && $has_children && $is_mega_menu) {
			$output .= '<span class="sr-only">Mega menu</span>';
		}
	}

	/**
	 * Zamyka element menu.
	 */
	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		$output .= "</li>\n";
	}

	/**
	 * Zamyka listę i dodaje pasek CTA widoczny wyłącznie w mega menu.
	 */
	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		if ($depth === 0) {
	$output .= '<li class="mega-menu__cta">'
		. '<div class="mega-menu__cta-inner">'
		. '<p class="mega-menu__cta-title">' . esc_html__('Projektujemy strony, które napędzają biznes.', 'sage') . '</p>'
		. '<p class="mega-menu__cta-text">' . esc_html__('Łączymy przemyślany UX, indywidualny design i nowoczesne technologie, tworząc rozwiązania dopasowane do celów Twojej firmy.', 'sage') . '</p>'
		. '<a class="mega-menu__cta-button" href="' . esc_url(home_url('/kontakt/')) . '">'
		. esc_html__('Szybka wycena', 'sage')
		. '<svg class="size-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M5 15 15 5M8 5h7v7"/></svg>'
		. '</a>'
		. '</div>'
		. '</li>';
}

		$output .= "</ul>\n";
	}

	/**
	 * Buduje bezpieczny ciąg atrybutów HTML.
	 */
	private function attributes(array $attributes): string
	{
		$output = '';

		foreach ($attributes as $attribute => $value) {
			if ($value === '') {
				continue;
			}

			$escaped = $attribute === 'href' ? esc_url($value) : esc_attr($value);
			$output .= ' ' . $attribute . '="' . $escaped . '"';
		}

		return $output;
	}
}
