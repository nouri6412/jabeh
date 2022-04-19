<?php
if ( ! defined('ABSPATH') ) {
	exit;
}

$explore_tab_limit = absint( apply_filters( 'mylisting/type-editor/explore-tabs/limit', 3 ) );
?>

<div class="tab-content full-width" v-if="currentSubTab == 'explore-tabs'">
	<div class="form-section">
		<h3>زبانه ها</h3>
		<p>برای این نوع لیست ، برگه هایی را که باید در نوار کناری صفحه جستجو نشان داده شوند ، تنظیم کنید.</p>
	</div>

	<div class="editor-column col-2-3 rows row-padding">
		<div class="form-section mb10">
			<h4 class="mb5">زبانه های فعال</h4>
			<p>برای ویرایش بر روی یک زبانه کلیک کنید. برای مرتب کردن مجدد ، آن را بکشید و رها کنید.</h4>
		</div>

		<draggable v-model="search.explore_tabs" :options="{group: 'search-explore-tabs', handle: '.row-head'}">
			<div v-for="tab in search.explore_tabs" class="row-item" :class="tab === state.search.active_explore_tab ? 'open' : ''">
				<div class="row-head" @click="state.search.active_explore_tab = ( tab !== state.search.active_explore_tab ) ? tab : null">
					<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
					<div class="row-head-label">
						<h4>{{ tab.label }}</h4>
						<div class="details">
							<div class="detail">{{ capitalize( tab.type ) }}</div>
						</div>
					</div>
					<div class="row-head-actions">
						<span title="Remove" @click.stop="searchTab().removeTab(tab)" class="action red"><i class="mi delete"></i></span>
					</div>
				</div>
				<div class="row-edit">
					<div class="form-group">
						<label>برچسب</label>
						<input type="text" v-model="tab.label">
					</div>

					<div class="form-group">
						<label>آیکون</label>
						<iconpicker v-model="tab.icon"></iconpicker>
					</div>

					<div v-show="tab.type !== 'search-form'">
						<div class="form-group">
							<label>مرتب سازی بر اساس</label>
							<div class="select-wrapper">
								<select v-model="tab.orderby">
									<option value="name">نام</option>
									<option value="count">تعداد</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label>ترتیب</label>
							<div class="select-wrapper">
								<select v-model="tab.order">
									<option value="ASC">صعودی</option>
									<option value="DESC">نزولی</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label>
								<input type="checkbox" v-model="tab.hide_empty" class="form-checkbox">
								مخفی کردن گزینه های خالی؟
							</label>
							<p>در صورت علامت گذاری ، اصطلاحاتی که هیچ نتیجه ای را بازیابی نمی کنند نشان داده نمی شوند.</p>
						</div>
					</div>

					<div class="text-right">
						<div class="btn" @click="state.search.active_explore_tab = null">انجام شد</div>
					</div>
				</div>
			</div>
		</draggable>
		<div v-if="search.explore_tabs.length >= <?php echo $explore_tab_limit ?>" class="mt40 text-center">
			<div class="btn btn-plain">
				<i class="mi error_outline"></i>
				شما به حداکثر تعداد برگه های مجاز رسیده اید (<?php echo $explore_tab_limit ?>).
			</div>
		</div>
		<div v-else-if="!search.explore_tabs.length" class="mt40 text-center">
			<div class="btn btn-plain">
				<i class="mi playlist_add"></i>
				زبانه ای افزوده نشده
			</div>
		</div>
	</div><!--
	--><div class="editor-column col-1-3">
		<div class="form-section mb10" :class="search.explore_tabs.length >= <?php echo $explore_tab_limit ?> ? 'ml-overlay-disabled' : ''">
			<h4 class="mb5">زبانه های فعال</h4>
			<p>برای استفاده روی زبانه کلیک کنید</h4>

			<div
				v-for="preset in blueprints.explore_tabs"
				class="btn btn-secondary btn-block mb10"
				@click.prevent="searchTab().addTab( preset )"
				v-if="search.explore_tabs.filter( function(t) { return t.type === preset.type } ).length === 0"
			>{{ preset.label }}</div>
		</div>
	</div>
</div>