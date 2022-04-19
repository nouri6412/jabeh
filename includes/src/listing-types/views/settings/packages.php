<packages inline-template v-if="currentSubTab === 'packages'">
	<div class="tab-content settings-packages full-width">
		<div class="form-section">
			<h3>بسته های پرداخت آگهی </h3>
			<p>تعیین کنید که کاربر هنگام ارسال لیست از این نوع ، از چه بسته هایی می تواند انتخاب کند.</p>
		</div>

		<div class="editor-column col-2-3 rows row-padding">
			<h4>فعالسازی بسته های پرداخت آگهی </h4>
			<label class="form-switch mb20">
				<input type="checkbox" v-model="$root.settings.packages.enabled">
				<span class="switch-slider"></span>
			</label>

			<div :class="! $root.settings.packages.enabled ? 'ml-overlay-disabled' : ''">
				<draggable v-model="$root.settings.packages.used" :options="{group: 'settings-packages', handle: '.row-head'}">
					<div v-for="package in $root.settings.packages.used" class="row-item" :class="isActive( package ) ? 'open' : ''">
						<div @click="activePackage = ( isActive( package ) ? null : package )" class="row-head">
							<div class="row-head-toggle"><i class="mi chevron_right"></i></div>
							<div class="row-head-label">
								<h4>{{ $root.getPackageTitle( package ) }}</h4>
								<div class="details">
									<div class="detail">محصول: {{ $root.getPackageDefaultTitle( package ) }}</div>
								</div>
							</div>
							<div class="row-head-actions">
								<span title="This package is highlighted" class="action gold" v-show="package.featured"><i class="mi star"></i></span>
								<span title="Remove" @click.stop="remove( package )" class="action red"><i class="mi delete"></i></span>
							</div>
						</div>
						<div class="row-edit">
							<div class="form-group">
								<label>برچسب</label>
								<input type="text" v-model="package.label" :placeholder="$root.getPackageDefaultTitle( package )">
								<p class="mb0">برای استفاده از برچسب پیش فرض بسته ، خالی بگذارید.</p>
							</div>

							<div class="form-group">
								<label>توضیحات</label>
								<textarea v-model="package.description" placeholder="هر ویژگی را در یک سطر قرار دهید"></textarea>
								<p class="mb0">برای استفاده از توضیحات پیش فرض بسته ، خالی بگذارید.</p>
							</div>

							<div class="form-group">
								<div class="mb5"></div>
								<label><input type="checkbox" v-model="package.featured" class="form-checkbox"> ویژه?</label>
								<p class="mb0">بسته های ویژه برجسته می شوند.</p>
							</div>

							<div class="text-right">
								<div class="btn" @click="activePackage = null">انجام شد</div>
							</div>
						</div>
					</div>
				</draggable>

				<div class="text-center mt40" v-if="!$root.settings.packages.used.length">
					<div class="btn btn-plain">
						شما هنوز هیچ برنامه لیست پولی اضافه نکرده اید. روی یک محصول کلیک کنید
						در سمت راست ، یا از دکمه "ایجاد محصول جدید" استفاده کنید.
					</div>
				</div>
			</div>
		</div><!--
		--><div class="editor-column col-1-3" :class="! $root.settings.packages.enabled ? 'ml-overlay-disabled' : ''">
			<h4>لیست پکیج ها</h4>
			<p>همه محصولات ووکامرس از نوع "پکیج های آگهی" یا "آگهی اشتراک" در اینجا ظاهر می شوند.</p>

			<div
				v-for="name, id in $root.state.settings.packages"
				@click="add( id )"
				class="btn btn-secondary btn-block mb10"
				v-if="! isUsed( id )"
			>{{ name }}</div>

			<div class="text-center mt40">
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ) ?>" target="_blank" class="btn btn-outline">ایجاد محصول جدید</a>
			</div>
		</div>
	</div>
</packages>