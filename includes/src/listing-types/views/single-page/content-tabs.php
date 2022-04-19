<div class="tab-content full-width" v-if="currentSubTab == 'pages'">
	<div class="form-section">
		<h3>محتوای آگهی را ایجاد و سازماندهی کنید</h3>
		<p>مطمئن نیستم این چیه؟ <a href="https://docs.mylistingtheme.com/article/single-page-content-and-tabs/" target="_blank">مشاهده مستنداات</a>.</p>
	</div>

	<div class="editor-column col-2-3 rows row-padding">
		<div class="form-section mb10">
			<h4 class="mb5">زبانه ها</h4>
			<p>برای ویرایش بر روی یک تب کلیک کنید. برای مرتب کردن مجدد ، آن را بکشید و رها کنیدr.</p>

			<draggable v-model="single.menu_items" :options="{group: 'single-menu', handle: '.row-head'}">
				<div v-for="menu_item, key in single.menu_items" class="row-item">
					<div class="row-head" @click="setTab( 'single-page', 'edit-tab-'+key )">
						<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
						<div class="row-head-label">
							<h4>{{ menu_item.label || '(no label)' }}</h4>
							<div class="details">
								<div class="detail">#{{ menu_item.slug || slugify( menu_item.label ) }}</div>
							</div>
						</div>
						<div class="row-head-actions">
							<span title="Remove" @click.stop="deleteMenuItem( menu_item )" class="action red"><i class="mi delete"></i></span>
						</div>
					</div>
				</div>
			</draggable>

			<div v-if="!single.menu_items.length" class="btn btn-plain btn-block mt20">
				<i class="mi playlist_add"></i>
				زبانه ای افزوده نشده.
			</div>
		</div>
	</div><!--
	--><div class="editor-column col-1-3">
		<div class="form-section mb10">
			<h4 class="mb5">زبانه های از پیش تعیین شده</h4>
			<p>برای استفاده روی زبانه کلیک کنید.</p>

			<div
				v-for="label, key in { main: 'پروفایل', comments: 'دیدگاه ها', related_listings: 'آگهی های مرتبط', store: 'فروشگاه', bookings: 'رزروها', custom: 'سفارشی' }"
				class="btn btn-block mb10"
				@click.prevent="addMenuItem( key )"
				v-if="key !== 'custom'"
			>{{ label }}</div>

			<div class="text-center mt20">
				<div class="btn btn-outline mb10" @click.prevent="addMenuItem( 'custom' )">افزودن زبانه سفارشی</div>
			</div>
		</div>
	</div>
</div>

<div v-for="menu_item, key in single.menu_items" v-if="currentSubTab === 'edit-tab-'+key" class="tab-content full-width">

	<div class="mb20 text-center">
		<div class="btn btn-plain btn-xs" @click="setTab( 'single-page', 'pages' )"><i class="mi keyboard_backspace"></i> همه زبانه ها</div>
		<div
			v-for="_menu_item, _key in single.menu_items"
			class="btn btn-xs mb10"
			@click.prevent="setTab( 'single-page', 'edit-tab-'+_key )"
			:class="menu_item === _menu_item ? 'btn-secondary' : 'btn-plain'"
			style="margin-right: 5px;"
		>{{ _menu_item.label || '(no label)' }}</div>
	</div>

	<div class="form-section mb20 full-width">
		<h3>{{ menu_item.label || '(no label)' }}</h3>
		<p>تنظیمات را برای این زبانه اعمال کنید</p>
	</div>

	<div class="content-tab-settings">
		<div class="form-group">
			<label>برچسب</label>
			<input type="text" v-model="menu_item.label">
		</div><!--
	  --><div class="form-group">
			<label>نامک</label>
			<input type="text" :value="menu_item.slug" @input="menu_item.slug = slugify( $event.target.value )" :placeholder="slugify( menu_item.label )">
			<p class="mt5 mb0">این مقدار می تواند به آدرس اینترنتی لیست اضافه شود تا مستقیماً به این برگه پیوند یابد.</p>
		</div><!--
	  --><div class="form-group" v-if="menu_item.page === 'store'">
	  		<label class="mb10">اگر محصولی وجود ندارد ، زبانه را مخفی کنید</label>
			<label class="form-switch">
				<input type="checkbox" v-model="menu_item.hide_if_empty">
				<span class="switch-slider"></span>
			</label>
		</div><!--
	  --><div class="form-group" v-if="['main', 'custom'].indexOf(menu_item.page) !== -1">
			<label>Layout</label>
			<div class="select-wrapper">
				<select v-model="menu_item.template">
					<option value="masonry">ماسنری (2ستون)</option>
					<option value="two-columns">2 ستون</option>
					<option value="content-sidebar">دو سوم / یک سوم</option>
					<option value="sidebar-content">یک سوم / دو سوم</option>
					<option value="full-width">تک ستون</option>
				</select>
			</div>
		</div><!--
	  --><div class="form-group" v-if="menu_item.page == 'store'">
			<label>نمایش محصولات از فیلد:</label>
			<div class="select-wrapper">
				<select v-model="menu_item.field">
					<option v-for="field in fieldsByType(['select-products', 'select-product'])" :value="field.slug">{{ field.label }}</option>
				</select>
			</div>
		</div><!--
	  --><div class="form-group" v-if="menu_item.page === 'related_listings'">
			<label>
				فیلد آگهی های مشابه
				<a href="#" class="cts-show-tip pull-right" data-tip="related-listings">اطلاعات بیشتر</a>
			</label>
			<div class="select-wrapper">
				<select v-model="menu_item.related_listing_field">
					<option v-for="field in fieldsByType(['related-listing'])" :value="field.slug">{{ field.label }}</option>
				</select>
			</div>
		</div><!--
	  --><div class="form-group" v-if="menu_item.page == 'bookings'">
			<label>روش رزرو:</label>
			<div class="select-wrapper">
				<select v-model="menu_item.provider">
					<option value="basic-form">فرم پایه</option>
					<option value="timekit">کیت زمانی</option>
				</select>
			</div>
		</div><!--
	  --><div class="form-group" v-if="menu_item.page == 'bookings' && menu_item.provider == 'basic-form'">
			<label>ارسال ایمیل به:</label>
			<div class="select-wrapper">
				<select v-model="menu_item.field">
					<option v-for="field in fieldsByType(['email'])" :value="field.slug">{{ field.label }}</option>
				</select>
			</div>
		</div><!--
	  --><div class="form-group" v-if="menu_item.page == 'bookings' && menu_item.provider == 'basic-form'">
			<label>شناسه فرم تماس:</label>
			<input type="text" v-model="menu_item.contact_form_id">
		</div><!--
	  --><div class="form-group" v-if="menu_item.page == 'bookings' && menu_item.provider == 'timekit'">
			<label>شناسنه ویجت کیت زمانی:</label>
			<div class="select-wrapper">
				<select v-model="menu_item.field">
					<option v-for="field in fieldsByType(['text'])" :value="field.slug">{{ field.label }}</option>
				</select>
			</div>
		</div>
	</div>

	<div v-if="menu_item.page == 'main' || menu_item.page == 'custom'" class="mt10">
		<div class="editor-column">
			<div class="tab-columns" :class="['template-'+menu_item.template, menu_item.sidebar.length ? 'sidebar-filled' : 'sidebar-empty']">
				<?php foreach ( ['layout', 'sidebar'] as $key => $column ):
					$layout_classes = "{
						'col-1-2': menu_item.template === 'two-columns',
						'col-2-3': menu_item.template === 'masonry' && '{$column}' === 'layout'
								   || menu_item.template === 'content-sidebar' && '{$column}' === 'layout'
								   || menu_item.template === 'sidebar-content' && '{$column}' === 'layout'
								   || menu_item.template === 'full-width' && '{$column}' === 'layout',
						'col-1-3': menu_item.template === 'masonry' && '{$column}' === 'sidebar'
								   || menu_item.template === 'content-sidebar' && '{$column}' === 'sidebar'
								   || menu_item.template === 'sidebar-content' && '{$column}' === 'sidebar'
								   || menu_item.template === 'full-width' && '{$column}' === 'sidebar',
						'pull-right': menu_item.template === 'sidebar-content' && '{$column}' === 'layout',
					}";
					?><div class="tab-column column-<?php echo $column ?> editor-column rows" :class="[ menu_item.<?php echo $column ?>.length ? 'filled' : 'empty', <?php echo $layout_classes ?> ]">
						<div class="column-inner">
							<?php if ( $column === 'layout' ): ?>
								<h4>ستون اصلی</h4>
							<?php endif ?>

							<?php if ( $column === 'sidebar' ): ?>
								<h4>ستون سایدبار/h4>
							<?php endif ?>

							<div class="text-center mt40 mb40" v-if="! menu_item.<?php echo $column ?>.length">
								<div class="btn btn-plain btn-xs">
									<i class="mi info_outline"></i>
									<?php if ( $column === 'layout' ): ?>
										شما هنوز هیچ بلوک محتوایی اضافه نکرده اید.
									<?php endif ?>
									<?php if ( $column === 'sidebar' ): ?>
										شما هیچ بلوک محتوایی به سایدبار اضافه نکرده اید.
									<?php endif ?>
								</div>
							</div>
							<draggable v-model="menu_item.<?php echo $column ?>" :options="{group: 'layout-blocks', handle: '.row-head'}">
								<div v-for="block in menu_item.<?php echo $column ?>" class="row-item" :class="(block === state.single.active_block ? 'open' : '')">
									<div @click="state.single.active_block = ( block !== state.single.active_block ) ? block : null" class="row-head">
										<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
										<div class="row-head-label">
											<h4>{{ block.title }}</h4>
											<div class="details">
												<div class="detail">{{ block.type }}</div>
											</div>
										</div>
										<div class="row-head-actions">
											<span title="Move" @click.stop="moveBlock(block, '<?php echo $column ?>', menu_item)" class="action blue"><i class="mi compare_arrows"></i></span>
											<span title="Delete this field" @click.stop="deleteBlock(block, '<?php echo $column ?>', menu_item)" class="action red"><i class="mi delete"></i></span>
										</div>
									</div>

									<div class="row-edit">
										<?php foreach ( $designer->get_block_types() as $block ): ?>
											<?php echo $block->print_options() ?>
										<?php endforeach ?>

										<div class="text-right">
											<div class="btn" @click="state.single.active_block = null">Done</div>
										</div>
									</div>
								</div>
							</draggable>
						</div>
					</div><?php
				endforeach ?>
				<div style="clear:both;"></div>
			</div>
		</div><!--
		--><div class="editor-column add-new-content-block mt20">
			<h4 class="mb20">افزودن بلوک جدید</h4>

			<div class="content-blocks">
				<div
					v-for="block in blueprints.layout_blocks"
					class="btn btn-block mb10"
					@click.prevent="addBlock( block.type, menu_item )"
				>{{ block.title }}</div>
			</div>
		</div>
	</div>
</div>