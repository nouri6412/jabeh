<?php
/**
 * Quick actions template for the listing type editor.
 *
 * @since 2.0
 */
if ( ! defined('ABSPATH') ) {
	exit;
} ?>
<div class="tab-content full-width" v-if="currentSubTab == 'quick-actions'">
	<div class="form-section">
		<h3>افزودن اقدامات سریع</h3>
		<p>با اقدامات سریع به کاربران کمک کنید تا به سرعت به جزئیات مهم آگهی دسترسی پیدا کنند. اگر لیست خالی باشد ، به جای آن از لیست پیش فرض اقدامات استفاده خواهد شد.</p>
	</div>

	<div class="editor-column col-2-3 rows row-padding">
		<div class="form-section mb10">
			<h4 class="mb5">اقدامات سریع فعال</h4>
			<p>برای ویرایش روی عملیاتی کلیک کنید. برای مرتب کردن مجدد ، آن را بکشید و رها کنید.</p>
		</div>

		<draggable v-model="single.quick_actions" :options="{group: 'quick-actions-list', handle: '.row-head'}">
			<div v-for="action, key in single.quick_actions" class="row-item" :class="action === state.single.active_quick_action ? 'open' : ''">
				<div class="row-head" @click="state.single.active_quick_action = ( action !== state.single.active_quick_action ) ? action : null">
					<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
					<div class="row-head-label">
						<h4>{{ action.label }}</h4>
						<div class="details">
							<div class="detail">{{ action.action }}</div>
						</div>
					</div>
					<div class="row-head-actions">
						<span title="Remove" @click.stop="quickActions().remove(action)" class="action red"><i class="mi delete"></i></span>
					</div>
				</div>
				<div class="row-edit">
					<div class="form-group">
						<label>آیکون</label>
						<iconpicker v-model="action.icon"></iconpicker>
					</div>

					<div class="form-group full-width">
						<label>برچسب</label>
						<atwho v-model="action.label" template="input"></atwho>
					</div>

					<div class="form-group full-width" v-if="typeof action.active_label !== 'undefined'">
						<label>برچسب فعال</label>
						<atwho v-model="action.active_label" template="input"></atwho>
					</div>

					<div class="form-group full-width" v-if="typeof action.link !== 'undefined'">
						<label>Link to</label>
						<atwho v-model="action.link" template="input" placeholder="e.g. `tel:[[phone]]`"></atwho>
					</div>

					<div class="form-group full-width" v-if="typeof action.open_new_tab !== 'undefined'">
						<label>
							<input type="checkbox" v-model="action.open_new_tab" class="form-checkbox">
							باز کردن پیوند در زبانه جدید
						</label>
					</div>

					<div class="text-right">
						<div class="btn" @click="state.single.active_quick_action = null">انجام شد</div>
					</div>
				</div>
			</div>
		</draggable>

		<div v-if="!single.quick_actions.length" class="btn btn-plain btn-block mt20">
			<i class="mi playlist_add"></i>
			هنوز هیچ اقدامی سریع اضافه نشده است.
		</div>
	</div><!--
	--><div class="editor-column col-1-3">
		<div class="form-section mb10">
			<h4 class="mb5">اقدامات از پیش تعیین شده</h4>
			<p>برای استفاده از آن ، روی عملیاتی کلیک کنید.</p>

			<div
				v-for="action in blueprints.quick_actions"
				class="btn btn-block mb10"
				@click.prevent="quickActions().add( action.action )"
				v-if="action.action !== 'custom'"
			>{{ action.label }}</div>

			<div class="text-center mt20">
				<div class="btn btn-outline mb10" @click.prevent="quickActions().add( 'custom' )">افزودن اقدام سفارشی</div>
			</div>
		</div>
	</div>
</div>