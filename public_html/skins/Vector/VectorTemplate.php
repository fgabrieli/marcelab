<?php
/**
 * Vector - Modern version of MonoBook with fresh look and many usability
 * improvements.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Skins
 */

/**
 * QuickTemplate class for Vector skin
 * @ingroup Skins
 */
class VectorTemplate extends BaseTemplate {
	/* Functions */

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {
		// Build additional attributes for navigation urls
		$nav = $this->data['content_navigation'];

		if ( $this->config->get( 'VectorUseIconWatch' ) ) {
			$mode = $this->getSkin()->getUser()->isWatched( $this->getSkin()->getRelevantTitle() )
				? 'unwatch'
				: 'watch';

			if ( isset( $nav['actions'][$mode] ) ) {
				$nav['views'][$mode] = $nav['actions'][$mode];
				$nav['views'][$mode]['class'] = rtrim( 'icon ' . $nav['views'][$mode]['class'], ' ' );
				$nav['views'][$mode]['primary'] = true;
				unset( $nav['actions'][$mode] );
			}
		}

		$xmlID = '';
		foreach ( $nav as $section => $links ) {
			foreach ( $links as $key => $link ) {
				if ( $section == 'views' && !( isset( $link['primary'] ) && $link['primary'] ) ) {
					$link['class'] = rtrim( 'collapsible ' . $link['class'], ' ' );
				}

				$xmlID = isset( $link['id'] ) ? $link['id'] : 'ca-' . $xmlID;
				$nav[$section][$key]['attributes'] =
					' id="' . Sanitizer::escapeId( $xmlID ) . '"';
				if ( $link['class'] ) {
					$nav[$section][$key]['attributes'] .=
						' class="' . htmlspecialchars( $link['class'] ) . '"';
					unset( $nav[$section][$key]['class'] );
				}
				if ( isset( $link['tooltiponly'] ) && $link['tooltiponly'] ) {
					$nav[$section][$key]['key'] =
						Linker::tooltip( $xmlID );
				} else {
					$nav[$section][$key]['key'] =
						Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( $xmlID ) );
				}
			}
		}
		$this->data['namespace_urls'] = $nav['namespaces'];
		$this->data['view_urls'] = $nav['views'];
		$this->data['action_urls'] = $nav['actions'];
		$this->data['variant_urls'] = $nav['variants'];

		// Reverse horizontally rendered navigation elements
		if ( $this->data['rtl'] ) {
			$this->data['view_urls'] =
				array_reverse( $this->data['view_urls'] );
			$this->data['namespace_urls'] =
				array_reverse( $this->data['namespace_urls'] );
			$this->data['personal_urls'] =
				array_reverse( $this->data['personal_urls'] );
		}
		// Output HTML Page
		$this->html( 'headelement' );
		?>
		<div id="mw-page-base" class="noprint"></div>
		<div id="mw-head-base" class="noprint"></div>
		<div id="content" class="mw-body" role="main">
			<a id="top"></a>

			<?php
			if ( $this->data['sitenotice'] ) {
				?>
				<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
			<?php
			}
			?>
			<h1 id="firstHeading" class="firstHeading" lang="<?php
			$this->data['pageLanguage'] =
				$this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();
			$this->text( 'pageLanguage' );
			?>"><span dir="auto"><?php $this->html( 'title' ) ?></span></h1>
			<?php $this->html( 'prebodyhtml' ) ?>
			<div id="bodyContent" class="mw-body-content">
				<?php
				if ( $this->data['isarticle'] ) {
					?>
					<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>
				<?php
				}
				?>
				<div id="contentSub"<?php
				$this->html( 'userlangattributes' )
				?>><?php $this->html( 'subtitle' ) ?></div>
				<?php
				if ( $this->data['undelete'] ) {
					?>
					<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
				<?php
				}
				?>
				<?php
				if ( $this->data['newtalk'] ) {
					?>
					<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
				<?php
				}
				?>
				<div id="jump-to-nav" class="mw-jump">
					<?php $this->msg( 'jumpto' ) ?>
					<a href="#mw-navigation"><?php
						$this->msg( 'jumptonavigation' )
						?></a><?php
					$this->msg( 'comma-separator' )
					?>
					<a href="#p-search"><?php $this->msg( 'jumptosearch' ) ?></a>
				</div>
				<?php $this->html( 'bodycontent' ) ?>
				<?php
				if ( $this->data['printfooter'] ) {
					?>
					<div class="printfooter">
						<?php $this->html( 'printfooter' ); ?>
					</div>
				<?php
				}
				?>
				<?php
				if ( $this->data['catlinks'] ) {
					?>
					<?php
					$this->html( 'catlinks' );
					?>
				<?php
				}
				?>
				<?php
				if ( $this->data['dataAfterContent'] ) {
					?>
					<?php
					$this->html( 'dataAfterContent' );
					?>
				<?php
				}
				?>
				<div class="visualClear"></div>
				<?php $this->html( 'debughtml' ); ?>
			</div>
		</div>
		<div id="mw-navigation">
			<h2><?php $this->msg( 'navigation-heading' ) ?></h2>

			<div id="mw-head">
				<?php $this->renderNavigation( 'PERSONAL' ); ?>
				<div id="left-navigation">
					<?php $this->renderNavigation( array( 'NAMESPACES', 'VARIANTS' ) ); ?>
				</div>
				<div id="right-navigation">
					<?php $this->renderNavigation( array( 'VIEWS', 'ACTIONS', 'SEARCH' ) ); ?>
				</div>
			</div>
			<div id="mw-panel">
				<div id="p-logo" role="banner"><a style="background-image: url(<?php
					$this->text( 'logopath' )
					?>);" href="<?php
					echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] )
					?>" <?php
					echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) )
					?>></a></div>
				<?php $this->renderPortals( $this->data['sidebar'] ); ?>
				
				<?php $this->renderNavigation( 'SEARCH' ); ?>
				
			</div>
		</div>
		<div id="footer" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
			<?php
			foreach ( $this->getFooterLinks() as $category => $links ) {
				?>
				<ul id="footer-<?php
				echo $category
				?>">
					<?php
					foreach ( $links as $link ) {
						?>
						<li id="footer-<?php
						echo $category
						?>-<?php
						echo $link
						?>"><?php
							$this->html( $link )
							?></li>
					<?php
					}
					?>
				</ul>
			<?php
			}
			?>
			<?php $footericons = $this->getFooterIcons( "icononly" );
			if ( count( $footericons ) > 0 ) {
				?>
				<ul id="footer-icons" class="noprint">
					<?php
					foreach ( $footericons as $blockName => $footerIcons ) {
						?>
						<li id="footer-<?php
						echo htmlspecialchars( $blockName ); ?>ico">
							<?php
							foreach ( $footerIcons as $icon ) {
								?>
								<?php
								echo $this->getSkin()->makeFooterIcon( $icon );
								?>

							<?php
							}
							?>
						</li>
					<?php
					}
					?>
				</ul>
			<?php
			}
			?>
			<div style="clear:both"></div>
		</div>
		<?php $this->printTrail(); ?>

	</body>
</html>
	<?php
	}

	/**
	 * Render a series of portals
	 *
	 * @param array $portals
	 */
	protected function renderPortals( $portals ) {
		// Force the rendering of the following portals
		if ( !isset( $portals['SEARCH'] ) ) {
			$portals['SEARCH'] = true;
		}
		if ( !isset( $portals['TOOLBOX'] ) ) {
			$portals['TOOLBOX'] = true;
		}
		if ( !isset( $portals['LANGUAGES'] ) ) {
			$portals['LANGUAGES'] = true;
		}
		// Render portals
		foreach ( $portals as $name => $content ) {
			if ( $content === false ) {
				continue;
			}

			switch ( $name ) {
				case 'SEARCH':
					break;
				case 'TOOLBOX':
					$this->renderPortal( 'tb', $this->getToolbox(), 'toolbox', 'SkinTemplateToolboxEnd' );
					break;
				case 'LANGUAGES':
					if ( $this->data['language_urls'] !== false ) {
						$this->renderPortal( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
				default:
					$this->renderPortal( $name, $content );
					break;
			}
		}
	}

	/**
	 * @param string $name
	 * @param array $content
	 * @param null|string $msg
	 * @param null|string|array $hook
	 */
	protected function renderPortal( $name, $content, $msg = null, $hook = null ) {
		if ( $msg === null ) {
			$msg = $name;
		}
		$msgObj = wfMessage( $msg );
		?>
		<div class="portal" role="navigation" id='<?php
		echo Sanitizer::escapeId( "p-$name" )
		?>'<?php
		echo Linker::tooltip( 'p-' . $name )
		?> aria-labelledby='<?php echo Sanitizer::escapeId( "p-$name-label" ) ?>'>
			<h3<?php
			$this->html( 'userlangattributes' )
			?> id='<?php
			echo Sanitizer::escapeId( "p-$name-label" )
			?>'><?php
				echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $msg );
				?></h3>

			<div class="body">
				<?php
				if ( is_array( $content ) ) {
					?>
					<ul>
						<?php
						foreach ( $content as $key => $val ) {
							?>
							<?php echo $this->makeListItem( $key, $val ); ?>

						<?php
						}
						if ( $hook !== null ) {
							wfRunHooks( $hook, array( &$this, true ) );
						}
						?>
					</ul>
				<?php
				} else {
					?>
					<?php
					echo $content; /* Allow raw HTML block to be defined by extensions */
				}

				$this->renderAfterPortlet( $name );
				?>
			</div>
		</div>
	<?php
	}

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 *
	 * @param array $elements
	 */
	protected function renderNavigation( $elements ) {
		// If only one element was given, wrap it in an array, allowing more
		// flexible arguments
		if ( !is_array( $elements ) ) {
			$elements = array( $elements );
			// If there's a series of elements, reverse them when in RTL mode
		} elseif ( $this->data['rtl'] ) {
			$elements = array_reverse( $elements );
		}
		// Render elements
		foreach ( $elements as $name => $element ) {
			switch ( $element ) {
				case 'NAMESPACES':
					?>
					<div id="p-namespaces" role="navigation" class="vectorTabs<?php
					if ( count( $this->data['namespace_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-namespaces-label">
						<h3 id="p-namespaces-label"><?php $this->msg( 'namespaces' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							foreach ( $this->data['namespace_urls'] as $link ) {
								?>
								<li <?php
								echo $link['attributes']
								?>><span><a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" <?php
										echo $link['key']
										?>><?php
											echo htmlspecialchars( $link['text'] )
											?></a></span></li>
							<?php
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'VARIANTS':
					?>
					<div id="p-variants" role="navigation" class="vectorMenu<?php
					if ( count( $this->data['variant_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-variants-label">
						<?php
						// Replace the label with the name of currently chosen variant, if any
						$variantLabel = $this->getMsg( 'variants' )->text();
						foreach ( $this->data['variant_urls'] as $link ) {
							if ( stripos( $link['attributes'], 'selected' ) !== false ) {
								$variantLabel = $link['text'];
								break;
							}
						}
						?>
						<h3 id="p-variants-label"><span><?php echo htmlspecialchars( $variantLabel ) ?></span><a href="#"></a></h3>

						<div class="menu">
							<ul>
								<?php
								foreach ( $this->data['variant_urls'] as $link ) {
									?>
									<li<?php
									echo $link['attributes']
									?>><a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" lang="<?php
										echo htmlspecialchars( $link['lang'] )
										?>" hreflang="<?php
										echo htmlspecialchars( $link['hreflang'] )
										?>" <?php
										echo $link['key']
										?>><?php
											echo htmlspecialchars( $link['text'] )
											?></a></li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
					<?php
					break;
				case 'VIEWS':
					?>
					<div id="p-views" role="navigation" class="vectorTabs<?php
					if ( count( $this->data['view_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-views-label">
						<h3 id="p-views-label"><?php $this->msg( 'views' ) ?></h3>
						<ul<?php
						$this->html( 'userlangattributes' )
						?>>
							<?php
							foreach ( $this->data['view_urls'] as $link ) {
								?>
								<li<?php
								echo $link['attributes']
								?>><span><a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" <?php
										echo $link['key']
										?>><?php
											// $link['text'] can be undefined - bug 27764
											if ( array_key_exists( 'text', $link ) ) {
												echo array_key_exists( 'img', $link )
													? '<img src="' . $link['img'] . '" alt="' . $link['text'] . '" />'
													: htmlspecialchars( $link['text'] );
											}
											?></a></span></li>
							<?php
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'ACTIONS':
					?>
					<div id="p-cactions" role="navigation" class="vectorMenu<?php
					if ( count( $this->data['action_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-cactions-label">
						<h3 id="p-cactions-label"><span><?php
							$this->msg( 'vector-more-actions' )
						?></span><a href="#"></a></h3>

						<div class="menu">
							<ul<?php $this->html( 'userlangattributes' ) ?>>
								<?php
								foreach ( $this->data['action_urls'] as $link ) {
									?>
									<li<?php
									echo $link['attributes']
									?>>
										<a href="<?php
										echo htmlspecialchars( $link['href'] )
										?>" <?php
										echo $link['key'] ?>><?php echo htmlspecialchars( $link['text'] )
											?></a>
									</li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
					<?php
					break;
				case 'PERSONAL':
					?>
					<div id="p-personal" role="navigation" class="<?php
					if ( count( $this->data['personal_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-personal-label">
						<h3 id="p-personal-label"><?php $this->msg( 'personaltools' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							$personalTools = $this->getPersonalTools();
							foreach ( $personalTools as $key => $item ) {
								echo $this->makeListItem( $key, $item );
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'SEARCH':
					?>
					<div id="p-search" role="search">
						<h3<?php $this->html( 'userlangattributes' ) ?>>
							<label for="searchInput"><?php $this->msg( 'search' ) ?></label>
						</h3>

						<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
							<?php
							if ( $this->config->get( 'VectorUseSimpleSearch' ) ) {
							?>
							<div id="simpleSearch">
								<?php
							} else {
							?>
								<div>
									<?php
							}
							?>
							<?php
							echo $this->makeSearchInput( array( 'id' => 'searchInput' ) );
							echo Html::hidden( 'title', $this->get( 'searchtitle' ) );
							// We construct two buttons (for 'go' and 'fulltext' search modes),
							// but only one will be visible and actionable at a time (they are
							// overlaid on top of each other in CSS).
							// * Browsers will use the 'fulltext' one by default (as it's the
							//   first in tree-order), which is desirable when they are unable
							//   to show search suggestions (either due to being broken or
							//   having JavaScript turned off).
							// * The mediawiki.searchSuggest module, after doing tests for the
							//   broken browsers, removes the 'fulltext' button and handles
							//   'fulltext' search itself; this will reveal the 'go' button and
							//   cause it to be used.
							echo $this->makeSearchButton(
								'fulltext',
								array( 'id' => 'mw-searchButton', 'class' => 'searchButton mw-fallbackSearchButton' )
							);
							echo $this->makeSearchButton(
								'go',
								array( 'id' => 'searchButton', 'class' => 'searchButton' )
							);
							?>
								</div>
						</form>
					</div>
					<?php

					break;
			}
		}
	}
}
